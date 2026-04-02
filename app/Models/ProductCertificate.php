<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCertificate extends Model
{
    protected $fillable = ['code', 'order_detail_id'];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id', 'OrderDetailID');
    }
}
