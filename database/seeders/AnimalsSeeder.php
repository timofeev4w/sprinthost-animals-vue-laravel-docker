<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $animals = [
            [
                "kind" => "cat",
                "max_size" => 25,
                "max_age" => 18,
            ],

            [
                "kind" => "dog",
                "max_size" => 50,
                "max_age" => 20,
            ],

            [
                "kind" => "elephant",
                "max_size" => 100,
                "max_age" => 120,
            ],

            [
                "kind" => "python",
                "max_size" => 70,
                "max_age" => 30,
            ],
        ];

        foreach ($animals as $animal) {
            Animal::create([
                "kind" => $animal['kind'],
                "max_size" => $animal['max_size'],
                "max_age" => $animal['max_age'],
                "growth_factor" => round(($animal['max_size'] - 1) / ($animal['max_age'] - 1), 2),
                "size" => 1,
                "age" => 1,
                "img_path" => "img/animals/".$animal['kind'].".png"
            ]);
        }
        
    }
}
