<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('permission.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('permission.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('permission.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    dd($request->all());
    $store = $request->validate([
        'name' => 'required'
    ]);
    Permission::create($store);
    if($request->PermissionName){
       foreach($request->PermissionName as $key=> $pname){
        $name = $pname;
        $nnn= [
            'name' =>$name,
        ];
        Permission::create($nnn);
       }
       
    }
    return redirect()->route('permission.index');
    }
  

    /**
     * Display the specified resource.
     */
   
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Permission $permission)
    {
        $updateDta = $request->validate([
            'name' => 'required'
        ]);

       $permission->update($updateDta);
        if($request->PermissionName){
            foreach($request->PermissionName as $key=> $pname){
             $name = $pname;
             $nnn= [
                 'name' =>$name,
             ];
             Permission::create($nnn);
            }
            
         }

        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
       $permission->delete();
       return redirect()->route('permission.index');
    }
}