<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_type',
        'menu_item',
        'start_time',
        'end_time',
        'blocks',
        'schedule_date',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];
}