<?php
use App\Models\admin\Page;
use App\Models\admin\Block;
use App\Models\admin\Category;
use App\Models\e_store\QuoteItem;
use App\Models\e_store\Wishlist;


// if(!function_exists('menu')){
// function menu(){
//     $pages = Page::all();

//     return $pages;
// }
// function block(){
//     $blockk = Block::all();

//     return $blockk;
// }



if(!function_exists('headpage')){
        function setActive($routeName)
        {
            return Route::currentRouteName() === $routeName ? 'active' : '';
        }

        function headpage(){
            $headpage = Page::where('status',1)->where('show_in_menu',1)->get();
            return $headpage;
        }

        function footpage(){
            $footpage = Page::where('status',1)->where('show_in_footer',1)->get();
            return $footpage;
        }

        function category(){
            $category = Category::where('status',1)->where('parent_category',0)->get();
            return $category;

        }

        function subCategory($category){
            $subCategory = Category::where('status',1)->where('parent_category',$category)->get();
            return $subCategory;
        }

        function getSpecialPrice($price, $specialPrice = null, $specialPriceFrom = null, $specialPriceTo = null)
            {
                // Check if special price exists
                if ($specialPrice && $specialPrice > 0) {
                    $today = now(); // Current date

                    // Check if special price is within the date range
                    if (
                        (!$specialPriceFrom && !$specialPriceTo) || // No date range defined
                        ($specialPriceFrom && !$specialPriceTo && $today >= $specialPriceFrom) || // Only start date defined
                        (!$specialPriceFrom && $specialPriceTo && $today <= $specialPriceTo) || // Only end date defined
                        ($specialPriceFrom && $specialPriceTo && $today >= $specialPriceFrom && $today <= $specialPriceTo) // Both dates defined
                    ) {
                        return $specialPrice; // Return special price
                    }
                }

                // Default: Return original price
                return $price;
            }

            // function CartItem()
            // {
            //     $cartItem =  QuoteItem::count();
            //     return $cartItem;
            // }

            // function WishlistItem(){
            //     $wishlistitem = Wishlist::count();
            //     return $wishlistitem;
            // }
            

}

// }