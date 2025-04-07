<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'CategoryID';

     // Specifying which attributes can be mass-assigned
     protected $fillable = [
        'Name',         // assuming 'name' is a column in your categories table
        'Description',  // assuming 'description' is a column in your categories table
        'category_image'         // assuming 'image' is the column where you store image paths
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'CategoryID');
    }
}
