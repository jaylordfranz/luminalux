<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'images',
    ];

    protected $casts = [
        'images' => 'json', // Cast images attribute to JSON
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
