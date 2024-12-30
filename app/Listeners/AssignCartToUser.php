<?php

namespace App\Listeners;

// use App\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Authenticated;
use App\Models\e_store\Quote;

class AssignCartToUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(Authenticated $event)
    {
        logger('AssignCartToUser Listener triggered'); 
    
        $user = $event->user; 
        // dd($user);
        logger('Authenticated User: ' . $user->id);
    
        if ($user) {
            $cartId = session('cart_id'); 
            // dd($cartId);
            logger('Cart ID from session: ' . $cartId);
    
            if ($cartId) {
                // dd(session('cart_id')); 

                $cart = Quote::where('cart_id', $cartId)->whereNull('user_id')->first();
                // dd($cart);
    
                if ($cart) {
                    $cart->user_id = $user->id;
                  
                    $cart->save();
                    // session()->forget('cart_id'); 
                    logger('Cart assigned to User ID: ' . $user->id);
                } else {
                    logger('already assigned');
                }
            } else {
                logger('No cart ID');
            }
        }
    }
    
    
}
