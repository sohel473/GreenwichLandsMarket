<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'mainimage',
        'price',
        'old_price'
    ];

    protected function mainImage(): Attribute {
        return Attribute::make(
            get: function($value) {
                return '/storage/landmarks/' . $value;
            }
        );
    }

}
