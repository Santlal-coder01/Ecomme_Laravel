<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Category;
use App\Models\admin\Product;
use DataTables;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('category_index'), 403);
        if ($request->ajax()) {
            $data = Category::select('*');
      
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == '1' ? 'Enable' : 'Disable';
                    })
                    ->addColumn('show_in_menu', function ($row) {
                        return $row->show_in_menu == '0' ? 'No' : 'Yes';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route('category.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('category.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('category.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-0 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->addColumn('image', function($row){
                        return '<img src="'.$row->getFirstMediaUrl('image').'" width="50">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
        }

        return view('admin.categories.index');
    }


    public function create()
    {
        abort_if(Gate::denies('category_create'), 403);
        $products = Product::all();
        $categories = Category::where('parent_category',0)->get();
        return view('admin.categories.create',compact('categories','products'));
    }

    
    public function store(Request $request)
    {
        abort_if(Gate::denies('category_store'), 403);                                                                                                              
        // Validate input data
        $request->validate([
            // 'parent_category' => 'required', 
            // 'related_products' => 'required',
            // 'products.*' => 'integer|exists:products,id', 
            'name' => 'required|string|max:255',
            'status' => 'required|in:1,2',
            'show_in_menu' => 'required',
            // 'url_key' => 'required|string|max:255|unique:categories,url_key',
            'meta_tag' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
        ]);
    
        // Create the category record
        $category = Category::create([
            'parent_category' => $request->parent_category ?? 0,
            'name' => $request->name,
            'status' => $request->status,
            'show_in_menu' => $request->show_in_menu,
            'url_key' => $request->meta_title,
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);
    
        // Attach selected products to the category
        if ($request->has('products')) {
            // dd('kkk');
           $category->products()->sync($request->related_products);
            
        }
    
        // Redirect to the category list with a success message
        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }
    

    public function show(string $id)
    {
        // abort_if(Gate::denies('user_index'), 403);
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

 
    public function edit(string $id)
    {
        abort_if(Gate::denies('category_edit'), 403);
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $products =Product::all();
        return view('admin.categories.edit', compact('category','categories','products'));
    }

 
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('category_update'), 403);
        $validated = $request->validate([
            'parent_category' => 'required',
            'name' => 'required',
            'status' => 'required',
            'show_in_menu' => 'required',
            'url_key' => 'required',
            'meta_tag' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);
        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }


    public function destroy(string $id)
    {
        abort_if(Gate::denies('category_delete'), 403);
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }



    public function showCategories()
    {
        // Fetch categories with their product count and first product
        $categories = Category::with(['products' => function ($query) {
            $query->limit(1); // Fetch only the first product for each category
        }])
        ->withCount('products') // Count the number of products in each category
        ->get();
    
        return view('categories', compact('categories'));
    }

public function showCategoryProducts($categoryId)
{
    // Fetch the category
    $category = Category::findOrFail($categoryId)->first();
    // Fetch the products in the category
    $products = $category->productss;
    return view('category',['category' => $category, 'products' => $products]);
}

}
