<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID';

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'SubCategoryID');
    }
}
