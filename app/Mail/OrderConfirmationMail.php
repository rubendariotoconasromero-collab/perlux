<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Buscamos los detalles manualmente para evitar problemas de relaciones en el modelo
        $detalles = \App\Models\OrderDetail::where('OrderID', $this->order->OrderID)->get();

        return $this->subject('Confirmación de Pedido - ' . $this->order->external_reference)
                    ->view('emails.order_confirmation')
                    ->with([
                        'order' => $this->order,
                        'detalles' => $detalles // Pasamos la variable explícitamente
                    ]);
    }
}