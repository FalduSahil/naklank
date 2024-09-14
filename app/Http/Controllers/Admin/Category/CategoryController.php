<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Catgory\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isEdit = false;
        return view('admin.category.modal', compact(['isEdit']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = [
            'slug' => Str::slug($request->slug, '-') ?? '',
            'name' => $request->name ?? '',
            'description' => $request->description ?? '',
            'image' => null,
            'status' => $request->status ?? ''
        ];
        $image = $request->file('image');
        if($image){
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = getConstant('CATEGORY_IMAGE_PATH');
            $image->move($path, $filename);
            $data['image'] = $filename;
        }
        $create = Category::create($data);
        if($create){
            return redirect()->route('categories.index')->with(['success' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $isEdit = true;
        return view('admin.category.modal', compact(['category', 'isEdit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = [
            'slug' => Str::slug($request->slug, '-') ?? '',
            'name' => $request->name ?? '',
            'description' => $request->description ?? '',
            'image' => $category->image,
            'status' => $request->status ?? ''
        ];
        $image = $request->file('image');
        if($image){
            $path = getConstant('CATEGORY_IMAGE_PATH');
            $full_path = $path.$category->image;
            if(file_exists($full_path) && $category->image != ''){
                unlink($full_path);
            }
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $filename;
        }
        $update = Category::whereId($category->id)->update($data);
        if($update){
            return redirect()->route('categories.index')->with(['success' => true, 'edit' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        if ($request->ajax()) {
            $data = Category::findOrFail($category->id);
            if ($data) {
                $image = $data->image;
                if($image){
                    $path = getConstant('CATEGORY_IMAGE_PATH');
                    $full_path = $path.$data->image;
                    unlink($full_path);
                }
                $data->delete();
                return response()->json(['status' => true, 'message' => getConstant('CATEGORY_DELETE')]);
            } else {
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
        }
        abort(403, 'Unauthorized Action');
    }
}
