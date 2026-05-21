<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inmate extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmate_number',
        'name',
        'block',
        'status',
        'dietary_notes',
    ];

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    public function todaysMeals(): HasMany
    {
        return $this->hasMany(Meal::class)
            ->whereDate('served_date', today());
    }
}