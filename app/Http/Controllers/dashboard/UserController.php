<?php

namespace App\Http\Controllers\dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:delete_users'])->only('destroy');

    }
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function($query) use ($request){

           return $query->when($request->search,function($q) use ($request){


                return $q->where('first_name','like','%'. $request->search .'%')
                ->orwhere('last_name','like','%'. $request->search . '%');

            });

        })->latest()->paginate(5);






     
        return view("dashboard.users.index" , compact("users"));
    }


    public function create()
    {
        return view('dashboard.users.create');

    }


    public function store(Request $request)
    {

        $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|unique:users',
            'password'=> 'required|confirmed',
            'image'=> 'image',
            'permissions'=>'required|min:1',
        ]);

        $data_request = $request->except(['password','password_confirmation','permissions','image']);
        $data_request['password'] = bcrypt($request->password);

            if($request->image){
                Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/user_images/' . $request->image->hashName()));
                $data_request['image'] = $request->image->hashName();

            }

        $user = User::create($data_request);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    // public function show(User $user)
    // {
    //     //
    // }


    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {

        $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> ['required', Rule::unique('users')->ignore($user->id),],
            'image'=> 'image',
            'permissions'=>'required|min:1',

        ]);

        $data_request = $request->except(['permissions','image']);

        if($request->image){

            if($user->image != 'default.png'){
             Storage::disk('public_uploads')->delete('user_images/'.$user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
             $constraint->aspectRatio();
         })->save(public_path('uploads/user_images/' . $request->image->hashName()));
         $data_request['image'] = $request->image->hashName();

         }//end if

        $user->update($data_request);
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        if($user->image  != 'default.png'){
            Storage::disk('public_uploads')->delete('user_images/'.$user->image);

        }


        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
