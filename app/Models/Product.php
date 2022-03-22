<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'brand_id',
        'desc',
    ];

    protected $appends = [
        'avg_rating',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getAvgRatingAttribute()
    {
        return $this->comments->avg('rating');
    }
}
