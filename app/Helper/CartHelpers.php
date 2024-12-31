<?php

use Illuminate\Support\Facades\Auth;
use App\Models\e_store\Quote;
use App\Models\e_store\QuoteItem;
use App\Models\e_store\Wishlist;

if (!function_exists('CartItem')) {
    function CartItem()
    {
        // Check if the user is logged in
        $user = Auth::user();
        if (!$user) {
            return 0; // Return 0 if the user is not logged in
        }
    
        // Get the cart ID from the session
        $cartId = Quote::where('user_id', $user->id)->first();
        // dd($cartId);
    
        // Check if $cartId is null
        if (!$cartId) {
            return 0; // Return 0 if no cart is found
        }
    
        // Fetch the quote for the user or the session
        $quote = Quote::where('cart_id', $cartId->cart_id)->first();
        // dd($quote);
    
        // Check if $quote is null
        if (!$quote) {
            return 0; // Return 0 if no quote is found
        }
    
        // Count the items in the quote
        $itemCount = QuoteItem::where('quote_id', $quote->id)->count();
        // dd($itemCount);
    
        return $itemCount;
    }
    
}



if (!function_exists('WishlistItem')) {
    function WishlistItem()
    {
        // Assume there's a Wishlist model for user wishlist items
        $userId = Auth::user()->id ?? null;

        // If a user is logged in, count their wishlist items
        if ($userId) {
            return Wishlist::where('user_id', $userId)->count();
        }

        return 0; // Guest users don't have a wishlist
    }
}
