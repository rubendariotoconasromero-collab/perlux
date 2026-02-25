<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'productvariants';
    protected $primaryKey = 'VariantID';
    protected $fillable = [
        'ProductID',
        'SizeID',
        'ColorID',
        'StockQuantity',
        'Price',
        'SKU'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'SizeID', 'SizeID');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'ColorID', 'ColorID');
    }
}
