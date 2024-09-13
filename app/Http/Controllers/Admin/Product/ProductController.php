<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_category = Category::all(['id', 'name']);
        return view('admin.product.add', compact(['all_category']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = [
            'slug' => Str::slug($request->slug, '-'),
            'category_id' => $request->category_id,
            'label_id' => $request->label_id,
            'quantity' => $request->quantity,
            'per_box_quantity' => $request->per_box_quantity,
            'price' => $request->price,
            'name' => $request->name,
            'product_for' => $request->product_for,
            'description' => $request->description,
            'product_code' => $request->product_code,
            'status' => $request->status,
        ];
        $main_image = $request->file('main_image');
        if($main_image){
            $filename = time() . '_' . $main_image->getClientOriginalName();
            $path = getConstant('PRODUCT_IMAGE_PATH');
            $main_image->move($path, $filename);
            $data['main_image'] = $filename;
        }
        $product = Product::create($data);
        $images = explode('::', $request->images);
        if($images){
            foreach ($images as $image) {
                $localFile = getConstant('TEMP_PATH') . $image;
                $path = getConstant('PRODUCT_IMAGE_PATH') . $image;
                File::move($localFile, $path);
                ProductImage::create(['product_id' => $product->id, 'image' => $image]);
            }
        }
        if($product){
            return redirect()->route('products.index')->with(['success' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact(['product']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
       return view('admin.product.edit', compact(['product']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = [
            'slug' => Str::slug($request->slug, '-'),
            'category_id' => $request->category_id,
            'label_id' => $request->label_id,
            'quantity' => $request->quantity,
            'per_box_quantity' => $request->per_box_quantity,
            'price' => $request->price,
            'name' => $request->name,
            'product_for' => $request->product_for,
            'description' => $request->description,
            'product_code' => $request->product_code,
            'status' => $request->status,
        ];
        if($request->images){
            $images = explode('::', $request->images);
            foreach ($images as $image) {
                $localFile = getConstant('TEMP_PATH') . $image;
                $path = getConstant('PRODUCT_IMAGE_PATH') . $image;
                File::move($localFile, $path);
                ProductImage::create(['product_id' => $product->id, 'image' => $image]);
            }
        }
        $image = $request->file('main_image');
        if($image){
            $path = getConstant('PRODUCT_IMAGE_PATH');
            if($product->main_image != null){
                $full_path = $path.$product->main_image ?? '';
                if(file_exists($full_path)){
                    unlink($full_path);
                }
            }
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($path, $filename);
            $data['main_image'] = $filename;
        }
        $update = Product::whereId($product->id)->update($data);
        if($update){
            return redirect()->route('products.index')->with(['success' => true, 'edit' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        if ($request->ajax()) {
            $data = Product::findOrFail($product->id);
            if ($data) {
                if($product->main_image){
                    $path = getConstant('PRODUCT_IMAGE_PATH');
                    unlink($path.$product->main_image);
                }
                $product_images = ProductImage::where('product_id', $data->id)->get();
                if($product_images){
                    foreach ($product_images as $images){
                        $path = getConstant('PRODUCT_IMAGE_PATH');
                        unlink($path.$images->image);
                    }
                }
                ProductImage::where('product_id', $data->id)->delete();
                CartItem::whereProductId($data->id)->delete();
                $data->delete();
                return response()->json(['status' => true, 'message' => getConstant('PRODUCT_DELETE')]);
            } else {
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
        }
        abort(403, 'Unauthorized Action');
    }

    public function uploadImages(Request $request)
    {
        if (!empty($request->file('productImages'))){
            $res = array();
            $product_images = $request->file('productImages') ?? '';
            $path = getConstant('TEMP_PATH');
            foreach ($product_images as $product_image){
                $filename = time() . uniqid() .'_' . $product_image->getClientOriginalName();
                $product_image->move($path, $filename);
                $res[] = $filename;
            }
            return response()->json($res);
        }
    }

    public function removeTempFiles(Request $request)
    {
        $path = getConstant('TEMP_PATH');
        if (!empty($request->file)) {
            if (file_exists($path . $request->file)){
                file::delete($path . $request->file);
                return response()->json(['status' => 'success']);
            }
        }
    }

    public function removeImage(Request $request)
    {
        $product_id = $request->productId ?? '';
        $path = getConstant('PRODUCT_IMAGE_PATH');
        if($product_id){
            $product_image = ProductImage::findOrFail($product_id);
            if($product_image){
                if (file_exists($path . $product_image->image)){
                    file::delete($path . $product_image->image);
                    $product_image->delete();
                    return response()->json(['status' => true, 'message' => 'Image deleted successfully']);
                }
            }
        }
    }
}
