<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table ="ingredient";

    protected $fillable = [
        'recipe_id',
        'user_id',
        'name',
        'price',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
