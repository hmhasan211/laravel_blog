<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function add($post)
    {
       $user = Auth::user();
       $isFavourite = $user->favourite_posts()->where('post_id',$post)->count();
       if ($isFavourite == 0)
       {
           $user->favourite_posts()->attach($post);
           Toastr::success('Added to Favourite list!!','success');
           return redirect()->back();
       }else{
           $user->favourite_posts()->detach($post);
           Toastr::error('Removed from Favourite list!!','Removed');
           return redirect()->back();
       }
    }
}
