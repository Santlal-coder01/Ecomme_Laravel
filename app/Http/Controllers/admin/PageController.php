<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\admin\Page;
use DataTables;
use Illuminate\Support\Facades\Gate;


class PageController extends Controller
{

    public function index(Request $request)
    {
    //   abort_if(Gate::denies('page_index'), 403);
      if ($request->ajax()) {

        $data = Page::select('*');
        // $page= Auth()->user();

        return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                  return $row->status == '1' ? 'Enable' : 'Disable';
              })
              ->addColumn('show_in_menu', function ($row) {
                return $row->show_in_menu == '0' ? 'No' : 'Yes';
            })
            ->addColumn('show_in_footer', function ($row) {
              return $row->show_in_footer == '0' ? 'No' : 'Yes';
          })
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    // if($page->can('page_edit')){
                    $btn .= '<a href="'.route('page.edit',$row->id).'" class="edit btn btn-success btn-sm">edit</a>';
                    // }
                    // if($page->can('page_delete')){
                    $btn .= '<form action="'.route('page.destroy',$row->id).'" method="post" style="display:inline">
                    '.csrf_field().' '.method_field('DELETE').'
                      <button type="submit" class="btn btn-danger ml-0 p-2">DELETE</button>
                      </form>';
                    // }
                    return $btn;

                })
                ->addColumn('image', function($row){

                    $image = '<img src="'.$row->getFirstMediaUrl('img').'" width="50px">';

                    return $image;
                })

                ->rawColumns(['action','description','image'])

                ->make(true);

    }

       return view('admin.pages.index');
    }


    public function create()
    {
    //   abort_if(Gate::denies('page_create'), 403);
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
      // abort_if(Gate::denies('page_store'), 403);
      // dd($request->all());
       $request->validate([
            'name' => 'required',
            'status' => 'required',
            'show_in_menu' => 'required',
            'show_in_footer' => 'required',
            'description' => 'required',
            'meta_tag' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
          ]);

          $StoreData = [
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'show_in_footer' => $request->show_in_footer,
            'description' => $request->description,
            'url_key' => $request->meta_title,
            'meta_tag'=>$request->meta_tag,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,         
          ];
        //   dd($validateData);
        $page = Page::create($StoreData);

        if($request->hasFile('img') && $request->file('img')->isValid()){
          $page->addMediaFromRequest('img')->toMediaCollection('img');
        }
          return redirect()->route('page.index');
        }
    


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
      // abort_if(Gate::denies('page_edit'), 403);
        $page = Page::find($id);
        return view('admin.pages.edit',compact('page'));
    }


    public function update(Request $request,Page $page)
    {
      // abort_if(Gate::denies('page_update'), 403);
      $request->validate([
        'name' => 'required',
        'status' => 'required',
        'show_in_menu' => 'required',
        'show_in_footer' => 'required',
        'description' => 'required',
        'meta_tag' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'required',
      ]);

      $UpdateData = [
        'name' => $request->name,
        'status' => $request->status,
        'show_in_menu' => $request->show_in_menu,
        'show_in_footer' => $request->show_in_footer,
        'description' => $request->description,
        'url_key' => $request->meta_title,
        'meta_tag'=>$request->meta_tag,
        'meta_title'=>$request->meta_title,
        'meta_description'=>$request->meta_description,         
      ];
        $page->update($UpdateData);
        
        // dd($page);
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
          $page->clearMediaCollection('img');
          $page->addMediaFromRequest('img')->toMediaCollection('img');
        }
        return redirect()->route('page.index');
    }

    public function destroy(Page $page)
    {
      // abort_if(Gate::denies('page_delete'), 403);
       $page->delete();
       return redirect()->route('page.index');
    }
}
