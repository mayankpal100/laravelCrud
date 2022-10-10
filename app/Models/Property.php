<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $primaryKey = 'uuid';
    protected $casts = [
        'uuid' => 'string'
    ];

    protected $fillable = ['uuid', 'property_type_id', 'county', 'country', 'town', 'description', 'address', 'image_full', 'image_thumbnail', 'latitude', 'longitude', 'num_bedrooms', 'num_bathrooms', 'price', 'type', 'created_at', 'updated_at'];
}
