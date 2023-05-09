<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends ApiController
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_items' => 'required',
            'order_items.*.product_id' => 'required',
            'order_items.*.quantity' => 'required'


        ]);
        if ($validator->failed()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $total_amount = 0;
        $delivery_amount = 0;
        foreach ($request->order_items as $order_item) {
            $product = Product::findOrFails($order_item['product_id']);
            if ($product->quantity < $order_item['quantity']) {
                return $this->errorResponse('The product quantity is incorrect', 422);
            }
            $total_amount += $product->price * $order_item['quantity'];
            $delivery_amount += $product->delivery_amount;
        }
        $paying_amount = $total_amount + $delivery_amount;

        DB::beginTransaction();
        $order = Order::create([
            'user_id' => $request['user_id'],
            'total_amount' => $total_amount,
            'delivery_amount' => $delivery_amount,
            'paying_amount' => $paying_amount
        ]);

        foreach ($request->order_items as $order_item) {
            $product = Product::findOrFail($order_item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'price' => $product->price,
                'quantity' => $order_item['quantity'],
                'subtotal' => ($product->price * $order_item['quantity']),

            ]);
        }
        Db::commit();
        return $this->successResponse("order save", 200);
    }

    public function transaction(Request $request)
    {
        DB::beginTransaction();
        $order = Order::findOrFail($request->id);
        $order->update([
            'status' => 1,
            'payment_status' => 1
        ]);
        $order_items = OrderItem::where('order_id', $order->id)->get();
        foreach ($order_items as $item) {
            $product = Product::find($item->product_id);
            $product->update([
                'quantity' => $product->quantity - $item->quantity,
            ]);
        }
        DB::commit();
        return $this->successResponse("Transaction done", 200);
    }
}
