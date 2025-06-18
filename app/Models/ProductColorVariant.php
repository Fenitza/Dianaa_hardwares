<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorVariant extends Model
{
    protected $fillable = ['product_id', 'color', 'sale_price','online_price','discount_percent'];

public function product()
{
    return $this->belongsTo(Product::class);
}
protected static function booted()
{
    static::saving(function ($variant) {
        if ($variant->discount_percent && $variant->discount_percent > 0) {
            $discountAmount = ($variant->sale_price * $variant->discount_percent) ;
            $variant->online_price = round($variant->sale_price - $discountAmount, 2);
        } else {
            $variant->online_price = $variant->sale_price;
        }
    });
}
}
