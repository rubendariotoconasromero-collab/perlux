<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function viewThankYou(Request $request)
    {
        $orderReference = $request->query('order');
        return view('site.thankyou', ['orderReference' => $orderReference]);
    }

    public function viewCheckout()
    {
        return view('site.checkout');
    }

    public function processOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'shipping_address' => 'required|array',
            'payment_method' => 'required|in:online,contraentrega',
            'customer_phone' => 'required',
        ]);

        $user = auth()->user();
        $items = $request->items;
        $totalAmount = 0;
        
        // Array para recolectar errores de stock por índice [0 => 'Error...', 2 => 'Error...']
        $stockErrors = []; 

        DB::beginTransaction();

        try {
            // 1. Generar Referencia
            $externalReference = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

            // 2. Preparar dirección
            $addr = $request->shipping_address;
            $addressString = "{$addr['street']} {$addr['number']}, {$addr['district']}, {$addr['province']}, {$addr['department']}";

            // 3. Crear Orden (Pending)
            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'external_reference' => $externalReference,
                'customer_name' => $user ? ($user->name . ' ' . $user->last_name) : 'Invitado',
                'customer_email' => $user ? $user->email : 'guest@email.com',
                'customer_phone' => $request->customer_phone,
                'shipping_address' => substr($addressString, 0, 255),
                'total_amount' => 0,
                'payment_status' => 'pending',
                'additional_info' => $request->payment_method
            ]);

            // 4. Procesar Items
            foreach ($items as $index => $item) {
                $product = Product::find($item['ProductID']);
                
                if (!$product) {
                    // Error crítico, este sí puede detener todo
                    throw new \Exception("El producto con ID {$item['ProductID']} no existe.");
                }

                $qty = intval($item['quantity']); // Asegurar entero
                $realPrice = $product->Price;
                $variant = null;

                // A. LÓGICA DE VARIANTES
                if (isset($item['selectedVariant']) && !empty($item['selectedVariant'])) {
                    
                    $variant = ProductVariant::where('ProductID', $product->ProductID)
                        ->where('SizeID', $item['selectedVariant']['size']['SizeID'])
                        ->where('ColorID', $item['selectedVariant']['color']['ColorID'])
                        ->first();

                    if ($variant) {
                        // --- DEBUGGING ---
                        // Esto escribirá en storage/logs/laravel.log lo que el sistema ve
                        \Illuminate\Support\Facades\Log::info("Validando Stock Variante: Producto {$product->Name} - TallaID: {$variant->SizeID} - Stock BD: {$variant->StockQuantity} - Solicitado: {$qty}");

                        // Validar Stock Variante
                        if ($variant->StockQuantity < $qty) {
                            $stockErrors[$index] = "Agotado (Stock: {$variant->StockQuantity})";
                            continue; // Saltamos al siguiente item, pero ya marcamos el error
                        }
                        
                        if ($variant->Price) {
                            $realPrice = $variant->Price;
                        }
                    } else {
                        // El frontend mandó variante, pero no existe en BD
                        $stockErrors[$index] = "Variante no disponible.";
                        continue;
                    }
                } else {
                    // B. LÓGICA DE PRODUCTO BASE (Sin variante)
                    if ($product->StockQuantity < $qty) {
                        $stockErrors[$index] = "Agotado (Stock: {$product->StockQuantity})";
                        continue;
                    }
                }

                // Si hubo errores previos en otros items, no tiene caso procesar OrderDetail,
                // pero seguimos validando el resto para mostrar todos los errores de una vez.
                if (!empty($stockErrors)) continue;

                // C. CÁLCULOS
                $subtotal = $realPrice * $qty;
                $totalAmount += $subtotal;

                // D. CREAR DETALLE
                OrderDetail::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $product->ProductID,
                    'quantity' => $qty,
                    'unit_price' => $realPrice,
                    'subtotal' => $subtotal,
                    'SizeID' => $variant ? $variant->SizeID : null,
                    'product_name' => $product->Name,
                    'product_snapshot' => [
                        'color' => $item['selectedVariant']['color']['ColorName'] ?? null,
                        'size' => $item['selectedVariant']['size']['SizeName'] ?? null,
                        'image' => $item['Image'] ?? null
                    ]
                ]);

                // E. DESCONTAR STOCK
                $product->decrement('StockQuantity', $qty);
                if ($variant) {
                    $variant->decrement('StockQuantity', $qty);
                }
            }

            // --- VERIFICACIÓN FINAL DE ERRORES ---
            if (!empty($stockErrors)) {
                DB::rollBack(); // Cancelamos todo
                return response()->json([
                    'status' => 'error',
                    'message' => 'Problemas de stock en el carrito.',
                    'stock_errors' => $stockErrors // Devolvemos el array mapeado por índice
                ], 422);
            }

            // 5. Guardar Total Final
            $order->total_amount = $totalAmount;
            $order->save();

            DB::commit();

            $publicKey = env('CULQI_PUBLIC_KEY');
            
            return response()->json([
                'status' => 'success',
                'order_id' => $order->OrderID,
                'external_reference' => $externalReference,
                'total_amount' => $totalAmount,
                'culqi_public_key' => $publicKey ? $publicKey : 'pk_test_DEMO_MODE_NO_KEY',
                'mode' => $publicKey ? 'live' : 'dev'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmOnlinePayment(Request $request)
    {
        $order = Order::where('external_reference', $request->order_number)->firstOrFail();
        
        // MODO BYPASS: SI NO HAY CLAVE SECRETA CONFIGURADA
        if (!env('CULQI_SECRET_KEY')) {
            // Simulamos éxito automáticamente
            $order->payment_status = 'paid';
            $order->payment_id = 'ch_test_SIMULATED_' . time();
            $order->payer_info = ['source' => 'Modo Desarrollo Sin Claves'];
            $order->save();

            return response()->json(['status' => 'paid', 'message' => 'Pago simulado exitosamente (Dev Mode)']);
        }

        // MODO REAL: SI HAY CLAVE, CONECTAMOS CON CULQI
        try {
            $SECRET_KEY = env('CULQI_SECRET_KEY');
            
            // Inicializar llamada a Culqi (usando cURL nativo para no depender de librerías extra por ahora)
            $url = "https://api.culqi.com/v2/charges";
            
            $data = [
                "amount" => intval($order->total_amount * 100), // En céntimos
                "currency_code" => "PEN",
                "email" => $request->email,
                "source_id" => $request->token // Token que viene del frontend
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $SECRET_KEY
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $jsonResponse = json_decode($response);

            if ($httpCode == 201) {
                // Pago Exitoso Real
                $order->payment_status = 'paid';
                $order->payment_id = $jsonResponse->id;
                $order->payer_info = $jsonResponse->source;
                $order->save();
                return response()->json(['status' => 'paid']);
            } else {
                // Pago Rechazado Real
                throw new \Exception($jsonResponse->user_message ?? 'Error al procesar el pago con Culqi.');
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}