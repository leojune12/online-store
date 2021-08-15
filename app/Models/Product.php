<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\Order;
use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product_cover_image')
            ->singleFile();
    }

    protected $appends = [
        'cover_image_url',
    ];

    public function getCoverImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('product_cover_image');
    }
}
