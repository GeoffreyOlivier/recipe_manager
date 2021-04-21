<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IngredientController extends BaseController
{
    public function addIngredient($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $recipe = Recipe::find($id);

        $ingredient = Ingredient::updateOrCreate(
            ['recipe_id' => $recipe->id, 'user_id' => Auth::id()],
            ['name' => $request->name, 'price' => $request->price]
        );

        return $this->sendResponse($ingredient, 'Ingredient add to the recipe successfully.');;
    }

    public function getAllIngredientOfRecipe($id)
    {
        $ingredient = Ingredient::where('recipe_id', $id)
            ->where('user_id', Auth::id())
            ->with('recipe')
            ->get();

        if (empty($ingredient)) {
            return $this->sendError('Ingredients not found');
        }

        return $this->sendResponse($ingredient, 'Ingredients get successfully.');
    }

    public function getIngredientFromRecipe($r_id, $id)
    {
        $ingredient = Ingredient::where('recipe_id', $r_id)
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->get();

        if (empty($ingredient)) {
            return $this->sendError('Ingredient or recipe not found');
        }

        return $this->sendResponse($ingredient, 'Ingredient get successfully.');
    }

    public function updateIngredientFromRecipe($r_id, $id)
    {
        $ingredient = Ingredient::where('recipe_id', $r_id)
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->get();

        if (empty($ingredient)) {
            return $this->sendError('Ingredient or recipe not found');
        }

        $attributes = [
            'name' => $request->name ?? $ingredient->name,
            'price' => $request->price ?? $ingredient->price
        ];

        $ingredient->update($attributes);

        return $this->sendResponse($ingredient, 'Ingredient update successfully.');

    }

    public function DeleteIngredientFromRecipe($r_id, $id)
    {
        $ingredient = Ingredient::where('recipe_id', $r_id)
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->get();

        if (empty($ingredient)) {
            return $this->sendError('Ingredient or recipe not found');
        }

        $ingredient->delete();

        return $this->sendResponse($ingredient, 'Ingredient delete successfully.');
    }
}
