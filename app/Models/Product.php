<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

public function products()
    {
        return $this->hasMany(Product::class, 'SubCategoryID');
    }
}
