<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\cart\cartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
  public function create(cartRepository $cart){
    if($cart->get()->count()==0){
        return redirect()->route('home');
    }
  return view('front.checkout',
  [
    'cart'=>$cart,
  'countries'=>Countries::getNames(),
]);
  }
  public function store(Request $request,cartRepository $cart){
     $request->validate([
      'addr.billing.first_name'=>['required','string','max:255'],
      'addr.billing.last_name'=>['required','string','max:255'],
      'addr.billing.email'=>['required','string','max:255'],
      'addr.billing.city'=>['required','string','max:255'],
      'addr.billing.phone_number'=>['required','string','max:255'],
     ]);
     $items=$cart->get()->groupBy('product.store_id')->all();

     DB::beginTransaction();
     try {
        foreach($items as $store_id =>$cart_items){
      
                $order=Order::create([
                    'store_id'=>$store_id,
                    'user_id'=>Auth::id(),
                    'payment_method'=>'cod'
                ]);
                foreach($cart_items as $item){
            OrderItem::create([
                'order_id'=>$order->id,
                'product_id'=>$item->product_id,
                'product_name'=>$item->product->name,
                'price'=>$item->product->price,
                'quantity'=>$item->quantity
            ]);
         }
        //  dd($request->post('addr'));
      foreach($request->post('addr') as $type=>$address){
        $address['type']=$type;
                //  dd($order->addresses());
        $order->addresses()->create($address);
      }




         }
        //  $cart->empty();
         DB::commit();
         //event('order.created',$order,Auth::user());
         event(new OrderCreated($order));
     } catch (Throwable $th) {
     DB::rollBack();
     throw $th;
     }
     return redirect()->route('home');
  } 
}
