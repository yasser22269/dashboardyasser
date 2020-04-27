<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\order;

class OrderControllers extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(5);

        return view('dashboard.orders.index', compact('orders'));

    }//end of index

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    }//end of products


    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stoke' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of order
}
