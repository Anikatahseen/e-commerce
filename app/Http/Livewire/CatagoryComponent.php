<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CatagoryComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";
    public $slug;

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

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $category = Catagory::where('slug',$this->slug)->first();
        $catagory_id = $category->id;
        $catagory_name = $category->name;

        if($this->orderBy == 'Price: Low to High')
        {
            $products = Product::where('catagory_id',$catagory_id )->orderBy('reqular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low')
        {
            $products = Product::where('catagory_id',$catagory_id )->orderBy('reqular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort by Newness')
        {
            $products = Product::where('catagory_id',$catagory_id )->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::where('catagory_id',$catagory_id )->paginate($this->pageSize);
        }

        $categories = Catagory::orderBy('name','ASC')->get();
        return view('livewire.catagory-component',['products'=>$products,'categories'=>$categories,'catagory_name'=>$catagory_name]);
    }
}
