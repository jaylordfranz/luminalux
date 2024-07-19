<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checkouts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'checkout_date',
        'total_amount',
        'checkout_status',
        'payment_status',
        'billing_address',
    ];

    /**
     * Get the cart associated with the checkout.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
