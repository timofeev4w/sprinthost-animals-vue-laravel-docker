<?php

use App\Http\Controllers\Api\AnimalsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('animal_kinds', [AnimalsController::class, 'getAnimalKinds']);
Route::get('animal/old', [AnimalsController::class, 'checkSession']);
// Route::get('animal/{kind}', [AnimalsController::class, 'getAnimal']);  // Оставил метод получения параметров контретного животного
Route::post('animal', [AnimalsController::class, 'createAnimal']);
Route::post('animal/age', [AnimalsController::class, 'ageAnimal']);


Route::post('animal/destroy', [AnimalsController::class, 'destroySession']);

