<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\e_store\Order;
use App\Models\e_store\OrderAddress;
use App\Models\e_store\Quote;
use App\Models\e_store\OrderItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderMail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'address_2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'payment' => 'required',
            'shipping_method' => 'nullable',
            'shipping_cost' => 'nullable',
            'subtotal' => 'nullable',
            'total' => 'required',
            'shipping_name' => 'required',
            'shipping_email' => 'required|email',
            'shipping_phone' => 'required',
            'shipping_address_1' => 'required',
            'shipping_address_2' => 'nullable',
            'shipping_city' => 'required',
            'shipping_state' => 'required',
            'shipping_country' => 'required',
            'shipping_pincode' => 'required',
        ]);


        $userId = Auth::user()->id;
        // dd($userId);
    
        $quote = Quote::where('cart_id', session('cart_id'))->first();
        if (!$quote) {
            return redirect()->back()->with('error', 'Cart not found.');
        }


        $lastOrder = Order::orderBy('id', 'desc')->first();
        // dd($lastOrder);

        if ($lastOrder && is_numeric($lastOrder->order_increment_id)) {
            $orderIncrementId = $lastOrder->order_increment_id + 1;
        } else {
            $orderIncrementId = 100000;
        }
      

        $order = Order::create([
            'order_increment_id' => $orderIncrementId,
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'address_2' => $validatedData['address_2'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'country' => $validatedData['country'],
            'pincode' => $validatedData['pincode'],
            'coupon' => $quote->coupon ?? null,
            'coupon_discount' => $quote->coupon_discount ?? null,
            'total' => $validatedData['total'],
            'payment_method' => $validatedData['payment'],
            'shipping_method' => $validatedData['shipping_method'],
            'shipping_cost' => $validatedData['shipping_cost'],
            'sub_total' => $validatedData['subtotal'],
        ]);
    
        // Save Billing Address
        $billingAddress = OrderAddress::create([
            'order_id' => $order->id,
            'user_id'  => auth()->id(),
            'address_type' => 'billing',
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'address_2' => $validatedData['address_2'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'country' => $validatedData['country'],
            'pincode' => $validatedData['pincode'],
        ]);
    
        // Save Shipping Address
        $shippingAddress = OrderAddress::create([
            'order_id' => $order->id,
            'user_id'  => auth()->id(),
            'address_type' => 'shipping',
            'name' => $request->input('shipping_name') ?? $validatedData['name'],
            'email' => $request->input('shipping_email') ?? $validatedData['email'],
            'phone' => $request->input('shipping_phone') ?? $validatedData['phone'],
            'address' => $request->input('shipping_address_1') ?? $validatedData['address'],
            'address_2' => $request->input('shipping_address_2') ?? $validatedData['address_2'],
            'city' => $request->input('shipping_city') ?? $validatedData['city'],
            'state' => $request->input('shipping_state') ?? $validatedData['state'],
            'country' => $request->input('shipping_country') ?? $validatedData['country'],
            'pincode' => $request->input('shipping_pincode') ?? $validatedData['pincode'],
        ]);
    
        // Move Quote Items to Order Items
        $quotes = Quote::where('cart_id', session('cart_id'))->first();
        foreach ($quotes->items as $quoteItem) {
            // dd($quoteItem);
           $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $quoteItem->product_id,
                'name' => $quoteItem->name,
                'sku' => $quoteItem->sku,
                'price' => $quoteItem->price,
                'qty' => $quoteItem->qty,
                'row_total' => $quoteItem->price * $quoteItem->qty,
                'custom_option' => json_encode($quoteItem->custom_option),
            ]);

            // dd($orderItem);
        }

  
    
        // Clear Quote Items and Reset Totals
        $quote->items()->delete();
        $quote->coupon = null;
        $quote->coupon_discount = 0;
        $quote->subtotal = 0;
        $quote->total = 0;
        $quote->save();
       

        $ordersend = Order::with(['items', 'addresses'])->where('id', $order->id)->first();
        // dd($ordersend);
        try {
        Mail::to('santlalpuri9@gmail.com')->send(new OrderMail($ordersend));
            // echo "Mail sent successfully.";
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());

            // echo "Mail could not be sent. Please try again later.";
        }
        return redirect()->route('order_submit')->with('success', 'Order placed successfully!');
    }
    

    public function index($id){
        // dd('hii');
        $order = Order::where('user_id',auth()->id())->where('id',$id)->first();
        $orders = Order::where('user_id',auth()->id())->get();
        return view('order_detail',[
            'order' => $order,
            'orders' => $orders,
            ]); 
    }

    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('order', compact('orders'));
    }

    public function orderSubmit(){
        // $order = Order::where('user_id',auth()->id())->where('id',$id)->first();
        return view('order_submit');
    }




    public function Addressupdate(Request $request, $id)
{
    // dd($request->all());
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address1' => 'required',
        'address_2' => 'nullable',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'pincode' => 'required',
    ]);
        $validatedData = $request->all();
        // dd($validatedData);
    
        // Find the address by ID and type
        $address = OrderAddress::where('address_type', $request->address_type)
                          ->first();
    // dd($address);
        if (!$address) {
            return redirect()->back()->with('error', ucfirst($request->address_type) . ' address not found or invalid type!');
        }
    
        // Update the address
        $address->update($validatedData);
    
        return redirect()->back()->with('success', ucfirst($request->address_type) . ' address updated successfully!');
    }



    public function addAddress(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required',
            'address'    => 'required|string|max:255',
            'address_2'  => 'nullable|string|max:255',
            'city'       => 'required|string|max:100',
            'state'      => 'required|string|max:100',
            'country'    => 'required|string|max:100',
            'pincode'    => 'required|digits_between:4,10',
            'address_type' => 'required',
        ]);
    
        $order = Order::find($request->order_id); 
        // dd($order);
    
        $newAddress = OrderAddress::create([
            'order_id'    => $order->id,
            'user_id'     => auth()->id(),
            'address_type' =>$validatedData['address_type'],
            'name'        => $validatedData['name'],
            'email'       => $validatedData['email'],
            'phone'       => $validatedData['phone'],
            'address'     => $validatedData['address'],
            'address_2'   => $validatedData['address_2'],
            'city'        => $validatedData['city'],
            'state'       => $validatedData['state'],
            'country'     => $validatedData['country'],
            'pincode'     => $validatedData['pincode'],
        ]);
    
        // return response()->json(['message' => 'Address added successfully!', 'address' => $newAddress], 201);
        return redirect()->back()->with('success','Address added successfully!');
    }


    public function destroy($id)
    {
        $address = OrderAddress::find($id);
        if (!$address) {
            return redirect()->back()->with('error', 'Address not found!');
        }
    
        $address->delete();
    
        return redirect()->back()->with('success', 'Address deleted successfully!');
    }
    



}
