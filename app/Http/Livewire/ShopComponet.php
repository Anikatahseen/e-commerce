<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class ShopComponet extends Component
{
    use WithPagination;
    public $pageSize = 12;

    public function store($product_id,$product_name,$product_price)
    {
        Cart::add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('successful_message','Item add in Cart');
        return redirect()->route('shop.cart');
    }
    public function render()
    {
        $products = Product::paginate($this->pageSize);
        return view('livewire.shop-componet',['products'=>$products]);
    }
}
