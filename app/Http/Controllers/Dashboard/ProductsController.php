<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $products=Product::with(['category','store'])->paginate();
    //select * from products
    //select * from category where id in (...)
     //select * from store where id in (...)
     //how use has many relation
     //$categories=Category::find(1);
     //foreach($categories->products as $product)
     //echo $product->name
    return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $products=Product::findOrFail($id);
       $tags=implode(',',$products->tags()->pluck('name')->toArray());
       return view('dashboard.products.edit',compact('products','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $oldImage = $product->image;
        $imagePath='';
        if($request->hasFile('image')){
            $imageObj=$request->file('image');
            $imagePath=$imageObj->store('uploads', [
                'disk' => 'public'
              ]);
        }
        $data = $request->except('image');

      
        if ($imagePath) {
          $data['image'] = $imagePath;
        }
    
        $product->update($data);
        if ($oldImage && $imagePath) {
          Storage::disk('public')->delete($oldImage);
        }
    
    
        // Check if tags were provided in the request
        if ($request->has('tags')) {
            $tags = json_decode($request->post('tags'));
            $saved_tags = Tag::all();
            $tag_ids = [];
    
            foreach ($tags as $taglist) {
                $slug = Str::slug($taglist->value);
                $tag = $saved_tags->where('slug', '=', $slug)->first();
    
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $taglist->value,
                        'slug' => $slug
                    ]);
                }
    
                $tag_ids[] = $tag->id;
            }
    
            $product->tags()->sync($tag_ids);
        }
    
        return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
