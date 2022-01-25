<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function details($slug)
    {
        $post = Post::where('slug',$slug)->Approved()->Published()->first();
        $blogKey = 'blog_'.$post->$slug;
        if (!Session::has($blogKey))
        {
            $post->increment('view_count');
            Session::put($blogKey,1);
        }
        $randomPosts = Post::Approved()->Published()->take(3)->inRandomOrder()->orderBy('id','desc')->get();
        return view('single',compact('post','randomPosts'));
    }

    public function postByCategory($slug)
    {
        $catsPost = Category::where('slug',$slug)->first();
        $posts = $catsPost->posts()->Approved()->Published()->orderBy('id','desc')->get();
        return view('category_post',compact('catsPost','posts'));
    }

    public function postByTag($slug)
    {
        $tagsPost = Tag::where('slug',$slug)->first();
        $posts = $tagsPost->posts()->Approved()->Published()->orderBy('id','desc')->get();
        return view('tag_post',compact('tagsPost','posts'));
    }


}
