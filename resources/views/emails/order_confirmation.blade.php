<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background-color: #000000; padding: 20px; text-align: center; color: #ffffff; }
        .content { padding: 30px; }
        .footer { background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #777; }
        .order-ref { font-size: 24px; font-weight: bold; color: #000; text-align: center; padding: 15px; background: #f8f9fa; border-radius: 4px; margin: 20px 0; border: 1px dashed #ccc;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { color: #888; text-transform: uppercase; font-size: 12px; }
        .total-row { font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Gracias por tu compra en Perlux!</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $order->customer_name }}</strong>,</p>
            <p>Hemos recibido tu pedido correctamente. Estamos preparando todo para que lo recibas lo antes posible.</p>
            
            <div class="order-ref">
                Pedido #{{ $order->external_reference }}
            </div>

            <p><strong>Dirección de envío:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Método de pago:</strong> {{ $order->payment_status === 'paid' ? 'Pagado (Tarjeta/Yape)' : 'Contraentrega' }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align: center;">Cant.</th>
                        <th style="text-align: right;">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalles as $item)
                    <tr>
                        <td>
                            {{ $item->product_name }} <br>
                            @if(is_array($item->product_snapshot) || is_object($item->product_snapshot))
                                @php $snap = (array) $item->product_snapshot; @endphp
                                <span style="font-size: 12px; color: #888;">
                                    {{ $snap['color'] ?? '' }} / {{ $snap['size'] ?? '' }}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">S/ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right; border-bottom: none;">Total Pagado:</td>
                        <td style="text-align: right; border-bottom: none;">S/ {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Si tienes alguna pregunta, responde a este correo (ventas@perluxbyjd.com).</p>
            <p>&copy; {{ date('Y') }} Perlux By JD. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>