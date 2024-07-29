<?php 
 
namespace App\Models; 
 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
 
class Discount extends Model 
{ 
    use HasFactory; 
 
    protected $fillable = [ 
        'code', 
        'description', 
        'discount_percentage', 
        'valid_from', 
        'valid_to', 
    ]; 
 
    protected $dates = [ 
        'valid_from', 
        'valid_to', 
    ]; 
 
    protected $casts = [ 
        'valid_from' => 'datetime', 
        'valid_to' => 'datetime', 
    ]; 
} 