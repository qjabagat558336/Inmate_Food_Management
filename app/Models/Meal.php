<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_name',
        'meal_type', // ADDED
        'day',
        'quantity',
        'unit',
        'price',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price'    => 'decimal:2',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}