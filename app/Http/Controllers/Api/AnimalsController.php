<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

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

    // Check if isset animals in session
    public function checkSession()
    {
        $animal_kinds = Animal::all('kind');
        $session_isset = false;

        foreach ($animal_kinds as $key => $kind) {
            if(session()->has($kind['kind'])) {
                $session_isset = true;
            }
        }

        if($session_isset) {
            $session = session()->all();

            $animal_kinds = $animal_kinds->toArray();
            $current_session = [];

            foreach ($session as $key_session => $animal) {
                foreach ($animal_kinds as $kind) {
                    if($key_session == $kind['kind']) {
                        $current_session[] = session($kind['kind']);
                    }
                }
            }

            return response()->json([
                'status' => true,
                'data' => $current_session
            ])->setStatusCode(200);
        }else{
            return response()->json([
                'status' => false
            ])->setStatusCode(200);
        }
    }

    // // Get current animal
    // Оставил метод получения параметров контретного животного

    // public function getAnimal($kind)
    // {
    //     // $animal = Animal::where('kind', $kind)
    //     //     ->first();

    //     if (!$animal) {
    //         return response()->json([
    //             'message' => 'Такого животного не существует!'
    //         ])->setStatusCode(404);
    //     }

    //     return response()->json([
    //         'message' => $animal
    //     ])->setStatusCode(200);
    // }

    // Create new animal
    public function createAnimal(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ])->setStatusCode(400);
        }
        
        $animal_kinds = Animal::all('kind');
        $animal = Animal::where('kind', $request->input('kind'))
            ->first();

        if(!session()->has($request->input('kind'))) {
            session([
                $request->input('kind') =>
                [
                    "name" => $request->input('name'),
                    "kind" => $animal->kind,
                    "max_size" => $animal->max_size,
                    "max_age" => $animal->max_age,
                    "growth_factor" => $animal->growth_factor,
                    "age" => $animal->age,
                    "size" => $animal->size,
                    "img_path" => $animal->img_path
                ]
            ]);
        }

        $session = session()->all();

        $animal_kinds = $animal_kinds->toArray();
        $current_session = [];

        foreach ($session as $key_session => $animal) {
            foreach ($animal_kinds as $kind) {
                if($key_session == $kind['kind']) {
                    $current_session[] = session($kind['kind']);
                }
            }
        }

        return response()->json([
            'error' => NULL,
            'data' => $current_session
        ])->setStatusCode(200);
    }

    // Age all animals
    public function ageAnimal()
    {
        $animal_kinds = Animal::all();
        
        $animals_count = 0;
        $stop_counter = 0;

        foreach ($animal_kinds as $key => $animal) {
            if(session()->has($animal->kind)) {
                $animals_count++;
                $kind = $animal->kind;
                $old_session = session($kind);

                if($old_session['age'] != $old_session['max_age']){
                    session([
                        $animal->kind =>
                        [
                            "name" => $old_session['name'],
                            "kind" => $old_session['kind'],
                            "max_size" => $old_session['max_size'],
                            "max_age" => $old_session['max_age'],
                            "growth_factor" => $old_session['growth_factor'],
                            "age" => $old_session['age'] + 1,
                            "size" => round(($old_session['size'] + $old_session['growth_factor']), 2),
                            "img_path" => $old_session['img_path']
                        ]
                    ]);
                }else{
                    $stop_counter++;
                }
            }
        }

        $session = session()->all();

        $animal_kinds = $animal_kinds->toArray();
        $current_session = [];

        foreach ($session as $key_session => $animal) {
            foreach ($animal_kinds as $kind) {
                if($key_session == $kind['kind']) {
                    $current_session[] = session($kind['kind']);
                }
            }
        }
        // 

        if($animals_count == $stop_counter){
            return response()->json([
                'error' => NULL,
                'stop' => true,
                'data' => $current_session,
            ])->setStatusCode(200);
        }

        return response()->json([
            'error' => NULL,
            'stop' => false,
            'data' => $current_session,
        ])->setStatusCode(200);
    }

    // Delete animals
    public function destroySession()
    {
        session()->flush();
    }
}
