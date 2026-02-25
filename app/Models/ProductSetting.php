<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSetting extends Model
{
    protected $table = 'productsettings';
    protected $primaryKey = 'SettingID';
    public $timestamps = true;

    protected $fillable = [
        'ProductID',
        'SettingName',
        'SettingValue',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
    }
}
