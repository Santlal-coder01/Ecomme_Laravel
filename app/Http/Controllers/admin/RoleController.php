<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('permissions', function($row){

                        $row = implode(', ',$row->permissions->pluck('name')->toArray());
                        return $row;
                      })
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('role.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('role.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('role.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->rawColumns(['action','permissions'])
                    ->make(true);
        }
  return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::all();
        return view('admin.roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index');
    }
}