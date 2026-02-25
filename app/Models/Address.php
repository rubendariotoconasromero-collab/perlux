<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'department',
        'province',
        'district',
        'street',
        'number',
        'detail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAddressAttribute()
    {
        $address = $this->street . ' ' . $this->number;
        
        if ($this->detail) {
            $address .= ', ' . $this->detail;
        }
        
        $address .= ', ' . $this->district . ', ' . $this->province . ', ' . $this->department;
        
        return $address;
    }
}
