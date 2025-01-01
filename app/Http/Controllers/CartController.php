<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\e_store\Quote;
use App\Models\e_store\QuoteItem;
use App\Models\admin\Product;
use App\Models\admin\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = Auth::user()->id ?? null; 
        $cartId = session('cart_id'); 
    
        if ($userId) {
            
            $quote = Quote::where('user_id', $userId)->first();
            if ($quote) {
                $cartId = $quote->cart_id;
                session(['cart_id' => $cartId]); 
            } else {
                $cartId = Str::uuid(20)->toString();
                session(['cart_id' => $cartId]);
            }
        } elseif (!$cartId) {
            $cartId = Str::uuid(20)->toString();
            session(['cart_id' => $cartId]);
        }
    
        $quote = Quote::firstOrCreate(
            ['cart_id' => $cartId],
            [
                'cart_id' => $cartId,
                'user_id' => $userId,
            ]
        );
    
        $product = Product::findOrFail($request->input('product_id'));
    
        $quoteItem = QuoteItem::where('quote_id', $quote->id)
            ->where('product_id', $product->id)
            ->first();
    
        if ($quoteItem) {
            $quoteItem->qty += $request->input('quantity');
            $quoteItem->row_total = $quoteItem->price * $quoteItem->qty;
            $quoteItem->save();
    
            session()->flash('message', 'Product quantity updated in the cart.');
        } else {
            $attributes = $request->input('attributes', []);
            $price = $product->special_price && now()->between($product->special_price_from, $product->special_price_to)
                ? $product->special_price
                : $product->price;
    
            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $price,
                'qty' => $request->input('quantity'),
                'row_total' => $price * $request->input('quantity'),
                'custom_option' => json_encode($attributes),
            ]);
    
            session()->flash('message', 'Product added to cart!');
        }
    
        $quoteItems = QuoteItem::where('quote_id', $quote->id)->get();
        $subtotal = $quoteItems->sum('row_total');
        $total = $subtotal - ($quote->coupon_discount ?? 0);
    
        $quote->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    
        return redirect()->back();
    }
    
    
    
    

    public function update(Request $request, $id)
    {
        // Find the QuoteItem by ID
        $quoteItem = QuoteItem::findOrFail($id);
    
        // Update the quantity and row total
        $quoteItem->qty = $request->input('qty');
        $quoteItem->row_total = $quoteItem->price * $quoteItem->qty;
        $quoteItem->save();
    
 
        $quote = $quoteItem->quote; 
        if ($quote) {
            $quoteItems = $quote->items; 
            $newSubtotal = $quoteItems->sum('row_total');
            $shippingCost = $quote->shipping_cost ?? 0; 
            $newTotal = $newSubtotal + $shippingCost - ($quote->coupon_discount ?? 0);
    
            $quote->subtotal = $newSubtotal;
            $quote->total = $newTotal;
            $quote->save();
        }
    
        return redirect()->back()->with('message', 'Cart updated successfully!');
    }
    

 

    public function showCart()
    {
        
        $userId = Auth::id();
    
        if (!$userId) {
      
            return redirect()->route('loginFront')->with('message', 'Please login to view your cart.');
        }
    
     
        $cartId = Quote::where('user_id', $userId)->first();
    
        
        if (!$cartId) {
            return view('cart', [
                'quote' => null,
                'quotes' => [],
                'message' => 'Your cart is empty!',
                'newSubtotal' => 0,
            ]);
        }
    
      
        $quote = Quote::where('cart_id', $cartId->cart_id)->where('user_id', $userId)->first();
    
        
        // if (!$quote) {
        //     $quote = Quote::create([
        //         'user_id' => $userId,
        //         'cart_id' => Str::random(20), 
        //     ]);
        // }
    
       
        // if (is_null($quote->cart_id)) {
        //     $quote->cart_id = (string) Str::uuid();
        //     $quote->save();
        // }
    
       
        $quoteItems = QuoteItem::where('quote_id', $quote->id)
            ->with('product') 
            ->get();
    
       
        if ($quoteItems->isEmpty()) {
            return view('cart', [
                'quote' => $quote,
                'quotes' => [],
                'message' => 'Your cart is empty!',
                'newSubtotal' => 0,
            ]);
        }
    
       
        $newSubtotal = $quoteItems->sum('row_total');
    
        
        return view('cart', [
            'quote' => $quote,
            'quotes' => $quoteItems,
            'message' => null, 
            'newSubtotal' => $newSubtotal,
        ]);
    }
    
    
    
    

    

    public function removeFromCart($id)
    {
        // dd($id);
        // Get the logged-in user ID
        $userId = auth()->id();
        // dd($userId);
    
        // Fetch the user's quote (cart)
        $quote = Quote::where('user_id', $userId)->first();
        // dd($quote);
    
        // If no quote is found, handle gracefully
        if (!$quote) {
            session()->flash('message', 'No cart found for the user!');
            return redirect()->back();
        }
    
        // Find the item in the cart by its ID and quote ID
        $quoteItem = QuoteItem::where('id', $id)->where('quote_id', $quote->id)->first();
        // dd($quoteItem);
    
        // Handle item not found in the cart
        if (!$quoteItem) {
            session()->flash('message', 'Product not found in cart!');
            return redirect()->back();
        }
    
        // Delete the item from the cart
        $quoteItem->delete();
        session()->flash('message', 'Product removed from cart successfully!');
    
        // Recalculate subtotal and total for the quote
        $newSubtotal = $quote->items->sum(function ($item) {
            return $item->price * $item->qty;
        });
    
        // Recalculate total (apply coupon discount if present)
        $newTotal = $newSubtotal - ($quote->coupon_discount ?? 0);
    
        // Update the quote with new values
        $quote->update([
            'subtotal' => $newSubtotal,
            'total' => $newTotal
        ]);
    
        return redirect()->back();
    }
    
    
    
    

