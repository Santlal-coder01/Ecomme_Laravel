<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\e_store\Order;
use PDF;

class ManageOrderController extends Controller
{
    public function order_list(Request $request)
    {
        // dd($request->all());
        try {
            // Fetch paginated data (10 records per page)
            $orders = Order::paginate(10);

            return view('admin.manage_order.index', compact('orders'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        return view('admin.manage_order.index');
    }

    public function order_show($id){
        // dd($id);
        $order = Order::with('items')->with('addresses')->where('id',$id)->first();
        // dd($order);
        return view('admin.manage_order.show',compact('order'));
    }

    public function pdf_invoice($id){

        $order = Order::where('id',$id)->with(['items'])->first();
        // return View('invoice',compact('order'));
        $pdf = PDF::loadView('invoice',compact('order'));
        return $pdf->download('invoice'.$order->id.'.pdf'); 
        
    }


}
