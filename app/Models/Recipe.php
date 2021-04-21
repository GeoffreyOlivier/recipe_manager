<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "recipe";

    protected $fillable = [
        'user_id',
        'ingredient_id',
        'title',
        'description',
        'instruction',
        'time',
        'difficulty'
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }


}
