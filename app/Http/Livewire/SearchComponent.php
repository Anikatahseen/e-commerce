<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class SearchComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";
    public $q;
    public $search_term;

    public function mount()
    {
        $this->fill(request()->only('q'));
        $this->search_term = '%' .$this->q . '%';
    }

    public function store($product_id,$product_name,$product_price)
    {
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('successful_message','Item add in Cart');
        $this->emitTo('cart-icon-component','refreshComponent');
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
            $products = Product::where('name','LIKE',$this->search_term)->orderBy('reqular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low')
        {
            $products = Product::where('name','LIKE',$this->search_term)->orderBy('reqular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort by Newness')
        {
            $products = Product::where('name','LIKE',$this->search_term)->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::where('name','LIKE',$this->search_term)->paginate($this->pageSize);
        }

        $categories = Catagory::orderBy('name','ASC')->get();
        return view('livewire.search-component',['products'=>$products,'categories'=>$categories]);
    }
}
