<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';
    protected $primaryKey = 'SizeID';
    public $timestamps = true;

    protected $fillable = [
        'SizeName',
        'Bust',
        'Waist',
        'Hips',
    ];
}
