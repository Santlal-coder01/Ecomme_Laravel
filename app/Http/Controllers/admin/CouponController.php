<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use Illuminate\Support\Facades\Gate;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('coupon_index'), 403);

        if ($request->ajax()) {
            $data = Coupon::select('*');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status == '1' ? 'Enable' : 'Disable';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('coupon.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                    $btn .= '<a href="'.route('coupon.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                    $btn .= '<form action="'.route('coupon.destroy', $row->id).'" method="POST" style="display:inline">
                              '.csrf_field().' '.method_field('DELETE').'
                              <button type="submit" class="btn btn-danger ml-0 p-2">Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        abort_if(Gate::denies('coupon_create'), 403);

        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('coupon_store'), 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code',
            'status' => 'required',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupon.index')->with('success', 'Coupon created successfully.');
    }

    /**
     * Display the specified coupon.
     */
    public function show($id)
    {
        // abort_if(Gate::denies('coupon_show'), 403);

        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit($id)
    {
        abort_if(Gate::denies('coupon_edit'), 403);

        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('coupon_edit'), 403);

        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'coupon_code' => 'required',
            'status' => 'required',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        $coupon->update($request->all());

        return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('coupon_delete'), 403);

        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully.');
    }
}
