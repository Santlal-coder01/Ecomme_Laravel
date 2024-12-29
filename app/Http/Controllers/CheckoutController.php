<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\e_store\Quote;
use App\Models\e_store\QuoteItem;
use App\Models\e_store\OrderAddress;
use Auth;

class CheckoutController extends Controller
{
    // Method to handle checkout
    public function checkout(Request $req)
    {
        // dd($req->all());
        $cartId = session('cart_id');
        // dd($cartId);
        if (Auth::check()) {
            $userid = Auth::user()->id;
            // dd($userid);
            $cart = Quote::where('cart_id',$cartId)->first();
            // dd($cart);
            $quoteitem = QuoteItem::where('quote_id',$cartId)->get();
            // dd($quoteitem);

            if ($quoteitem==null) {
                return redirect()->route('showcart')->with('error', 'Your cart is empty. Add items to proceed to checkout.');
            }
            $cartItem = QuoteItem::where('quote_id', $cart->id)->with('product')->get();
            // dd($cartItem);



            $billingAddresses = OrderAddress::where('user_id', $userid)
            ->where('address_type', 'billing')
            ->get();
            $shippingAddresses = OrderAddress::where('user_id', $userid)
            ->where('address_type', 'shipping')
            ->get();


            return view('checkout', [
                // 'cart' => $cart,
                'billingAddresses' => $billingAddresses,
                'shippingAddresses' => $shippingAddresses,
                'cartItem' => $cartItem,

            ]);
        } else {
            return redirect()->route('loginFront')->with('message', 'Please log in to proceed to checkout.');
        }
    }
    

    
    // public function index(){
    //     dd($this->checkout());
    // }

    // Method to display the checkout page
    // public function index(Request $req)
    // {
    //  $this->checkout();
    //     return view('checkout', [
    //         'cart' => $cart,
    //     ]);
    // }
}

