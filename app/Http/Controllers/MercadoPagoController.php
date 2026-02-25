<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\BackUrls;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;




class MercadoPagoController extends Controller
{
    


    public function indexPasarela(){
        return view('site.pasarela');
    }

    public function __construct()
    {
        // Configurar el access token
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function createPreference(Request $request)
    {
        try {
            // Crear el cliente de preferencias
            $client = new PreferenceClient();
            
            // Preparar los items
            $items = [];
            foreach ($request->items as $itemData) {
                $items[] = [
                    "id" => $itemData['id'] ?? null,
                    "title" => $itemData['title'],
                    "description" => $itemData['description'],
                    "picture_url" => $itemData['picture_url'] ?? null,
                    "category_id" => $itemData['category_id'] ?? 'others',
                    "quantity" => (int)$itemData['quantity'],
                    "currency_id" => $itemData['currency_id'] ?? 'PEN',
                    "unit_price" => (float)$itemData['unit_price']
                ];
            }
            
            // Preparar los datos de la preferencia
            $preferenceData = [
                "items" => $items,
                "back_urls" => [
                    "success" => $request->back_urls['success'] ?? url('/pago-exitoso'),
                    "failure" => $request->back_urls['failure'] ?? url('/pago-fallido'),
                    "pending" => $request->back_urls['pending'] ?? url('/pago-pendiente')
                ],
                "auto_return" => $request->auto_return ?? 'approved',
                "external_reference" => $request->external_reference,
                "notification_url" => $request->notification_url ?? url('/mercadopago/webhook'),
                "statement_descriptor" => $request->statement_descriptor ?? 'SKINLY'
            ];
            
            // Agregar información del pagador si está presente
            if ($request->has('payer')) {
                $preferenceData["payer"] = [
                    "name" => $request->payer['name'],
                    "surname" => $request->payer['surname'],
                    "email" => $request->payer['email'],
                ];
                
                // Agregar teléfono si existe
                if (isset($request->payer['phone'])) {
                    $preferenceData["payer"]["phone"] = $request->payer['phone'];
                }
                
                // Agregar identificación si existe
                if (isset($request->payer['identification'])) {
                    $preferenceData["payer"]["identification"] = $request->payer['identification'];
                }
                
                // Agregar dirección si existe
                if (isset($request->payer['address'])) {
                    $preferenceData["payer"]["address"] = $request->payer['address'];
                }
            }
            
            // Agregar información adicional si existe
            if ($request->has('additional_info') && !empty($request->additional_info)) {
                $preferenceData["additional_info"] = $request->additional_info;
            }
            
            // Crear la preferencia
            $preference = $client->create($preferenceData);
            
            return response()->json([
                'id' => $preference->id,
                'init_point' => $preference->init_point,
                'sandbox_init_point' => $preference->sandbox_init_point
            ]);
            
        } catch (MPApiException $e) {
            \Log::error('Error MercadoPago API: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear la preferencia de pago',
                'message' => $e->getMessage(),
                'details' => $e->getApiResponse()
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Error general: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear la preferencia de pago',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $input = $request->all();
            
            \Log::info('Webhook MercadoPago recibido', $input);
            
            // Verificar que es una notificación de tipo payment
            if (isset($input['type']) && $input['type'] == 'payment') {
                $dataId = $input['data']['id'] ?? null;
                
                if ($dataId) {
                    // Procesar la notificación de pago
                    $this->processPaymentNotification($dataId);
                }
            }
            
            return response()->json(['status' => 'ok']);
            
        } catch (\Exception $e) {
            \Log::error('Error en webhook MercadoPago: ' . $e->getMessage());
            return response()->json(['error' => 'Error processing webhook'], 500);
        }
    }

    private function processPaymentNotification($paymentId)
    {
        try {
            // Crear el cliente de pagos
            $client = new PaymentClient();
            
            // Obtener la información del pago
            $payment = $client->get($paymentId);
            
            \Log::info('Procesando pago: ' . $paymentId, [
                'status' => $payment->status,
                'external_reference' => $payment->external_reference
            ]);
            
            // Buscar la orden por external_reference
            if ($payment->external_reference) {
                $order = Order::where('external_reference', $payment->external_reference)->first();
                
                if ($order) {
                    // Actualizar el estado del pedido según el estado del pago
                    $paymentStatus = $this->mapPaymentStatus($payment->status);
                    
                    $order->update([
                        'payment_status' => $paymentStatus,
                        'payment_id' => $paymentId,
                        'payment_method' => $payment->payment_method_id ?? null,
                        'payment_data' => json_encode($payment)
                    ]);
                    
                    \Log::info('Orden actualizada: ' . $order->OrderID . ' con estado: ' . $paymentStatus);
                }
            }
            
        } catch (MPApiException $e) {
            \Log::error('Error MercadoPago API procesando pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Error procesando notificación de pago: ' . $e->getMessage());
        }
    }

    private function mapPaymentStatus($mpStatus)
    {
        $statusMap = [
            'approved' => 'paid',
            'pending' => 'pending',
            'rejected' => 'failed',
            'cancelled' => 'cancelled',
            'refunded' => 'refunded',
            'charged_back' => 'charged_back'
        ];
        
        return $statusMap[$mpStatus] ?? 'unknown';
    }

    public function saveOrder(Request $request)
    {
        try {
            \DB::beginTransaction();
            
            // Crear el pedido principal
            $order = Order::create([
                'external_reference' => $request->external_reference,
                'total_amount' => $request->total_amount,
                'currency' => $request->currency ?? 'PEN',
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone ?? null,
                'shipping_address' => $request->shipping_address ?? null,
                'additional_info' => $request->additional_info ?? null,
                'payer_info' => $request->payer_info ?? null,
                'payment_status' => 'pending', // Estado inicial
                'user_id' => auth()->id() ?? null
            ]);
            
            // Crear los detalles del pedido
            foreach ($request->items as $item) {
                // Obtener información del producto
                $product = Product::find($item['product_id']);
                
                OrderDetail::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                    'SizeID' => $item['size_id'] ?? null,
                    'product_name' => $item['title'],
                    'product_snapshot' => $product ? $product->toArray() : null
                ]);
                
                // Opcional: Reservar el stock del producto
                if ($product) {
                    // Solo decrementar cuando el pago esté aprobado
                    // $product->decrement('StockQuantity', $item['quantity']);
                }
            }
            
            \DB::commit();
            
            return response()->json([
                'success' => true,
                'order_id' => $order->OrderID
            ]);
            
        } catch (\Exception $e) {
            \DB::rollback();
            
            \Log::error('Error guardando pedido: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Error al guardar el pedido',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrderStatus($externalReference)
    {
        try {
            $order = Order::where('external_reference', $externalReference)->first();
            
            if (!$order) {
                return response()->json(['error' => 'Pedido no encontrado'], 404);
            }
            
            return response()->json([
                'order_id' => $order->OrderID,
                'payment_status' => $order->payment_status,
                'total_amount' => $order->total_amount,
                'payment_id' => $order->payment_id ?? null
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $status = $request->query('status');
        $externalReference = $request->query('external_reference');
        
        // Procesar el pago exitoso
        return view('site.payment-success', compact('paymentId', 'status', 'externalReference'));
    }

    public function handlePaymentFailure(Request $request)
    {
        $externalReference = $request->query('external_reference');
        
        return view('site.payment-failure', compact('externalReference'));
    }

    public function handlePaymentPending(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $externalReference = $request->query('external_reference');
        
        return view('site.payment-pending', compact('paymentId', 'externalReference'));
    }

    public function debugRequest(Request $request)
    {
        return response()->json([
            'received_data' => $request->all(),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->url(),
            'validation_rules' => [
                'items' => 'required|array|min:1',
                'items.*.title' => 'required|string|max:256',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0.01',
                'external_reference' => 'required|string|max:256',
            ]
        ]);
    }

    public function testConnection()
    {
        try {
            // Prueba simple de conexión
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            return response()->json([
                'success' => empty($error),
                'http_code' => $httpCode,
                'error' => $error,
                'curl_version' => curl_version(),
                'response_headers' => $response
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
