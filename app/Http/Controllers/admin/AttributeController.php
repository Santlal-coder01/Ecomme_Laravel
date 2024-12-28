<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Attribute;
use App\Models\admin\AttributeValue;
use DataTables;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Attribute::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == '1' ? 'Enable' : 'Disable';
                    })
                    ->addColumn('is_variant', function ($row) {
                        return $row->is_variant == '0' ? 'No' : 'Yes';
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('attribute.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('attribute.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('attribute.destroy', $row->id).'" method="POST" style="display:inline">
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
        return view('admin.attributes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
         $request->validate([
            'name' => 'required|string|max:255',
            'name_key' => 'required',
            'is_variant' => 'required',
            'status' => 'required',
        ]);
        $validated =  Attribute::create([
            'name' => $request->name,
            'name_key' => $request->name_key,
            'is_variant' => $request->is_variant,
            'status' => $request->status,
        ]);
        // dd($request->attributevalues, $request->status);
        if ($request->av) {
            foreach ($request->av as $key => $v) {
                    $status = $request->as[$key];
        
                    $insert = [
                        'attribute_id' => $validated->id,
                        'name' => $v,
                        'status' => $status,
                    ];
        
                
                AttributeValue::create($insert);
            }
        }
        
         
        return redirect()->route('attribute.index')->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attributevalues = AttributeValue::where('attribute_id',$id)->get();
        $attribute = Attribute::findOrFail($id);
        return view('admin.attributes.edit', compact('attribute','attributevalues'));
    }

    /**
     * Update the specified resource in storage.
     */
        
     public function update(Request $request, $attributeId)
     {
         // Validate the request
         $request->validate([
             'name' => 'required|string|max:255',
             'name_key' => 'required|string|max:255',
             'is_variant' => 'required',
             'status' => 'required',
         ]);
     
         // Retrieve the attribute and update its main properties
         $attribute = Attribute::findOrFail($attributeId);
         $attribute->update([
             'name' => $request->input('name'),
             'name_key' => $request->input('name_key'),
             'is_variant' => $request->input('is_variant'),
             'status' => $request->input('status'),
         ]);
     
         // Array to store IDs of received attribute values
         $receivedIds = [];
     
         // Update or create attribute values
         if ($request->has('attributename') && $request->has('attributestatus')) {
             foreach ($request->attributename as $key => $value) {
                 // Get the ID and status for the current attribute value
                 $attributeValueId = $request->attribute_value_id[$key] ?? null;  
                 $status = $request->attributestatus[$key] ?? null;
     
                 if ($attributeValueId) {
                     // Try to find the existing attribute value by ID
                     $attributeValue = AttributeValue::find($attributeValueId);
                     if ($attributeValue) {
                         // Update the existing attribute value
                         $attributeValue->update([
                             'name' => $value,
                             'status' => $status,
                         ]);
                         // Add the updated ID to the received IDs array
                         $receivedIds[] = $attributeValueId;
                     }
                 } else {
                     // Create a new attribute value if no ID is provided
                     $newAttributeValue = AttributeValue::create([
                         'attribute_id' => $attribute->id,
                         'name' => $value,
                         'status' => $status,
                     ]);
                     // Add the new ID to the received IDs array
                     $receivedIds[] = $newAttributeValue->id;
                 }
             }
         }
     
         // Delete any attribute values that were not included in the request
         AttributeValue::where('attribute_id', $attribute->id)
             ->whereNotIn('id', $receivedIds)
             ->delete();
     
         // Redirect to the attribute index with a success message
         return redirect()->route('attribute.index')->with('success', 'Attribute updated successfully!');
     }
     

    public function destroy(string $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return redirect()->route('attribute.index')->with('success', 'Attribute deleted successfully.');
    }
}
