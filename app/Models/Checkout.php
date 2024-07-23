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
        'customer_id',
    ];

    /**
     * Get the cart associated with the checkout.
     */
    public function cart()
{
    return $this->belongsTo(Cart::class); // Adjust this if necessary
}

    /**
     * Get the customer associated with the checkout.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'order_id');
    }
}
