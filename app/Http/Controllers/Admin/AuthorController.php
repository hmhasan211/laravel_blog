<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
         $authors = User::Authors()
            ->withCount('posts')
            ->withCount('favourite_posts')
            ->withCount('comment')
            ->get();
         return view('admin.authors',compact('authors'));
    }
    public function destroy($id)
    {
        return User::findOrFail($id)->delete();
         Toastr::success('Deleted Successfully!!','success');
         return redirect()->back();
    }
}
