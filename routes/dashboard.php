<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\dashboard\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;


Route::get('categories/trash',[CategoriesController::class,'trash'])
->name('categories.trash');
Route::put('categories/{category}/restore',[CategoriesController::class,'restore'])
->name('categories.restore');
Route::delete('categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])
->name('categories.force.delete');


Route::group([
    'middleware'=>['auth','auth.type:supper_admin,admin'],
    'as'=>'dashboard.',
    'prefix'=>'dashboard'


],function(){
    Route::resource('/categories',CategoriesController::class);
    Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
    Route::resource('/products',ProductsController::class);
});