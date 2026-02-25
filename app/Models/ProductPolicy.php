<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPolicy extends Model
{
    protected $table = 'productpolicies';
    protected $primaryKey = 'PolicyID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'PolicyName',
        'PolicyValue',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}
