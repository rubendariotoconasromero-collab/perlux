<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'title',
        'age_range',
        'size'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo Product
     * Asumiendo que tu modelo Product se llama Product y la PK es ProductID
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'ProductID');
    }

    /**
     * Scope para filtrar por rating
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope para ordenar por fecha
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope para reviews de un producto específico
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Accessor para obtener el nombre completo del usuario
     */
    public function getUserFullNameAttribute()
    {
        return trim($this->user->name . ' ' . ($this->user->last_name ?? ''));
    }

    /**
     * Accessor para formatear la fecha de creación
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
