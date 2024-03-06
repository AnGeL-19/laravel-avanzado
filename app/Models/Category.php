<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $appends = ['rating'];

    public function products(){
        return $this->belongsToMany(Product::class)->using(CategoryProduct::class)->wherePivot('active', '=', true);
    }

    public function ratings(){
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function getRatingAttribute(){
        return round($this->ratings()->avg('average'),1);
    }
}
