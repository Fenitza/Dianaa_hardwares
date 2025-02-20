<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID';

    protected $fillable = [
        'name', 'description', 'sku', 'salePrice', 'quantity', 'product_image',
        'size', 'length', 'property_class', 'standard', 'material', 'ManufacturerID', 'SubCategoryID'
    ];
    

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'SubCategoryID');
    }
    public function manufacturer()
{
    return $this->belongsTo(Manufacturer::class, 'ManufacturerID');
}

}
