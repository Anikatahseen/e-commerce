<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponet extends Component
{

    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
        $this->emitTo('cart-icon-component','refreshComponent');
    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty -1;
        Cart::update($rowId, $qty);
        $this->emitTo('cart-icon-component','refreshComponent');
    }

    public function destroy($id)
    {
        Cart::remove($id);
        $this->emitTo('cart-icon-component','refreshComponent');
        session()->flash('successful_message','Item has been delete');
    }

    public function clearAll()
    {
        Cart::destroy();
        $this->emitTo('cart-icon-component','refreshComponent');
    }

    public function render()
    {
        return view('livewire.cart-componet');
    }
}
