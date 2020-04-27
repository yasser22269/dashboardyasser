<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $clients = Client::when($request->search,function($q) use ($request){


            return $q->where('name','like','%'. $request->search .'%')
            ->orwhere('phone','like','%'. $request->search .'%')
            ->orwhere('address','like','%'. $request->search .'%');

        })->latest()->paginate(5);
        return view('dashboard.clients.index',compact('clients'));

    }


    public function create()
    {
        return view('dashboard.clients.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'phone'=> 'required|array|min:1',
            'phone.0'=> 'required',
            'address'=> 'required',
        ]);
        client::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }





    public function edit(Client $Client)
    {
        return view('dashboard.clients.edit', compact('Client'));
    }


    public function update(Request $request,Client $Client)
    {
        $request->validate([
            'name'=> 'required',
            'phone'=> 'required|array|min:1',
            'phone.0'=> 'required',
            'address'=> 'required',
        ]);
        $Client->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function destroy(Client $Client)
    {
        $Client->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}
