<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pest\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'category_id', 'name', 'slug', 'description', 'image',
        '                price', 'compare_price', 'options', 'rating', 'featured', 'status'];
    protected static function booted()
    {

        static::addGlobalScope('store', new StoreScope());
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, //Related model
            'product_tag', //pivot table
            'product_id', //foreign key in the pivot table for current model
            'tag_id', //foreign key in the pivot table for related model
            'id', //PK current model
            'id' //PK related model
        );
    }
    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', '=', 'active');
    }
    //Accessor
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/defaultImage.jfif');
        }

        if (Str::startsWith($this->image, 'http://') || Str::startsWith($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image); // Change "storags" to "storage"
    }

    public function getSalePercentAttribute(){
        if(!$this->compare_price){
         return 0;
        }
        return round(100 -(100 *($this->price / $this->compare_price)));
    }
    public function getNewProductAttribute(){
        $new_products=$this->where('created_at', '>=', now()->subDays(1))
        ->orderBy('created_at', 'desc')
        ->get();
        if(!$new_products){
         return '';
        }
        return $new_products;
    }

}
