<?php
// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id',
        'quantity',
    ];

    // Relasi ke Product (PENTING untuk CartController@index)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke User (Opsional, tapi bagus)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}