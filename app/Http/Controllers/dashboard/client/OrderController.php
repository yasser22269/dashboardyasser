<?php

namespace App\Http\Controllers\dashboard\client;

use App\Category;
use App\Client;
use App\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class OrderController extends Controller
{


    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.create', compact( 'client', 'categories', 'orders'));
    }


    public function store(Request $request, Client $client)
    {




        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request, $client);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
        // $request->validate([
        //     'products'=> 'required|array',
        //     // 'quantity'=> 'required|array',
        // ]);
        // $order = $client->orders()->create([]);
        //     $total_price = 0;


        //     $order->products()->attach($request->products);

        //     // session()->flash('success', __('site.added_successfully'));
        //     // return redirect()->route('dashboard.orders.index');

        // foreach ($request->products as $id => $product) {
        //     $product = Product::findOrfail($id);
        //     $total_price +=  $product->sale_price;
        //     // $order->products()->attach($product,['quantity'=>$request->product[ $id]]);

        //     $product->update([
        //         'stoke'=> $product->stock - $product['quantity'],
        //     ]);
        // }
        // $order->update([
        //     'total_price' => $total_price
        // ]);

    }


    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories', 'orders'));

    }//end of edit


    public function update(Request $request, Client $client, Order $order)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->detach_order($order);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of update



    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stoke' => $product->stoke - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'totle_price' => $total_price
        ]);

    }//end of attach order


    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stoke' => $product->stoke + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();
    }
}
