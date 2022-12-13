<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class ShopComponet extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";

    public $min_value = 0;
    public $max_value = 1000;

    public function store($product_id,$product_name,$product_price)
    {
        Cart::add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('successful_message','Item add in Cart');
        return redirect()->route('shop.cart');
    }

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }

    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }

    public function render()
    {

        if($this->orderBy == 'Price: Low to High')
        {
            $products = Product::whereBetween('reqular_price',[$this->min_value,$this->max_value])->orderBy('reqular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low')
        {
            $products = Product::whereBetween('reqular_price',[$this->min_value,$this->max_value])->orderBy('reqular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort by Newness')
        {
            $products = Product::whereBetween('reqular_price',[$this->min_value,$this->max_value])->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::whereBetween('reqular_price',[$this->min_value,$this->max_value])->paginate($this->pageSize);
        }

        $categories = Catagory::orderBy('name','ASC')->get();
        return view('livewire.shop-componet',['products'=>$products,'categories'=>$categories]);
    }
}
