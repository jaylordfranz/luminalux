<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity', 'category_id', 'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('customer.product.show', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
