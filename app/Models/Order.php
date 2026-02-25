<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'OrderID';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'external_reference',
        'payment_id',
        'payment_status',
        'total_amount',
        'currency',
        'payer_info',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'additional_info'
    ];

    protected $casts = [
        'payer_info' => 'array',
        'total_amount' => 'decimal:2'
    ];

    // Relación con el usuario (si usas autenticación)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con los detalles del pedido
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'OrderID', 'OrderID');
    }
}
