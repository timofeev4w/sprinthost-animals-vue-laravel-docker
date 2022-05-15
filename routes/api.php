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
Route::get('animal/{kind}', [AnimalsController::class, 'getAnimal']);
