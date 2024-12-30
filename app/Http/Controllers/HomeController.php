<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin\Enquiry;
use App\Models\admin\Slider;
use App\Models\admin\Category;
use App\Models\e_store\Wishlist;
use App\Models\e_store\Quote;
use App\Models\admin\Product;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\admin\Page;
use App\Models\admin\Attribute;
use App\Models\admin\ProductAttribute;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
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
    
        $products = Product::where('status', 1)
            ->orderBy($o_column, $o_order)
            ->get();
    
        $sliders = Slider::all();

        $productss = Product::where('status', 1)
        ->orderBy($o_column,$o_order)
        ->where('is_featured', 0)
        ->get();

        $categories = Category::where('parent_category',0)->get();
    
        return view('index', compact('sliders', 'products', 'sortorder','productss','categories'));
    }
    
    
    
   public function contact(){
    return view('contact');
   }

   public function contactPost(Request $request){
      // dd($request->all());
      $request->validate([
         'name' =>'required',
         'email' => 'required',
         'contact' => 'required',
         'message' => 'required',
      ]);

      Enquiry::create([
         'name' => $request->name,
         'email' => $request->email,
         'contact' => $request->contact,
         'message'  => $request->message,
      ]);

      return redirect()->back();

   }

   public function category($url_key){
      $categories = Category::where('url_key',$url_key)->get();
      $product_category = Product::where('url_key',$url_key)->get();
      return view('category',compact('product_category','categories'));
  }
  
  public function subCatg($url_key,Request $request){
      // dd($url_key);
      $category = Category::where('url_key',$url_key)->first();
      $products = $category->products;
      $subcategories =  Category::where('url_key',$url_key)->get();
      return view('subcategory',compact('products','subcategories')); 
   }

      public function detail($url_key){
         // dd($url_key);
         $details = Product::where('url_key',$url_key)->first();
        // $categoryId = $details->category_id;
        // dd($categoryId);
         $attributes = Product::with('productattribute.attributeValue','productattribute.attribute')->where('url_key',$url_key)->first();
        //  dd($attributes);

         if ($attributes->url_key == $url_key) {
            // $productIds=[];
            $productIds = explode(',',$attributes->related_product);
            // dd($productIds);
            // $relatedproducts = Product::whereIn('id', $productIds)->get();
            // dd($relatedproducts);
            $relatedproducts = Product::whereIn('id', $productIds)->get();
            // dd($relatedproducts);
         }

         return view('detail',compact('details','relatedproducts','attributes'));
      }

      public function Profile($id){
         // dd($id);
         $users = User::where('id',$id)->get();
         return view('admin.profile',compact('users'));
       }

      public function changePass($id){
         // dd($id);
         $users = User::where('id',$id)->get();
         return view('admin.profile',compact('users'));
       }


       public function PasswordForm()
       {
           return view('admin.change_password');
       }
   
       public function changePassword(Request $request)
       {
           $request->validate([
               'current_password' => 'required',
               'new_password' => 'required',
               'confirm_password' => 'required|same:new_password',
           ]);
           if (!Hash::check($request->current_password, Auth::user()->password)) {
               return back()->withErrors(['current_password' => 'Your current password does not match our records.']);
           }     
           Auth::user()->update(['password' => Hash::make($request->new_password)]);
           return redirect()->route('user.profile', Auth::user()->id)->with('success', 'Password changed successfully.');
       }



       function search(Request $req)
    {
        $data= Product::where('name', 'like', '%'.$req->input('query').'%')->get();
        return view('search',['products'=>$data]);
    }

    public function loginFront(){
      return view('login');
    }
    public function loginFrontPost(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($req->only('email', 'password'))) {
            $user = Auth::user(); // Get logged-in user
            $req->session()->put('user', $user); // Save user in session
    
            // Debug session cart_id
            logger('Cart ID in session: ' . session('cart_id'));
    
            // Redirect to homepage after successful login
            return redirect()->route('homepage')->with('success', 'You are logged in!');
        }
    
        return back()->with('error', 'Invalid email or password.');
    }
    

    public function ragisterFront(){
      return view('registerFront');
    }


    public function register(Request $req)
    {
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->is_admin = 1;
        $user->save();

        $message = "Welcome to Our website";
        $subject = "Ke Levn aayo hai";
        $products = Product::where('status', 1)->get();

        try {
            $request = Mail::to($user->email)->send(new welcomeMail($message, $subject, $products));
                // echo "Mail sent successfully.";
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: ' . $e->getMessage());
    
                // echo "Mail could not be sent. Please try again later.";
            }
    
        // Pass email and password to loginFront as query parameters
        return redirect()->route('loginFront')->with([
            'email' => $req->email,
            'password' => $req->password,
        ]);
    }


    public function pages($url_key){
        $pages = Page::where('url_key',$url_key)->first();
        return view('page',compact('pages'));
    }


    

}


