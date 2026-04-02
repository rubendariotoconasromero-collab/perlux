<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCertificate;
use App\Models\OrderDetail;

class AdminOrderController extends Controller
{

    public function indexAdmin(){
        return view('admin.frmOrder');                                                           
    }

    public function index(Request $request)
    {
        // Iniciamos la consulta cargando los detalles para el modal
        // y ordenando por el más reciente
        $query = Order::with('orderDetails.certificates')
        ->orderBy('created_at', 'desc');

        // 1. Filtro de Búsqueda (Texto)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('external_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // 2. Filtro de Estado (Select)
        if ($request->has('status') && !empty($request->status)) {
            $query->where('payment_status', $request->status);
        }

        // Retornamos paginado (Vue recibirá data, current_page, etc.)
        $orders = $query->paginate(10);

        return response()->json($orders);
    }

    /**
     * Actualizar el estado del pedido
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->status;
        $order->save();

        // Opcional: Aquí podrías enviar un email al cliente notificando el cambio
        // Mail::to($order->customer_email)->send(new OrderStatusChanged($order));

        return response()->json([
            'success' => true, 
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    /**
     * Exportar pedidos a CSV (Nativo, sin librerías pesadas)
     */
    public function export()
    {
        $fileName = 'pedidos_perlux_' . date('Y-m-d_H-i') . '.csv';
        $orders = Order::orderBy('created_at', 'desc')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Referencia', 'Cliente', 'Email', 'Teléfono', 'Estado', 'Total', 'Fecha', 'Dirección');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $row['ID']  = $order->OrderID;
                $row['Referencia'] = $order->external_reference;
                $row['Cliente'] = $order->customer_name;
                $row['Email'] = $order->customer_email;
                $row['Teléfono'] = $order->customer_phone;
                $row['Estado'] = $order->payment_status;
                $row['Total'] = $order->total_amount;
                $row['Fecha'] = $order->created_at->format('d/m/Y H:i');
                $row['Dirección'] = $order->shipping_address;

                fputcsv($file, array($row['ID'], $row['Referencia'], $row['Cliente'], $row['Email'], $row['Teléfono'], $row['Estado'], $row['Total'], $row['Fecha'], $row['Dirección']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function syncCertificates(Request $request, $orderDetailId)
    {
        $request->validate([
            'codes' => 'array'
        ]);

        $detail = OrderDetail::findOrFail($orderDetailId);

        ProductCertificate::where('order_detail_id', $orderDetailId)->delete();

        $savedCertificates = [];
        if ($request->codes) {
            foreach ($request->codes as $code) {
                if (!empty(trim($code))) {
                    $savedCertificates[] = ProductCertificate::create([
                        'order_detail_id' => $orderDetailId,
                        'code' => trim($code)
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'certificates' => $savedCertificates
        ]);
    }
    
}
