<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{
    use HasFactory;

    public $table = 'category_products';

    protected $fillable = [
        'product_id',
        'category_id',
        'active'
    ];
}
