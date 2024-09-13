<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Label;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CommonController extends Controller
{
    public function changeStatus(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request->slug ?? '';
            $id = $request->id ?? '';
            $status = $request->status ?? '';
            if ($id != '') {
                switch ($slug){
                    case $slug == 'products':
                        $product = Product::find($id);
                        if($product->per_box_quantity <= 0 || $product->per_box_quantity == ''){
                            $product->update(['status' => 'inactive']);
                            return response()->json(['status' => false, 'message' => 'Please Fill All Product Details!']);
                        }
                        if($status == 'inactive'){
                            CartItem::whereProductId($product->id)->delete();
                        }
                        $update = Product::whereId($id)->update(['status' => $status]);
                        break;
                    case $slug == 'categories':
                        $update = Category::whereId($id)->update(['status' => $status]);
                        break;
                    case $slug == 'labels':
                        $update = Label::whereId($id)->update(['status' => $status]);
                        break;
                    case $slug == 'users':
                        $update = User::whereId($id)->update(['status' => $status]);
                        break;
                    case $slug == 'orders':
                        $update = Order::whereId($id)->update(['status' => $status]);
                        break;
                    default:
                        return '';
                }
                if ($update) {
                    if($slug == 'orders'){
                        return match ($status) {
                            $status == 'accepted' => response()->json(['status' => true, 'message' => getConstant('ORDER_ACCEPTED')]),
                            $status == 'rejected' => response()->json(['status' => true, 'message' => getConstant('ORDER_REJECTED')]),
                            $status == 'pending' => response()->json(['status' => true, 'message' => getConstant('ORDER_PENDING')]),
                            default => response()->json(['status' => true, 'message' => getConstant('STATUS_UPDATE')]),
                        };
                    }
                    return response()->json(['status' => true, 'message' => getConstant('STATUS_UPDATE')]);
                } else {
                    return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
                }
            }
        }
        abort(403, 'Unauthorized Action');
    }

    public function getDataTable(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request->slug ?? '';
            $data = '';
            switch ($slug){
                case $slug == 'products':
                    $data = Product::getDataTable();
                    break;
                case $slug == 'categories':
                    $data = Category::getDataTable();
                    break;
                case $slug == 'labels':
                    $data = Label::getDataTable();
                    break;
                case $slug == 'users':
                    $data = User::getDataTable();
                    break;
                case $slug == 'orders':
                    $data = Order::getDataTable();
                    break;
                case $slug == 'inquiries':
                    $data = Inquiry::getDataTable();
                    break;
                default:
                    return $data;
            }
            return $data;
        }
        abort(403, 'Unauthorized Action');
    }

    public function profile()
    {
        return view('admin.profile.profile');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore(getAuthUser('admin')->id),
            ],
            'current_password' => 'nullable|min:8|current_password:admin',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Please enter name',
            'current_password.current_password' => 'Your current password does not match with our records',
            'current_password.min' => 'Please enter at least 8 characters',
            'password.min' => 'Please enter at least 8 characters',
            'password.confirmed' => 'Please enter confirm password same as new password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->safe()->collect();
        $update = [];
        $name = $data['name'];
        $email = $data['email'];
        $current_password = $data['current_password'];
        $new_password = $data['password'];
        $confirm_password = $request?->password_confirmation;

        if($current_password && $new_password && $confirm_password != null){
            $update['password'] = Hash::make($new_password);
        }
        $update['name'] = $name;
        $update['email'] = $email;

        $user = User::whereId(getAuthUser('admin')->id)->update($update);
        if($user){
            return redirect()->back()->with(['success' => true]);
        }
        return redirect()->back()->with(['fail' => true]);
    }

    public function getLabels(Request $request)
    {
        if ($request->ajax()) {
            $category_id = $request->category_id ?? '';
            $for = 'labels';
            $html = view('web.includes.ajax', compact(['category_id', 'for']))->render();
            return response()->json(['status' => true, 'html' => $html]);
        }
        abort(403, 'Unauthorized Action');
    }

    public function logoutFromAll(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id ?? '';
            if($id){
                $logout_all = User::whereId($id)->update(['logout_all' => 'yes', 'logout_all_app' => 'yes']);
                if($logout_all){
                    return response()->json(['status' => true, 'message' => 'Logout From All Devices Successfully']);
                }
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
            return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
        }
        abort(403, 'Unauthorized Action');
    }

    public function validateSlug(Request $request)
    {
        if($request->ajax()){
            $slug = Str::slug($request->slug, '-') ?? '';
            $product_id = $request->product_id ?? '';
            $category_id = $request->category_id ?? '';
            if(isset($product_id) && $product_id != ''){
                $product_slug = Product::whereSlug($slug)->where('id', '!=', $product_id)->select('slug')->first();
                $category_slug = Category::whereSlug($slug)->select('slug')->first();
            } elseif(isset($category_id) && $category_id != '') {
                $category_slug = Category::whereSlug($slug)->where('id', '!=', $category_id)->select('slug')->first();
                $product_slug = Product::whereSlug($slug)->select('slug')->first();
            } else {
                $product_slug = Product::whereSlug($slug)->select('slug')->first();
                $category_slug = Category::whereSlug($slug)->select('slug')->first();
            }
            if($category_slug){
                return response()->json('This slug is already used in categories');
            }
            if($product_slug){
                return response()->json('This slug is already used in products');
            }
            return response()->json(true);
        } else {
            abort('403', 'Access Denied');
        }
    }
}
