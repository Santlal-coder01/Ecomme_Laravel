<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Enquiry;
use DataTables;
use Illuminate\Support\Facades\Gate;
class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    
    //   abort_if(Gate::denies('enquiry_index'), 403);
      if ($request->ajax()) {


        $data = Enquiry::select('*');
        // $page= Auth()->user();

        return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $btn = '';
                    if ($row->status == 1) {
                        $btn .= '<a href="' . route('updateStatus', $row->id) . '" class="btn btn-warning btn-sm">Un-Read</a>';
                    }else{
                        $btn .= '<p  class="btn btn-success btn-sm">Read</p>';
                    }
                    return $btn;
                })
                ->addColumn('action', function($row){

                    $btn = '<a href="'.route('enquiry.show',$row->id).'" class="edit btn btn-primary btn-sm">View</a>';
                 
                    // $btn .= '<a href="'.route('enquiry.edit',$row->id).'" class="edit btn btn-success btn-sm">edit</a>';
            
                    // $btn .= '<form action="'.route('enquiry.destroy',$row->id).'" method="post" style="display:inline">
                    // '.csrf_field().' '.method_field('DELETE').'
                    //   <button type="submit" class="btn btn-danger ml-0 p-2">DELETE</button>
                    //   </form>';
             
                    return $btn;

                })

                ->rawColumns(['action','status'])

                ->make(true);

    }
       return view('admin.enquiries.index');
    }

    public function updateStatus(string $id)
    {
        // dd($id);
        $enquiry = Enquiry::find($id);
        $enquiry->status = ($enquiry->status == 1) ? 2 : 2;
        $enquiry->update();
    
        return redirect()->route('enquiry.index');

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enquiry = Enquiry::find($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     Enquiry::where('id',$id)->delete();
     return redirect()->route('enquiry.index');
    }
}
