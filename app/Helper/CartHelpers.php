<?php

use Illuminate\Support\Facades\Auth;
use App\Models\e_store\Quote;
use App\Models\e_store\QuoteItem;
use App\Models\e_store\Wishlist;

if (!function_exists('CartItem')) {
    function CartItem()
    {
        // Check if the user is logged in
        $userId = Auth::check() ? Auth::id() : null;

        // Get the cart ID from the session
        $cartId = session('cart_id');

        // Fetch the quote for the user or the session
        $quote = Quote::where('cart_id', $cartId)->first();

        if (!$quote) {
            return 0;
        }

        $itemCount = QuoteItem::where('quote_id', $quote->id)->count();

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
