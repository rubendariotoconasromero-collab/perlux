<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'productsizes';
    protected $primaryKey = 'ProductSizeID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'SizeID',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'SizeID', 'SizeID');
    }
}
