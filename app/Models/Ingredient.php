<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'name',
        'quantity',       // FIXED: added
        'unit',           // FIXED: added
        'price_per_unit', // FIXED: added
        'price',
    ];

    protected $casts = [
        'quantity'       => 'decimal:2', // FIXED: added
        'price_per_unit' => 'decimal:2', // FIXED: added
        'price'          => 'decimal:2',
    ];

    /**
     * An ingredient belongs to a meal.
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}