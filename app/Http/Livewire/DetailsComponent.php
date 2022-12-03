<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class DetailsComponent extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $product = Product::where('slug',$this->slug)->first();
        $rproducts = Product::where('catagory_id',$product->catagory_id)->inRandomOrder()->limit(4)->get();
        $nproducts = Product::latest()->take(3)->get();
        return view('livewire.details-component',['product'=>$product,'rproducts'=>$rproducts,'nproducts'=>$nproducts]);
    }
}
