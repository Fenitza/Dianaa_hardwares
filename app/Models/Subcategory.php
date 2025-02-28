<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';
    protected $primaryKey = 'SubCategoryID';
    protected $fillable = [
        'Name',         // assuming 'name' is a column in your categories table
        'CategoryId',  // assuming 'description' is a column in your categories table
        'Image'     ,    // assuming 'image' is the column where you store image paths
        'Description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'SubCategoryID');
    }
}
