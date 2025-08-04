<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $casts = [
    'weight' => 'float',  // or 'decimal:2' if you want fixed decimal places
];

    protected $fillable = [
         'order_id','user_id', 'total_amount','weight','awb_number','shipping',
        'billing_details','payment_status','transaction_id','razorpay_order_id','tracking_id'
    ];


    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');  // Ensure relationship uses custom order_id
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
