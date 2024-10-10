<?php

namespace App\Http\Controllers\Home\Checkout;

use App\Http\Controllers\Controller;
use App\Mail\OrderAdminMail;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderMeta;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{

    public function placeOrder(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'number' => 'required|min:10',
            'email' => 'required|email',
            'address' => 'sometimes|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];

        $messages = [
            'name.required' => 'Please enter your name',
            'number.required' => 'Please enter your phone number',
            'number.min' => 'Please enter at least 10 digits for the phone number',
            'email.required' => 'Please enter an email address',
            'email.email' => 'Please enter a valid email address',
            'address.required' => 'Please provide your address',
            'quantity.required' => 'Please enter quantity',
            'quantity.min' => 'Please enter a value greater than 0',
            'product_id.exists' => 'The selected product is not available',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->status != 'active') {
            return response()->json(['message' => $product->name . ' is not available right now, please try later', 'status' => false]);
        }

        if ($request->quantity > $product->quantity) {
            return response()->json(['message' => 'Only ' . $product->quantity . ' units of ' . $product->name . ' are available.', 'status' => false]);
        }

        DB::beginTransaction();
        try {
            $total = $product->price * (int)$request->quantity;

            $order = Order::create([
                'order_uuid' => Str::uuid(),
                'user_id' => null,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->number,
                'address' => $request->address,
                'total' => $total,
            ]);

            OrderMeta::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'sub_total' => $total,
            ]);

            if($product->quantity > 0){
                $product->decrement('quantity', (int)$request->quantity);
            }

            if ($request->email) {
                Mail::to($request->email)->send(new OrderMail($order));
            }

            $adminEmail = getConstant('EMAIL');

            Mail::to($adminEmail)->send(new OrderAdminMail($order));

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'status' => true]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while placing the order. Please try again later.' . $e, 'status' => false], 500);
        }
    }
}
