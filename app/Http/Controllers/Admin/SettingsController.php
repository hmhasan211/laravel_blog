<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'mimes:jpg,jpeg,png',
            'email'=>'required|email',
        ]);
        $image = $request->file('image');
        $slug  = str_slug($request->name);
        $user  = User::findOrFail(Auth::id());

        if (isset($image)){
                $currentDate = Carbon::now()->toDateString();
                $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                //profile folder check
                if (!Storage::disk('public')->exists('profile')){
                    Storage::disk('public')->makeDirectory('profile');
                }
                //delete old image
                if (Storage::disk('public')->exists('profile/'.$user->image)){
                    Storage::disk('public')->delete('profile/'.$user->image);
                }
                $profile = Image::make($image)->resize(500,500)->save('my-image.jpg',90);
                Storage::disk('public')->put('profile/'.$imageName,$profile);
        }else{
            $imageName = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile updated Successfully!!','success');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'password' =>'required|confirmed',
        ]);

        $dbPassword = Auth::user()->password;
//        $old_pass = Hash::make($request->old_password);
        if (Hash::check($request->old_password,$dbPassword))
        {
            if (!Hash::check($request->password,$dbPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Successfully Changed Password','success');
                Auth::logout();
                return redirect()->back();
            }else{
                Toastr::error('New Password can not same as old password!!','Error');
                return redirect()->back();
                 }
        }else{
            Toastr::error('Current Password does not matched!!','Error');
            return redirect()->back();
        }
    }
}
