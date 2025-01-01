<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\BlockController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\AttributeValueController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\EnquiryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\admin\ManageOrderController;
// use App\Http\Middleware\CheckAdmin;

Route::get('/admin', function() {
    return redirect()->route('/');
});

//HomeController Route...
Route::get('/',[HomeController::class,'index'])->name('/');
Route::get('contact',[HomeController::class,'contact'])->name('contact');
Route::post('contact/post',[HomeController::class,'contactPost'])->name('contact.post');
Route::get('categories/{url_key}',[HomeController::class,'category'])->name('categories');
Route::get('subCatg/{url_key}',[HomeController::class,'subCatg'])->name('subCatg');
Route::get('detail/{url_key}',[HomeController::class,'detail'])->name('detail');
Route::get('user/profile/{id}',[HomeController::class,'Profile'])->name('user.profile');
Route::get('/user/change_password', [HomeController::class, 'PasswordForm'])->name('changePass');
Route::post('/user/change-password', [HomeController::class, 'changePassword'])->name('password.update');
Route::get("search",[HomeController::class,'search']);
Route::get('pages/{url_key}',[HomeController::class,'pages'])->name('pages');
Route::get('/products/sort', [HomeController::class, 'sort'])->name('products.sort');


// WishlistController
Route::post('wishlist',[WishlistController::class,'addToWishlist'])->name('wishlist');
Route::get('showWishlist',[WishlistController::class,'showWishlist'])->name('showWishlist');
Route::post('wishlistremove/{id}',[WishlistController::class,'removeFromWishlist'])->name('wishlist.remove');
Route::post('addCart/{id}',[WishlistController::class,'addToCartToWishlist'])->name('addCart');;

//CartController
Route::post('add_to_cart',[CartController::class,'addToCart'])->name('add_to_cart');
Route::get('showcart',[CartController::class,'showCart'])->name('showcart');
Route::post('cartremove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/applyCoupon', [CartController::class, 'discount'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');


// Login to HomeController
Route::get('login',[HomeController::class,'loginFront'])->name('loginFront');
Route::post('loginFront/post',[HomeController::class,'loginFrontPost'])->name('loginFrontPost');
Route::get('ragisterFront',[HomeController::class,'ragisterFront'])->name('ragisterFront');
Route::post('register',[HomeController::class,'register']);


// Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');



Route::group(['middleware' => ['auth','check.user'],'prefix' => ''],function() {
    Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');
    Route::get('homepage', [ProfileController::class, 'homepage'])->name('homepage');
    Route::post('/profile/update', [ProfileController::class, 'updateDeatails'])->name('update_profile');
    Route::get('/profile/payment-methods', [ProfileController::class, 'showPaymentMethods'])->name('user_payment_methods');
    Route::post('/profile/change-password', [ProfileController::class, 'changePass'])->name('change_password');
    Route::get('/profile/orders', [ProfileController::class, 'showOrders'])->name('user_orders');
    Route::get('/order/{id}/detail', [ProfileController::class, 'order_detail'])->name('order_detail');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logoutfront');
    Route::get('checkout',[CheckoutController::class,'checkout'])->name('checkout');
    // Route::get('checkoutfile',[CheckoutController::class,'index'])->name('checkoutfile');
    Route::post('/orders',[OrderController::class,'store'])->name('orders');
    Route::get('orders/success{id}',[OrderController::class,'index'])->name('order.success');
    Route::get('user/orders', [OrderController::class, 'userOrders'])->name('user_orders');
    Route::get('order/submit',[OrderController::class,'orderSubmit'])->name('order_submit');
    Route::get('user/address',[ProfileController::class,'userAddress'])->name('user_address');
    Route::put('/update-address/{id}', [OrderController::class, 'Addressupdate'])->name('order_addressupdate');
    Route::post('/address/add',[OrderController::class,'addAddress'])->name('add_address');
    Route::delete('delete_address{id}', [OrderController::class, 'destroy'])->name('delete_address');
    Route::get('/categories', [CategoryController::class, 'showCategories'])->name('categories');
    Route::get('/categories/{id}', [CategoryController::class, 'showCategoryProducts'])->name('category.products');
    // Route::post('/wishlist', [WishlistController::class, 'addToWishlist'])->name('wishlist');
    // Route::post('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

});

//LoginController Route...

    Route::get('admin/login',[LoginController::class,'login'])->name('login')->middleware('check.admin');
    Route::post('admin/post',[LoginController::class,'loginPost'])->name('login.post')->middleware('check.admin');

    Route::get('updateStatus/{id}', [EnquiryController::class, 'updateStatus'])->name('updateStatus');

 

    Route::group(['middleware' => ['auth','check.admin'], 'prefix' => 'admin'], function () {
        Route::resource('page', PageController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('block', BlockController::class);
        Route::resource('product', ProductController::class);
        Route::resource('attribute', AttributeController::class);
        Route::resource('attribute-values', AttributeValueController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);
        Route::resource('coupon', CouponController::class);
        Route::resource('enquiry', EnquiryController::class);
        Route::get('manage_order', [ManageOrderController::class, 'order_list'])->name('order_list');
        Route::get('order/show/{id}', [ManageOrderController::class, 'order_show'])->name('order.show');
        Route::get('pdf/invoice/{id}', [ManageOrderController::class, 'pdf_invoice'])->name('pdf.invoice');
        // Route::post('action/post', [ProductController::class, 'action'])->name('action.post');
    });
    


