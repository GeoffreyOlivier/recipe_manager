<?php

//use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\IngredientController;
use App\Http\Controllers\API\RecipeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
//
Route::middleware('auth:api')->group( function () {
    Route::get('recipes', [RecipeController::class, 'getRecipes']);
    Route::post('recipe', [RecipeController::class, 'createRecipe']);

    Route::get('recipe/{id}', [RecipeController::class, 'getRecipe']);
    Route::put('recipe/{id}', [RecipeController::class, 'updateRecipe']);
    Route::delete('recipe/{id}', [RecipeController::class, 'destroy']);

    Route::post('recipe/{id}/ingredients', [IngredientController::class, 'addIngredient']);
    Route::get('recipe/{id}/ingredients', [IngredientController::class, 'getAllIngredientOfRecipe'] );

    Route::get('recipe/{id}/ingredient/{r_id}', [IngredientController::class, 'getIngredientFromRecipe']);
    Route::put('recipe/{id}/ingredient/{r_id}', [IngredientController::class, 'updateIngredientFromRecipe']);
    Route::delete('recipe/{id}/ingredient/{r_id}', [IngredientController::class, 'DeleteIngredientFromRecipe']);


});

