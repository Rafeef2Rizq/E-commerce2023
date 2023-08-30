<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = ['name', 'slug', 'status', 'description', 'parent_id', 'image'];
  public function products(){
    return $this->hasMany(Product::class,'category_id','id');
  }
  public function parent(){
    return $this->belongsTo(Category::class,'parent_id','id')->withDefault([
      'name'=>'-'
    ]);
  }
  public function children(){
    return $this->hasMany(Category::class,'parent_id','id');
  }
  public static function rules($id = 0)
  {
    return [
      //"unique:categories,name,$id"
      'name' => [
        'required', 'string', 'min:2', 'max:255',
        Rule::unique('categories', 'name')->ignore($id),
        function ($attribute, $value, $fails) {
          if (strtolower($value) == 'laravel') {
            $fails('Laravel name for category no allowed');
          }
        }

      ],
      'parent_id' => ['nullable', 'int', 'exists:categories,id'],
      'image' => ['image', 'max:1048576', 'dimensions:min_height=100,min_width=100'],
      'status' => ['in:active,archived']

    ];
  }




  public function scopeFilter(Builder $builder, $filters)
  {
    $builder->when($filters['name'] ??  false, function ($builder, $value) {
      $builder->where('name', 'LIKE', "%{$value}%");
    });
    $builder->when($filters['status'] ?? false, function ($builder, $value) {
      $builder->where('status', '=', $value);
    });


    // if ($filters['name']??  false) {
    //   $builder->where('name', 'LIKE', "%{$filters['name']}%");
    // }

    // if ( $filters['status'] ??false) {
    //   $builder->where('status', '=', $filters['status']);
    // }
  }
}
