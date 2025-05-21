<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID';

    protected $fillable = [
        // 'name', 'description', 'sku', 'salePrice','vendorPrice', 'basePrice', 'quantity', 'product_image',
        // 'size', 'length', 'property_class', 'standard', 'material', 'ManufacturerID', 'SubCategoryID',
        // 'image_paths' , 'type', 'color'
        'slno','sku','description','salePrice','vendorPrice', 'basePrice','discount','moq',
        'chapterID','SubCategoryID','standardISO','grade','size','threadType','color','metric','type',
        'standardType','point','pitch','pitchType','length','weight','image_paths'
    ];

    protected $casts = [
    'salePrice' => 'float',  // or 'double'
    'vendorPrice' => 'float',  // or 'double'
    'basePrice' => 'float',  // or 'double'
    'image_paths' => 'array',  // Ensure that image_paths is treated as an array
    'pitch' => 'float',  // or 'double'
    'weight' => 'float',  // or 'double'
];

    

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'SubCategoryID');
    }
    public function manufacturer()
{
    return $this->belongsTo(Manufacturer::class, 'ManufacturerID');
}

public function items() {
    return $this->hasMany(OrderItem::class, 'product_id', 'ProductID');
}
public function getImagePathsAttribute($value)
{
    return json_decode($value, true);
}

}
