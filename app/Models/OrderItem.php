<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');  // Ensure relationship uses custom order_id
    }

    public function product() {
        // The keys should correctly reference 'product_id' and 'id' respectively
        return $this->belongsTo(Product::class, 'product_id', 'ProductID');
    }
}

