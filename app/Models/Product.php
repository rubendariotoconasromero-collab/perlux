<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID';
    public $timestamps = true;

    protected $fillable = [
        'CollectionID',
        'Name',
        'Tipo',
        'Description',
        'Price',
        'StockQuantity',
        'IsFeatured',
        'Fabric',
        'ReturnPolicy',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'CollectionID', 'CollectionID');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'productcolors', 'ProductID', 'ColorID');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'productsizes', 'ProductID', 'SizeID');
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'ProductID', 'ProductID');
    }

    public function settings()
    {
        return $this->hasMany(ProductSetting::class, 'ProductID', 'ProductID');
    }

    public function policies()
    {
        return $this->hasMany(ProductPolicy::class, 'ProductID', 'ProductID');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'ProductID', 'ProductID');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'ProductID');
    }

    // Relación con pedidos (a través de detalles)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'ProductID', 'ProductID');
    }


    // Relaciones con variantes
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'ProductID', 'ProductID');
    }
}
