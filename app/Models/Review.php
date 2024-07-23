<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['order_id', 'content'];

    public function order()
    {
        return $this->belongsTo(Checkout::class, 'order_id');
    }
}
