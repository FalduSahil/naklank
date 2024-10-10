<?php

namespace App\Http\Controllers\Home\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Product::whereStatus('active')->where('quantity', '>', '0')->where('main_image', '!=', null)->latest()->paginate(getConstant('PRODUCT_COUNT'));
        return view('home.shop.shop', compact(['products']));
    }

    public function categories($slug = '')
    {
        $category = Category::whereStatus('active')->where('slug', $slug)->select(['id', 'name'])->first();
        if($category){
            $products = Product::whereStatus('active')->where('quantity', '>', '0')->where('category_id', $category->id)->paginate(getConstant('CATEGORY_COUNT'));
            return view('home.category.category', compact(['products', 'category']));
        }
        return redirect()->route('products');
    }

    public function getProduct($slug)
    {
        $product = Product::with(['getCategory', 'getProductImages'])->whereStatus('active')->where('quantity', '>', '0')->where('main_image', '!=', null)->where('slug', $slug)->first();
        $product_others = Product::whereStatus('active')->where('quantity', '>', '0')->where('main_image', '!=', null)->where('slug', '!=', $slug)->get();
        if($product){
            return view('home.product.product', compact(['product', 'product_others']));
        }
        abort('404');
    }

    public function sortProducts(Request $request)
    {
        if($request->ajax()) {
            $sort = $request->sort ?? 'a-to-z';
            $search = $request->search ?? '';
            $sort_page = $request->sort_page ?? '';
            $products = Product::whereStatus('active')->where('main_image', '!=', null);
            $page = $request->input('page', 1);

            $products->where('quantity', '>', '0');

            if (!empty($search)) {
                $products->where('name', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhereHas('getCategory', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%");
                    });
            }

            if ($sort === 'a-to-z') {
                $products->orderBy('name', 'ASC');
            } elseif ($sort === 'z-to-a') {
                $products->orderBy('name', 'DESC');
            } elseif ($sort === 'latest') {
                $products->orderBy('id', 'DESC');            }
            elseif ($sort === 'price-highest') {
                $products->orderBy('price', 'ASC');
            } elseif ($sort === 'price-lowest') {
                $products->orderBy('price', 'DESC');
            } elseif ($sort === 'oldest') {
                $products->orderBy('id', 'ASC');
            }

            $products = $products->get();

            $for = 'sort-products';
            $html = view('home.includes.ajax', compact(['products', 'for']))->render();
            $total_products = count($products);

            return response()->json(['status' => true, 'html' => $html, 'totalProducts' => $total_products]);
        }
        abort('403','Unauthorized');
    }
}
