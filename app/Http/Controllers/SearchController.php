<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
       $query = $request->input('query');
       $searchPost = Post::where('title','LIKE',"%$query%")->Approved()->Published()->get();
       return view('search',compact('searchPost','query'));
    }
}
