<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity', 'category_id',
        // Add more fields if necessary for image upload
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

