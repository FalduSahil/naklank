<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Models\OrderMeta;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_products = Product::whereStatus('active')->select(['name', 'id'])->get();
        $customers = User::where('user_type', '!=' ,'admin')->get();
        return view('admin.order.add', compact(['all_products', 'customers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'email' => 'required|email',
            'number' => 'required|numeric',
            'address' => 'required',
            'order_data' => 'required',
        ];
        $messages = [
            'user_id.required' => 'Please select customer',
            'email.required' => 'Please enter a email address',
            'email.email' => 'Please enter a valid email address',
            'number.required' => 'Please enter phone number',
            'number.numeric' => 'Please enter a valid phone number',
            'address.required' => 'Please enter address',
            'order_data.required' => 'Please add some products',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user_id = $request->user_id;
        $number = $request->number;
        $email = $request->email;
        $address = $request->address;
        $order_data = $request->order_data;

        $user = User::select(['name'])->find($user_id);

        $order = [
            'order_uuid' => Str::uuid(),
            'user_id' => $user_id,
            'name' => $user->name,
            'email' => $email,
            'phone' => $number,
            'address' => $address,
            'total' => 0,
        ];
        $order_id = Order::insertGetId($order);

        foreach ($order_data as $order_meta){
            $product_id = $order_meta['product_id'];
            $quantity = $order_meta['quantity'];
            $product = Product::find($product_id);

            $current_quantity = $product->quantity;
            $sub_total = $quantity * $product->price;

            if ($current_quantity >= $quantity) {
                OrderMeta::create([
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'sub_total' => $sub_total,
                ]);
                $updateQuantity = $current_quantity - $quantity;
                $product->update(['quantity' => $updateQuantity]);
                $total = OrderMeta::whereOrderId($order_id)->sum('sub_total');
                Order::whereId($order_id)->update(['total' => $total]);
            } else{
                $message = 'Quantity Exceeds For '. $product->name .'. Available Quantity Is '.$current_quantity;
                return response()->json(['status' => false, 'message' => $message]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Order Added Successfully', 'url' => route('orders.index')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {

        return view('admin.order.show', compact(['order']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $all_products = Product::whereStatus('active')->select(['name', 'id'])->get();
        return view('admin.order.edit', compact(['order', 'all_products']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Order $order)
    {
        if ($request->ajax()) {
            $data = Order::findOrFail($order->id);

            if ($data) {
                $order_meta = OrderMeta::whereOrderId($order->id)->get();

                foreach ($order_meta as $item) {
                    $product = Product::whereId($item->product_id)->first();
                    if ($product) {
                        $product->increment('quantity', $item->quantity);
                    }
                }

                OrderMeta::whereOrderId($order->id)->delete();
                $data->delete();
                return response()->json(['status' => true, 'message' => getConstant('ORDER_DELETE')]);
            } else {
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
        }

        abort(403, 'Unauthorized Action');
    }


    public function addProducts(Request $request)
    {
        if($request->ajax()) {
            $product_id = $request->product_id ?? '';
            if(empty($product_id)){
                return response()->json(['status' => false]);
            }
            $for = 'addProduct';
            $products = Product::whereIn('id', $product_id)->select(['id', 'name', 'main_image', 'price', 'quantity'])->get();
            $html = view('common.includes.ajax', compact(['for', 'products']))->render();
            return response()->json(['status' => true, 'html' => $html]);
        }
        abort('403', 'Unauthorized');
    }

    public function updateOrderStatus(Request $request)
    {
        if($request->ajax()){
            $id = $request->id ?? '';
            $status = $request->status ?? '';
            $update = Order::whereId($id)->update(['status' => $status]);
            if ($update) {
                $order = Order::find($id);
                Mail::to($order->user->email)->send(new OrderStatusMail($order));
                switch ($status) {
                    case $status == 'accepted':
                        foreach ($order->orderMeta as $item) {
                            $product = $item->product;
                            $quantity = $item->quantity;
                            $quantityInDatabase = $product->quantity;
                            $updateQuantity = $quantityInDatabase - $quantity;
                            Product::whereId($product->id)->update(['quantity' => $updateQuantity]);
                        }
                        return response()->json(['status' => true, 'message' => getConstant('ORDER_ACCEPTED')]);
                    case $status == 'rejected':
                        foreach ($order->orderMeta as $item) {
                            $product = $item->product;
                            $quantity = $item->quantity;
                            $quantityInDatabase = $product->quantity;
                            $updateQuantity = $quantityInDatabase + $quantity;
                            Product::whereId($product->id)->update(['quantity' => $updateQuantity]);
                        }
                        /*OrderMeta::whereOrderId($id)->delete();
                        Order::whereId($id)->delete();*/
                        return response()->json(['status' => true, 'message' => getConstant('ORDER_REJECTED')]);
                    case $status == 'pending':
                        return response()->json(['status' => true, 'message' => getConstant('ORDER_PENDING')]);
                    default:
                        return response()->json(['status' => true, 'message' => getConstant('STATUS_UPDATE')]);
                }
            } else {
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
        }
        abort('403', 'Unauthorized');
    }

    public function checkQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $quantityToAdd = (int)$request->input('quantity');
        $orderId = $request->input('order_id');

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        if($orderId){
            $existingQuantityInOrder = OrderMeta::where('order_id', $orderId)
                ->where('product_id', $productId)
                ->value('quantity');

            $current_quantity = $existingQuantityInOrder + $product->quantity;

            if ($quantityToAdd > $current_quantity) {
                $message = 'Total quantity exceeds. Available quantity is '.$current_quantity;
                return response()->json(['status' => false, 'message' => $message, 'quantity' => $current_quantity]);
            }

            return response()->json(['status' => true]);
        }

        $current_quantity = $product->quantity;

        if ($quantityToAdd > $current_quantity) {
            $message = 'Total quantity exceeds. Available quantity is '.$current_quantity;
            return response()->json(['status' => false, 'message' => $message, 'quantity' => $current_quantity]);
        }

        return response()->json(['status' => true]);
    }

    public function updateOrder(Request $request)
    {
        $order_id = $request->order_id;
        $new_order_meta = $request->order_data;

        if ($order_id && $new_order_meta != null) {
            $order = Order::with('orderMeta')->find($order_id);

            if ($order) {
                $productsToIncrement = [];

                foreach ($new_order_meta as $order_meta_new) {
                    $new_product_id = $order_meta_new['product_id'];
                    $new_quantity = $order_meta_new['quantity'];

                    $existingOrderMeta = $order->orderMeta->where('product_id', $new_product_id)->first();
                    $product = Product::whereId($new_product_id)->first();

                    if ($existingOrderMeta) {
                        $current_quantity = Product::whereId($new_product_id)->value('quantity');
                        $diff_quantity = $new_quantity - $existingOrderMeta->quantity;

                        if ($current_quantity >= $diff_quantity) {
                            $existingOrderMeta->quantity = $new_quantity;
                            $existingOrderMeta->save();
                            Product::whereId($new_product_id)->decrement('quantity', $diff_quantity);
                        } else {
                            return response()->json(['status' => false, 'message' => 'Insufficient quantity for product ' . $product->name]);
                        }
                    } else {
                        $order->orderMeta()->create([
                            'product_id' => $new_product_id,
                            'quantity' => $new_quantity,
                            'order_id' => $order_id,
                        ]);
                        Product::whereId($new_product_id)->decrement('quantity', $new_quantity);
                    }

                    $productsToIncrement[] = $new_product_id;

                    $orderMetaTotal = $product->price * $new_quantity;
                    $order->orderMeta()->where('product_id', $new_product_id)->first()->update(['sub_total' => $orderMetaTotal]);
                }

                $order->orderMeta()->whereNotIn('product_id', $productsToIncrement)->each(function ($removedOrderMeta) use (&$orderTotal) {
                    $removedProduct = Product::find($removedOrderMeta->product_id);
                    $removedProduct->increment('quantity', $removedOrderMeta->quantity);
                    $removedOrderMeta->delete();
                });

                $total = OrderMeta::whereOrderId($order_id)->sum('sub_total');
                $order->update(['total' => $total]);

                return response()->json(['status' => true, 'message' => 'Order Updated Successfully', 'url' => route('orders.index')]);
            }
        }

        return response()->json(['status' => false, 'message' => 'Please provide valid order ID and order data']);
    }

    public function fillCustomerDetails(Request $request)
    {
        if($request->ajax()){
            $user_id = $request->user_id;
            if($user_id){
                $user = User::select(['name', 'email', 'number', 'address'])->find($user_id);
                return response()->json(['status' => true, 'user' => $user]);
            }
            return response()->json(['status' => false, 'message' => 'Please select customer']);
        }
        abort('403', 'Unauthorized');
    }

}
