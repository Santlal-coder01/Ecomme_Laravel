<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Slider;
use DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route('slider.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('slider.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('slider.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->addColumn('image', function($row){
                        return '<img src="'.$row->getFirstMediaUrl('img').'" width="50px">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
        }

        return view('admin.sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'url' => 'required',
            'order' => 'required|integer',
            'description' => 'required'
        ]);

        $slider = Slider::create($validated);
        if($request->file('img')){
         $slider->addMediaFromRequest('img')->toMediaCollection('img');
        }
        return redirect()->route('slider.index')->with('success', 'Slider created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'url' => 'required',
            'order' => 'required|integer',
            'description' => 'required'
        ]);

        $slider = Slider::findOrFail($id);
        if($request->file('img')){
            $slider->clearMediaCollection('img');
            $slider->addMediaFromRequest('img')->toMediaCollection('img');
           }
        $slider->update($validated);
        return redirect()->route('slider.index')->with('success', 'Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully');
    }
}
