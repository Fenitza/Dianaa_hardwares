<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';

    public function category()
    {
        // Specify the foreign key 'CategoryID' here as well
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'SubCategoryID');
    }
}
