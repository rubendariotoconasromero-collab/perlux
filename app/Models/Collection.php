<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
    protected $primaryKey = 'CollectionID';
    public $timestamps = true;

    protected $fillable = [
        'CollectionName',
        'Tipo',
        'Description',
        'Image',
        'LaunchDate',
    ];

    // protected $casts = [
    //     'LaunchDate' => 'date',
    // ];
}
