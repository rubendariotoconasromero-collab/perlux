<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderdetails';

    protected $primaryKey = 'OrderDetailID';
    public $timestamps = true;

    protected $fillable = [
        'OrderID',
        'ProductID',
        'quantity',
        'unit_price',
        'subtotal',
        'SizeID',
        'product_name',
        'product_snapshot'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'product_snapshot' => 'array'
    ];

    // Relación con el pedido
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    // Relación con la talla
    public function size()
    {
        return $this->belongsTo(Size::class, 'SizeID', 'SizeID');
    }
}
