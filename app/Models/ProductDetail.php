<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'productdetails';
    protected $primaryKey = 'DetailID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'DetailName',
        'DetailValue',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}
