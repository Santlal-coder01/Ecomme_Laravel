<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\e_store\Wishlist;  
use App\Models\e_store\QuoteItem;  
use App\Models\e_store\Quote;  
use App\Models\admin\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Str;


class WishlistController extends Controller
{
    // public function __construct()
    // {
    //     // Ensure the user is authenticated before accessing any methods in this controller
    //     $this->middleware('auth');
    // }

    // Show wishlist items
    


    public function addToWishlist(Request $request)
    {
        // Get user ID from session
        if (!Auth::check()) {
        //     // Redirect to login page with a message
            return redirect()->route('loginFront')->with('error', 'Please log in to add products to your wishlist.');
        }
        $userId = Session::get('user')['id'];
        $productId = $request->input('product_id');
        // dd($userId, $productId);
    
        // Check if the product is already in the wishlist
        $existingItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();
        // dd($existingItem);
    
        if ($existingItem) {
            return redirect()->back()->with('message', 'Product already in wishlist.');
        }
    
        // Add the product to the wishlist
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    
        // Add success message to the session
        return redirect()->back()->with('message', 'Product added successfully to wishlist.');
    }
    
    
    public function removeFromWishlist($id)
    {
        $user = auth()->user();
        // dd($user);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
    
        $wishlistItem = Wishlist::where('user_id', $user->id)->first();
        // dd($wishlistItem);
    
        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('message', 'Product removed from your wishlist.');
        }
    
        return redirect()->back()->with('error', 'Product not found in your wishlist.');
    }
    
    
        // return redirect()->route('loginFront')->with('error', 'You need to login first.');
    
    

    public function showWishlist()
    {
        // if (auth()->check()) {
            // $wishlist = auth()->user()->wishlist()->with('product')->get();
            $wishlist = Wishlist::all();
            return view('wishlist', compact('wishlist'));
        // }
    
        // return redirect()->route('loginFront')->with('error', 'You need to login first.');
    }
  
    // public function addToCart($productId)
    // {
    //     if (auth()->check()) {
    //         $product = Product::findOrFail($productId);

    //         $cart = session()->get('cart', []);
    //         $cart[] = $product;

    //         session()->put('cart', $cart);

    //         return redirect()->route('showcart')->with('message', 'Item added to cart');
    //     }

    //     return redirect()->route('loginFront')->with('error', 'You need to login first.');
    // }

    public function addToCartToWishlist(Request $request, $id)
    {
        // dd($request->all());
        
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You need to be logged in to add products to the cart.');
        }
    
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        $quote = Quote::where('cart_id', session('cart_id'))->firstOrCreate();
        // dd($quote);
    
        $existingQuoteItem = QuoteItem::where('quote_id', $quote->id)
            ->where('product_id', $product->id)
            ->first();
    
        if ($existingQuoteItem) {
            $existingQuoteItem->qty += 1;
            $existingQuoteItem->row_total = $existingQuoteItem->qty * $product->price;
            $existingQuoteItem->save();
        } else {
            $customOptions = $request->input('attributes', []);
            $specialPrice = null;

           
            if ($product->special_price && 
                now()->between($product->special_price_from, $product->special_price_to)) {
                $specialPrice = $product->special_price;
            }
            
            
            $price = $specialPrice ? $specialPrice : $product->price;
            
            $quoteItem = new QuoteItem([
                'quote_id' => $quote->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $price, 
                'qty' => 1, 
                'row_total' => $price * 1, 
                'custom_option' => json_encode($customOptions), 
            ]);
            
            
            $quoteItem->save();
        }
    
        $quote->total = QuoteItem::where('quote_id', $quote->id)->sum('row_total');
        $quote->save();

        Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->delete();
    
        return redirect()->back()->with('message', 'Product added to the cart successfully.');
    }
    
}
