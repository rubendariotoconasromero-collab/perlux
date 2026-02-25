<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'productcolors';
    protected $primaryKey = 'ProductColorID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'ColorID',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'ColorID', 'ColorID');
    }
      
}
