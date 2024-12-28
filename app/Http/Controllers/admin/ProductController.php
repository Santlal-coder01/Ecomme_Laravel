<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Product;
use App\Models\admin\Attribute;
use App\Models\admin\Category;
use App\Models\admin\AttributeValue;
use App\Models\admin\ProductAttribute;

use DataTables;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == '1' ? 'Enable' : 'Disable';
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('product.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('product.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('product.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->addColumn('banner_image',function($row){
                        $img ='<div style="display: flex; flex-wrap: nowrap;padding: 8px;">';
                        $limit = 0; 
                        foreach($row->getMedia('banner_images') as $image){
                            if ($limit >= 4) break;
                            $img .= '<img src="'.$image->getUrl().'" width="30px" height="30px"  style="border-radius:50%;margin:0px;" alt="banner">';
                            $limit++;               
                        }
                        $img .= '</div>';
                        return $img;
                    })
                    ->addColumn('thumb_img',function($row){
                        $img = '<img src="'.$row->getFirstMediaUrl('thumb_img').'" style="border-radius:50%;width: 50px;height: 50px;" alt="banner">';
                        return $img;
                    })
                    ->rawColumns(['action','banner_image','thumb_img'])
                    ->make(true);
        }

        return view('admin.products.index');
    }


    public function create()
    {
        // $attributesvalue = AttributeValue::all();
        $categories = Category::all();
        $attributes = Attribute::all();
        $related_products = Product::all();
         return view('admin.products.create',compact('related_products','attributes','categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the main product data
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'is_featured' => 'required',
            'sku' => 'required',  
            'qty' => 'required',
            'stock_status' => 'required',
            'weight' => 'required',
            'price' => 'required|numeric|min:0',
            'special_price' => [
                'nullable',
                'numeric',
                'lt:price', 
            ],
            'special_price_from' => 'nullable|date',
            'special_price_to' => 'nullable|date|after_or_equal:special_price_from',
            'short_description' => 'required',
            'description' => 'required',
            // 'url_key' => 'required', 
            'meta_tag' => 'required',  
            'meta_title' => 'required',
            'meta_description' => 'required',
            // 'banner_images' => 'required',
            // 'thumb_img' => 'required',
        ]);
    
        // Create the product first
        $related_product = implode(',', $request->related_product ?? []);
        $product = Product::create([
            'related_product' => $related_product,
            'name' => $request->name,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'sku' => $request->sku,  
            'qty' => $request->qty,
            'stock_status' => $request->stock_status,
            'weight' => $request->weight,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'special_price_from' => $request->special_price_from,          
            'special_price_to' => $request->special_price_to,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'url_key' => $request->name, 
            'meta_tag' => $request->meta_tag,  
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'banner_images' => $request->banner_images,
            'thumb_img' => $request->thumb_img,
        ]);


        if ($request->category_name) {
            $product->categories()->sync($request->category_name);
        }
    
        // $product->categories()->sync($request->category_name);
    
        // Save attributes to ProductAttribute table only after the product is created
        if ($request->attr_value) {

            foreach ($request->attr_value as $id) {

                $attr_value = AttributeValue::where('id', $id)->first();

                $data = [
                    'product_id' => $product->id,
                    'attribute_id' => $attr_value->attribute_id,
                    'attributevalue_id' => $id,
                ];
                // print_r($data);

                ProductAttribute::create($data);
            }
            // dd('');
            }
    
        // Handle banner images
        if ($request->hasFile('banner_images')) {
            foreach ($request->file('banner_images') as $image) {
                if ($image->isValid()) {
                    $product->addMedia($image)->toMediaCollection('banner_images');
                }
            }
        }
    
        // Handle thumbnail image
        if ($request->hasFile('thumb_img') && $request->file('thumb_img')->isValid()) {
            $product->addMediaFromRequest('thumb_img')->toMediaCollection('thumb_img');
        }
    
        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }


    public function edit(string $id)
    {
        $all_products = Product::all();
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product','all_products'));
    }



public function update(Request $request, string $id)
{
    $validator = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'is_featured' => 'required|boolean',
        'sku' => 'required|string|max:255',
        'qty' => 'required|integer|min:0',
        'stock_status' => 'required|string',
        'weight' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'special_price' => [
            'nullable',
            'numeric',
            'lt:price', // Ensures special price is less than price
        ],
        'special_price_from' => 'nullable|date',
        'special_price_to' => 'nullable|date|after_or_equal:special_price_from',
        'short_description' => 'required|string|max:500',
        'description' => 'required|string',
        'meta_tag' => 'required|string|max:255',
        'meta_title' => 'required|string|max:255',
        'meta_description' => 'required|string|max:255',
    ]);

    // Find the product and update its basic fields
    $product = Product::findOrFail($id);
    $related_product = implode(',', $request->related_product ?? []);

    $product->update([
        'related_product' => $related_product,
        'name' => $request->name,
        'status' => $request->status,
        'is_featured' => $request->is_featured,
        'sku' => $request->sku,  
        'qty' => $request->qty,
        'stock_status' => $request->stock_status,
        'weight' => $request->weight,
        'price' => $request->price,
        'special_price' => $request->special_price,
        'special_price_from' => $request->special_price_from,          
        'special_price_to' => $request->special_price_to,
        'short_description' => $request->short_description,
        'description' => $request->description,
        'url_key' => $request->name, 
        'meta_tag' => $request->meta_tag,  
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
    ]);

    // Delete selected images if specified
    if ($request->filled('deleted_images')) {
        $deleteImgId = explode(',', $request->deleted_images);
        foreach ($deleteImgId as $imgId) {
            $image = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($imgId);
            if ($image) {
                $image->delete();
            }
        }
    }

    // Add new banner images
    if ($request->hasFile('banner_images')) {
        foreach ($request->file('banner_images') as $file) {
            $product->addMedia($file)->toMediaCollection('banner_images');
        }
    }

    // Update thumbnail image
    if ($request->hasFile('thumb_img') && $request->file('thumb_img')->isValid()) {
        $product->clearMediaCollection('thumb_img');
        $product->addMediaFromRequest('thumb_img')->toMediaCollection('thumb_img');
    }

    return redirect()->route('product.index')->with('success', 'Product updated successfully');
}




    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }



}
