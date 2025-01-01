<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\e_store\Order;
use App\Models\e_store\OrderAddress;
use App\Models\e_store\OrderItem;
use App\Models\admin\Product;
use App\Models\admin\Slider;
use Illuminate\Http\Request;
use App\Models\admin\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show_profile()
    {
        // Check for the user guard
        // dd('fghjkl');
        if (Auth::guard('web')->check()) {
            $userId = auth()->user()->id;
            $orders = Order::where('user_id', $userId)->with('product')->get();
            // dd($orders)
            // $address = OrderAddress::where('user_id', $userId)->distinct('address')->get();
            // dd($address);
            
            
            return view('profile', compact('orders'));
        }
        

    }


    public function userAddress(){

        if (Auth::guard('web')->check()) {
            // Fetch the authenticated user's ID
            $userId = auth()->user()->id;
    
            // Fetch addresses associated with the user
            $addresss = OrderAddress::where('user_id', $userId)->get();
            
            // If addresses exist, get the first one (you may need to update this logic)
            $address = OrderAddress::where('user_id', $userId)->first();
            // dd($address);
    
            return view('user_address', compact('addresss', 'address'));
        }

    }


    public function homepage(Request $request){
        // dd('jjj');
        if(Auth::guard('web')->check()){
            $sortorder = $request->query('sortorderby', -1);
    
            // Define sorting logic based on `sortorderby` value
            switch ($sortorder) {
                case 1:
                    $o_column = 'created_at';
                    $o_order = 'DESC';
                    break;
                case 2:
                    $o_column = 'created_at';
                    $o_order = 'ASC';
                    break;
                case 3:
                    $o_column = 'price';
                    $o_order = 'ASC';
                    break;
                case 4:
                    $o_column = 'price';
                    $o_order = 'DESC';
                    break;
                default:
                    $o_column = 'id';
                    $o_order = 'DESC';
                    break;
            }

            $categories = Category::where('parent_category',0)->get();
        
            $products = Product::where('status', 1)
                ->orderBy($o_column, $o_order)
                ->get();
        
            $sliders = Slider::all();
    
            $productss = Product::where('status', 1)
            ->orderBy($o_column,$o_order)
            ->where('is_featured', 0)
            ->get();
        
            return view('index', compact('sliders', 'products', 'sortorder','productss','categories'));
    
        }else{
            return redirect()->route('loginFront'); // Redirect to user login
        }
    }
    


    public function showPaymentMethods()
    {
        // return view('e-store.payment-methods');
    }

    // Show user's orders (You need to implement this method and view)
    public function showOrders()
    {
        // $orders = Order::where('user_id', Auth::user()->id)->get();
        // return view('e-store.orders', compact('orders'));
    }

    public function updateDeatails(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $user = Auth::user();

        // dd($user);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,

        ]);

        return redirect()->route('show_profile');
        // dd($request->all());

    }

    public function logout()
    {
        Auth::logout();
        session()->forget('cart_id');
        return redirect()->route('/')->with('success','Logout profile successfully');
    }

    public function changePass(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'con_new_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return bacK()->with('error', 'Wrong Data');
        } else {
            $password = Hash::make($request->new_password);

            $user->update([
                'password' => $password,
            ]);

            return redirect()->route('logoutfront');
            // dd($request->all());
        }

    }

    public function order_detail($id)
    {
        // dd($id);
        $order = Order::where('id', $id)->first();
        // dd($order);
        $orderitem = OrderItem::where('order_id', $id)->first();

        // dd($orderitem);

        return view('order_detail', compact('order', 'orderitem'));
        // dd($id);
    }

}
