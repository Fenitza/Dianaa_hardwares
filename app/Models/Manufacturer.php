<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers'; // Define the table name if not the plural of the model name
    protected $primaryKey = 'ManufacturerID'; // Set the primary key

    protected $fillable = [
        'Name', 'Image' // Ensure you can assign these attributes
    ];

    // If you have relationships like products made by the manufacturer
    public function products()
    {
        return $this->hasMany(Product::class, 'ManufacturerID');
    }
}
