<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
//        $categories = Category::whereStatus('active')->select(['id', 'name', 'slug', 'image'])->limit(12)->get();
        $products = Product::with(['getCategory' => function ($query) {
            $query->select(['id', 'name']);
        }])
            ->where('status', 'active')
            ->select(['id', 'category_id', 'slug', 'name', 'price', 'quantity', 'main_image'])
            ->get();
        return view('home.index', compact(['products']));
    }
}
