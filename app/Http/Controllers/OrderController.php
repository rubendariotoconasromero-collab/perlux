<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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
}
