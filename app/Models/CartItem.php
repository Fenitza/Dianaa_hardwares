<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'selected_color',
        'selected_price',
    ];
    

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'ProductID');
    }

    /**
     * Get the total price for the cart item.
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Relationship to the User model if necessary.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
