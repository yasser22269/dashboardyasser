<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search,function($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search .'%');

        })->when($request->category_id,function($q) use ($request){
            return $q->where('category_id','like','%'. $request->category_id .'%');

        })->latest()->paginate(5);
        //
        return view('dashboard.products.index',compact('products','categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    }


    public function store(Request $request)
    {
        $role =[
            'category_id' =>'required',
        ];

        foreach (config('translatable.locales') as $locale) {
            $role += [$locale . '.name' => ['required',Rule::unique('product_translations','name')]];
            $role += [$locale . '.description' => ['required']];

        }

        $role +=[
            'purchase_price' =>'required',
            'sale_price' =>'required',
            'stoke' =>'required',
        ];

        $request->validate($role);
        $data_request = $request->all();
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_image/' . $request->image->hashName()));
            $data_request['image'] = $request->image->hashName();

        }

    product::create($data_request);
    session()->flash('success', __('site.added_successfully'));
    return redirect()->route('dashboard.products.index');
    }





    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('dashboard.products.edit', compact('product','categories'));

    }


    public function update(Request $request, Product $product)
    {
        $role =[
            'category_id' =>'required',
        ];

        foreach (config('translatable.locales') as $locale) {
            $role += [$locale . '.name' => ['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $role += [$locale . '.description' => ['required']];

        }

        $role +=[
            'purchase_price' =>'required',
            'sale_price' =>'required',
            'stoke' =>'required',
        ];

        $request->validate($role);
        $data_request = $request->all();
        if($request->image){

            if($product->image != 'default.png'){
                Storage::disk('public_uploads')->delete('product_image/'.$product->image);
               }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_image/' . $request->image->hashName()));
            $data_request['image'] = $request->image->hashName();

        }

        $product->update($data_request);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }


    public function destroy(Product $product)
    {
        if($product->image != 'default.png'){
            Storage::disk('public_uploads')->delete('product_image/'.$product->image);
           }
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
