<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $request = request();

// select a.* from categories as a
// left join categories as parents on parent.id=a.parent_id
  
    $categories = Category::with('parent')
    // leftJoin('categories as parent','parent.id','=','categories.parent_id')->
    // select(['categories.*','parent.name as parent_name'])->orderby('categories.name')
    // ->select('categories.*')
    // ->selectRaw('( select count(*) from products where category_id=categories.id) as products_count')
    ->withCount('products')
    /* 
    when applaying addional condition
    ->withCount('products',function($query){
      $query->where('status'='active])
    });
    */
    ->filter($request->query())->paginate(8);
    return view('dashboard.categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $parents = Category::all();
    $categories = new Category();
    return view('dashboard.categories.create', compact('parents', 'categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $request->validate(Category::rules());
    // $request->merge([
    //   'slug' => Str::slug($request->post('name')),
    // ]);
    // $data = $request->except('image');

    // $data['image'] = $this->uploadImage($request);
    $data = $request->except('image');
    $data['slug'] = Str::slug($request->post('name'));
    $data['image'] = $this->uploadImage($request);

    Category::create($data);
    return to_route('dashboard.categories.index')->with('success', 'category created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Category $category)
  {
  return view('dashboard.categories.show',compact('category'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {
      $categories = Category::findOrFail($id);
    } catch (Exception $e) {
      return to_route('dashboard.categories.index')->with('fail', 'category not found');
    }
    $parents = Category::where('id', '<>', $id)
      ->where(function ($query) use ($id) {
        $query->whereNull('parent_id')
          ->orWhere('parent_id', '<>', $id);
      })
      ->get();
    return view('dashboard.categories.edit', compact('categories', 'parents'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate(Category::rules($id));
    $category = Category::findOrFail($id);
    $oldImage = $category->image;
    $data = $request->except('image');

    $newImage = $this->uploadImage($request);
    if ($newImage) {
      $data['image'] = $newImage;
    }

    $category->update($data);
    if ($oldImage && $newImage) {
      Storage::disk('public')->delete($oldImage);
    }


    return to_route('dashboard.categories.index')->with('success', 'category updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $category = Category::findOrFail($id);
    $category->delete();
   
    // Category::destroy($id);
    return to_route('dashboard.categories.index')->with('success', 'category Deleted successfully!');
  }
  protected function uploadImage(Request $request)
  {
    if (!$request->hasFile('image')) {
      return;
    }
    $file = $request->file('image'); //upload fule object
    $path = $file->store('uploads', [
      'disk' => 'public'
    ]);


    return $path;
  }
  public function trash(){
    $categories=Category::onlyTrashed()->paginate();
    return view('dashboard.categories.trash',compact('categories'));

  }
  public function restore(Request $request,$id){
   $category=Category::onlyTrashed()->findOrFail($id);
   $category->restore();
   return to_route('categories.trash')->with('success','Category restore Again successfully');
  }
  public function forceDelete($id){
    $category=Category::onlyTrashed()->findOrFail($id);
    $category->forceDelete();
    if ($category->image) {
      Storage::disk('public')->delete($category->image);
    }
    return to_route('categories.trash')->with('success','Category Deleted forever successfully');
   }
}
