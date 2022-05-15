<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Arr;

class AnimalsController extends Controller
{
    // Get all animals from BD
    public function getAnimalKinds()
    {
        $animal_kinds = Animal::all(['kind', 'max_size', 'max_age', 'growth_factor', 'img_path']);

        if (!$animal_kinds) {
            return response()->json([
                'message' => 'Животные сбежали!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'message' => $animal_kinds
        ])->setStatusCode(200);
    }

    // Get current animal
    public function getAnimal($kind)
    {
        $animal = Animal::where('kind', $kind)
            ->first();

        if (!$animal) {
            return response()->json([
                'message' => 'Такого животного не существует!'
            ])->setStatusCode(404);
        }

        return response()->json([
            'message' => $animal
        ])->setStatusCode(200);
    }
}
