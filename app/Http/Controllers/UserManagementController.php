<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreManagedUserRequest;
use App\Http\Requests\ResetManagedUserPasswordRequest;
use Auth;
use Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        Gate::authorize('admin_only');
    	$users = User::orderBy('role_id')->paginate();
        
    	return view('users.index',['metaTitle' => 'قائمة المستحدمين'])
    	          ->with('users',$users);
    }

    public function create()
    {
        Gate::authorize('admin_only');
    	$roles = Role::all();
    	
    	return view('users.create',['metaTitle' => 'مستخدم جديد'])
    	          ->with('roles' , $roles);
    }
    

    public function store(StoreManagedUserRequest $request)
    {
        Gate::authorize('admin_only');
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role()->associate($request->role_id);
        $user->save();


        return redirect()->route('management.index');
    }


     public function disableUser($id)
    {
        Gate::authorize('admin_only');
        $user = User::findOrFail($id);


        $status = $user->update([
            'active' => 0
        ]);


        if ($status) {
            return redirect()->route('management.index');
        }
        
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit')->with('user', $user);
    }



    public function enableUser($id)
    {
        Gate::authorize('admin_only');
        $user = User::findOrFail($id);


        $status = $user->update([
            'active' => 1
        ]);

        if ($status) {
            return redirect()->route('management.index');
        }
        
    }


    public function destroy(Request $request,$id)
    {
        if (Auth::id() == $id) {
            
            return redirect()->route('register.index')->withErrors("You can't delete your own account");
        }

        $user = User::findOrFail($id);
        $user->shifts()->detach();
        
        User::destroy($id);
        $request->session()->flash('success',"User Deleted Successfully");
        return redirect()->route('register.index');
    }


    public function resetPasswordForm($id)
    {
        Gate::authorize('admin_only');
        $user = User::findOrFail($id);
        return view('users.resetPassword',['metaTitle' => 'تحديث كلمة المرور'])->with('user',$user);
    }

    public function resetPassword(ResetManagedUserPasswordRequest $request,$id)
    {
        Gate::authorize('admin_only');

        $user = User::findOrFail($id);
        
       
        if ($request->password === $request->confirm_password) {

        $hashed_password = Hash::make($request->password);

        $user->update([
            'password' => $hashed_password
        ]);

        if (Auth::id() == $id) {
            
             Auth::guard()->logout();

             $request->session()->invalidate();

             $request->session()->regenerateToken();

             return  redirect()->route('login');
        }else {
            $request->session()->flash('success','تم تحديث كلمة المرور الجديدة');
            return redirect()->route('management.index');
        }
        
        }
    }
}
