<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
  public function index(Request $request)
  {
      
      if ($request->ajax()) {
   
          $data = User::select('*');
       

          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('roles', function($row){

                    $row = implode(', ',$row->roles->pluck('name')->toArray());
                    return $row;
                  })
                  ->addColumn('action', function($row){
                          $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';    
                      
                            $btn .= '<a href="'.route('user.edit', $row->id).'" class="edit btn btn-success">Edit</a>'; 
                 
                          $btn .= '<form action="'.route('user.destroy',$row->id).'" method="post" style="display:inline">
                          '.csrf_field().' '.method_field('DELETE').'
                            <button type="submit" class="btn btn-danger ml-0 p-2">DELETE</button>
                            </form>';
                  
                          return $btn;
                  })
                  ->addColumn('image', function($row){
                    $image = '<img src="'.$row->getFirstMediaUrl('image').'" style="width: 35px;height: 35px;border-radius: 50%;">';

                    return $image;
                })
                  ->rawColumns(['action','image','roles'])
                  ->make(true);
              }
        return view('admin.users.index');
    }

    public function create(){

      $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }
    public function store(Request $request){

      $validateData = $request->validate([
        'name' => 'required',
        'email' => 'required|email:true|unique:users',
        'password' => 'required',
        'con_password' => 'required|same:password',
      ]);
      $validateData['password'] = Hash::make($request->password);

      $user = User::create($validateData);
      if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $user->addMediaFromRequest('image')->toMediaCollection('image');
    }
      $user->syncRoles($request->roles);

      return redirect()->route('user.index');
    }

    public function edit(Request $request,string $id)
    {

        // dd($request->all());
        $roles = Role::all();
        $user = User::find($id);
      return view('admin.users.edit',compact('user','roles'));
    }


    public function update(Request $request,User $user)
    {

    //  dd($request->all());
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required',
        // 'contact' => 'required',
        'password' => 'required',
    ]);
    
    $data['password'] = Hash::make($request->password);
    $user->update($data);
    $user->syncRoles($request->roles);

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $user->clearMediaCollection('image');
      $user->addMediaFromRequest('image')->toMediaCollection('image');
  }
    return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
    //   abort_if(Gate::denies('user_delete'), 403);
        $user->delete();
        return redirect()->route('user.index');
    }

}
