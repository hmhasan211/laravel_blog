<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Post::latest()->Approved()->Published()->paginate(9);
        return view('welcome',compact('categories','posts'));
    }

}
