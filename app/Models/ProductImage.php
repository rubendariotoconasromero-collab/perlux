<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'productimages';
    protected $primaryKey = 'ImageID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'ImagePath',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}
