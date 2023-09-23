<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\cart\cartRepository ;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $cart;
    public function __construct(cartRepository $cart)
    {
        $this->cart=$cart;
    }
    public function index(CartRepository $cart)
    {
   
     return view('front.cart',compact('cart'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,cartRepository $cart)
    {
        $request->validate([
            'product_id'=>['required','int','exists:products,id'],
            'quantity'=>['nullable','int','min:1']
        ]);
        $product=Product::findOrFail($request->post('product_id'));
       
        $cart->add($product,$request->post('quantity') );
        // dd($cart);
       return redirect()->route('cart.index')->with('success','Product added to cart!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'quantity'=>['required','int','min:1']
        ]);
        $this->cart->update($id,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $this->cart->delete($id);
        return ['message'=>'Item deleted !'];
    }
}
