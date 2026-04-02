<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductCertificate;

class OrderController extends Controller
{
    public function getUserOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['orderDetails']) // Cargamos los detalles (productos comprados)
            ->orderBy('created_at', 'desc') // Los más recientes primero
            ->get();

        return response()->json($orders);
    }

    public function verifyCertificate(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Buscamos el certificado y cargamos la relación del detalle del pedido
        $certificate = ProductCertificate::with(['orderDetail'])
            ->where('code', trim($request->code))
            ->first();

        // Si no existe, devolvemos error 404
        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'El código ingresado no existe en nuestra base de datos. Por favor, verifica que esté escrito correctamente.'
            ], 404);
        }

        // Si existe, preparamos la data del producto para el frontend
        $detail = $certificate->orderDetail;
        
        return response()->json([
            'status' => 'success',
            'message' => '¡Certificado válido! Este producto es 100% original.',
            'data' => [
                'code' => $certificate->code,
                'product_name' => $detail->product_name ?? 'Producto Perlux',
                'date' => $certificate->created_at->format('d/m/Y'),
                'snapshot' => $detail->product_snapshot ?? null
            ]
        ]);
    }
}
