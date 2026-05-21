<?php

namespace Database\Seeders;

use App\Models\Inmate;
use App\Models\Meal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $inmates = [
            ['inmate_number' => 'INM-0011', 'name' => 'Carlos Reyes',   'block' => 'Block A'],
            ['inmate_number' => 'INM-0023', 'name' => 'Marcus Webb',    'block' => 'Block B'],
            ['inmate_number' => 'INM-0034', 'name' => 'Dante Flores',   'block' => 'Block C'],
            ['inmate_number' => 'INM-0047', 'name' => 'Jerome King',    'block' => 'Block A'],
            ['inmate_number' => 'INM-0059', 'name' => 'Reuben Tran',    'block' => 'Block D'],
            ['inmate_number' => 'INM-0062', 'name' => 'Anthony Diaz',   'block' => 'Block B'],
        ];

        foreach ($inmates as $data) {
            $inmate = Inmate::create([...$data, 'status' => 'active']);
        }

        $mealData = [
            [Inmate::where('inmate_number','INM-0011')->first()->id, 'Breakfast', 'Oatmeal & eggs',   'Served',  '06:42'],
            [Inmate::where('inmate_number','INM-0023')->first()->id, 'Breakfast', 'Bread & milk',      'Served',  '06:55'],
            [Inmate::where('inmate_number','INM-0034')->first()->id, 'Lunch',     'Rice & chicken',    'Served',  '11:30'],
            [Inmate::where('inmate_number','INM-0047')->first()->id, 'Lunch',     'Pasta & salad',     'Served',  '11:45'],
            [Inmate::where('inmate_number','INM-0059')->first()->id, 'Dinner',    'Beef stew',         'Pending', '17:00'],
            [Inmate::where('inmate_number','INM-0062')->first()->id, 'Special diet', 'Diabetic meal',  'Pending', '17:15'],
        ];

        foreach ($mealData as [$inmate_id, $meal_type, $menu_item, $status, $served_time]) {
            Meal::create([
                'inmate_id'   => $inmate_id,
                'meal_type'   => $meal_type,
                'menu_item'   => $menu_item,
                'status'      => $status,
                'served_date' => today(),
                'served_time' => $served_time,
            ]);
        }
    }
}