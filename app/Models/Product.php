<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    protected $appends = ['rating'];

    public function categories(){
        return $this->belongsToMany(Category::class)
            ->using(CategoryProduct::class)
            ->wherePivot('active', '=', true);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function ratings(){
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function getRatingAttribute(){

        return round($this->ratings()->avg('average'),1);

    }

}
