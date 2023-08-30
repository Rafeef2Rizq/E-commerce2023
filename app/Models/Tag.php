<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable=['name','slug'];
    public $timestamps =false;
    public function products(){
        return $this->belongsToMany(
            Product::class, //Related model
            'product_tag', //pivot table
            'tag_id',//foreign key in the pivot table for related model
            'product_id', //foreign key in the pivot table for current model
            'id', //PK current model
            'id' //PK related model
        );
    }
}
