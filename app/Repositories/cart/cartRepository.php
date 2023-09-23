<?php

namespace App\Repositories\cart;

use App\Models\Product;
use Illuminate\Support\Collection;

 interface cartRepository{
    public function get() :Collection;
    public function add(Product $product,$quantity);
    public function delete($id);
    public function update($id, $quantity);
    public function empty();
    public function total() :float;


}