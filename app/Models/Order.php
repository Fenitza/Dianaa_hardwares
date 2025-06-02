<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
         'order_id','user_id', 'total_amount',
        'billing_details','payment_status','transaction_id'
    ];


    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');  // Ensure relationship uses custom order_id
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
