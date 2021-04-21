<?php

namespace App\Http\Controllers\API;

use App\Models\Recipe;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecipeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRecipes()
    {
        $recipe = Recipe::where('user_id', Auth::id())
            ->with('ingredients')
            ->get();

        if(empty($recipe)){
            return $this->sendError('Recipes not found');
        }

        return $this->sendResponse($recipe, 'Recipes get successfully.');
    }


    public function getRecipe($id)
    {

        $recipe = Recipe::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('ingredients')
            ->get();

        if(empty($recipe)){
            return $this->sendError('Recipe not found');
        }

        return $this->sendResponse($recipe, 'Recipe get successfully.');
    }

    public function CreateRecipe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'time' => 'required|numeric',
            'difficulty' => 'required|numeric|max:5'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $attributes = [
            'title' => $request->title,
            'description' => $request->description,
            'instruction' => $request->instruction,
            'time' => $request->time,
            'difficulty' => $request->difficulty,
            'user_id' => Auth::id()
        ];
        $recipe = Recipe::create($attributes);

        return $this->sendResponse($recipe, 'Recipe create successfully.');
    }

    public function UpdateRecipe($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes',
            'description' => 'sometimes',
            'instruction' => 'sometimes',
            'time' => 'sometimes|numeric',
            'difficulty' => 'sometimes|numeric|max:5'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $recipe = Recipe::find($id);
        if(empty($recipe)){
            return $this->sendError('Recipe not found');
        }

        $attributes = [
            'title' => $request->title ?? $recipe->title,
            'description' => $request->description ?? $recipe->description,
            'instruction' => $request->instruction ?? $recipe->instruction,
            'time' => $request->time ?? $recipe->time,
            'difficulty' => $request->difficulty ?? $recipe->difficulty,
            'user_id' => Auth::id()
        ];

        $recipe->update($attributes);

        return $this->sendResponse($recipe, 'Recipe update successfully.');

    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if(empty($recipe)){
            return $this->sendError('Recipe not found');
        }
        $recipe->delete();

        return $this->sendResponse($recipe, 'Recipe delete successfully.');

    }

}
