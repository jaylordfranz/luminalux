<?php
namespace App\Models;




use Illuminate\Database\Eloquent\Model;




class BillingAddress extends Model
{
    protected $fillable = [
        'user_id',
        'address_name',
        'address',
        'contact_number',
    ];




    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
