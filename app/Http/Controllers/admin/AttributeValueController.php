<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\AttributeValue;
use App\Models\admin\Attribute;
use DataTables;
use Illuminate\Support\Facades\Gate;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AttributeValue::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == '1' ? 'Enable' : 'Disable';
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('attribute-values.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('attribute-values.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('attribute-values.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->addColumn('image', function($row) {
                        return '<img src="'.$row->getFirstMediaUrl('image').'" width="50">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
        }

        return view('admin.attributevalues.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributevalue_id = Attribute::all(); 
        return view('admin.attributevalues.create',compact('attributevalue_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'attribute_id' => 'required',
            'name' => 'required|string|max:255',
            // 'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        AttributeValue::create($validated);
        return redirect()->route('attribute-values.index')->with('success', 'Attribute value created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        return view('admin.attributevalues.show', compact('attributeValue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attribute_id = AttributeValue::all();
        $attributeValue = AttributeValue::findOrFail($id);
        return view('admin.attributevalues.edit', compact('attributeValue','attribute_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'attribute_id' => 'required',
            'name' => 'required|string|max:255',
            // 'sort_order' => 'nullable|integer',
            'status' => 'required',
        ]);

        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->update($validated);
        return redirect()->route('attribute-values.index')->with('success', 'Attribute value updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        return redirect()->route('attribute-values.index')->with('success', 'Attribute value deleted successfully.');
    }
}
