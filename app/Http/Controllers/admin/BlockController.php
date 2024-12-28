<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Block;
use DataTables;
use Illuminate\Support\Facades\Gate;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Block::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == '1' ? 'Enable' : 'Disable';
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a href="'.route('block.show', $row->id).'" class="view btn btn-primary btn-sm">View</a>';
                        $btn .= '<a href="'.route('block.edit', $row->id).'" class="edit btn btn-success">Edit</a>';
                        $btn .= '<form action="'.route('block.destroy', $row->id).'" method="POST" style="display:inline">
                                  '.csrf_field().' '.method_field('DELETE').'
                                  <button type="submit" class="btn btn-danger ml-1 p-2">Delete</button>
                                </form>';
                        return $btn;
                    })
                    ->addColumn('b_image', function($row) {
                        return '<img src="'.$row->getFirstMediaUrl('b_image').'" width="20%" height="20%">';
                    })
                    ->rawColumns(['action', 'b_image'])
                    ->make(true);
        }

        return view('admin.blocks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|unique:blocks,identifier',
            'name' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $block = Block::create($validated);
        if ($request->hasFile('b_image') && $request->file('b_image')->isValid()) {
            $block->addMediaFromRequest('b_image')->toMediaCollection('b_image');
        }
        return redirect()->route('block.index')->with('success', 'Block created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $block = Block::findOrFail($id);
        return view('admin.blocks.show', compact('block'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $block = Block::findOrFail($id);
        return view('admin.blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'identifier' => 'required|unique:blocks,identifier,'.$id,
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|boolean'
        ]);

        $block = Block::findOrFail($id);
        $block->update($validated);
        if ($request->hasFile('b_image') && $request->file('b_image')->isValid()) {
            $block->clearMediaCollection('b_image');
            $block->addMediaFromRequest('b_image')->toMediaCollection('b_image');
        }
        return redirect()->route('block.index')->with('success', 'Block updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block = Block::findOrFail($id);
        $block->delete();
        return redirect()->route('block.index')->with('success', 'Block deleted successfully');
    }
}
