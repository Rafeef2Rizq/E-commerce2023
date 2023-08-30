<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['store_id','category_id','name','slug','description','image',
'                price','compare_price','options','rating','featured','status'];
    protected static function booted(){
      
    Static::addGlobalScope('store',new StoreScope());
    }
    public function category(){
        return   $this->belongsTo(Category::class,'category_id','id');
    }
    public function store(){
        return  $this->belongsTo(Store::class,'store_id','id');
    }
    public function tags(){
        return $this->belongsToMany(
            Tag::class, //Related model
            'product_tag', //pivot table
            'product_id', //foreign key in the pivot table for current model
            'tag_id',//foreign key in the pivot table for related model
            'id', //PK current model
            'id' //PK related model
        );
    }
}