public function discount(Request $request)
{
    // dd($request->all());
    if (Auth::check()) {
        $user = Auth::user();
        if (session('cart_id')) {
            $quote = Quote::where('cart_id', session('cart_id'))
                ->where('user_id', $user->id)
                ->firstOrCreate();

            if (!$quote) {
                return redirect()->back()->with('message', 'Cart not found.');
            }

            // Fetch the coupon
            $coupon = Coupon::where('status', 1)
                ->where('coupon_code', $request->input('coupon_code'))
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('message', 'Coupon not found.');
            }

            // Check if the coupon has expired
            if (now()->greaterThan($coupon->valid_to)) {
                return redirect()->back()->with('message', 'Coupon has expired.');
            }

            // Calculate the subtotal from QuoteItems
            $quoteItems = QuoteItem::where('quote_id', $quote->id)->get();
            $subtotal = $quoteItems->sum('row_total');

            // Apply the discount
            $discountValue = $coupon->discount_amount;

            // Ensure that the discount value is not greater than the subtotal
            if ($discountValue > $subtotal) {
                return redirect()->back()->with('message', 'You cannot use the coupon if the coupon amount exceeds the subtotal');
            }

            // Apply the discount to the total
            $total = $subtotal - $discountValue;

            // Update the quote with the calculated values
            $quote->subtotal = $subtotal;
            $quote->coupon = $coupon->coupon_code;
            $quote->coupon_discount = $discountValue;
            $quote->total = $total > 0 ? $total : 0; // Ensure total doesn't go negative
            $quote->save();

            // Set a success message
            session()->flash('message', 'Coupon applied successfully!');
            return redirect()->back();
        }

        return redirect()->back()->with('message', 'Cart not found.');
    } else {
        return redirect()->back()->with('message', 'Please log in to apply the coupon.');
    }
}



// public function checkout(Request $request)
// {
//     $cart_items = Cart::where('user_id', auth()->id())->get();

//     if ($cart_items->isEmpty()) {
//         return redirect()->route('cart')->with('error', 'Your cart is empty.');
//     }

//     // Proceed with checkout
// }




    public function removeCoupon()
    {
        // dd(session()->all());
        // Check if the cart ID exists in the session
        if (session('cart_id')) {
            $quote = Quote::with('items')->where('cart_id', session('cart_id'))->first();
            // dd($quote);
    
            if ($quote) {
                // Reset the coupon-related fields in the database
                $quote->coupon = null;
                $quote->coupon_discount = 0;
                $quote->save();
    
                // Recalculate subtotal and total
                $subtotal = $quote->items->sum('row_total');
                // dd($subtotal);
                $quote->total = $subtotal; // Adjust total based on new subtotal
                $quote->save();
    
                return redirect()->back()->with('message', 'Coupon removed successfully!');
            }
        }

        return redirect()->back()->with('message', 'Cart not found.');
    }
    
    


    
    
}
