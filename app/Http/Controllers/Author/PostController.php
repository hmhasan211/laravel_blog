<?php

namespace App\Http\Controllers\Author;

use App\Tag;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::latest()->get();
        $data['tags'] = Tag::latest()->get();
        return view('author.post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image)) {
            //make unique name
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            //check directory exist
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            $postImage = Image::make($image)->resize(1600, 1066)->save('my-image.jpg', 90);
            Storage::disk('public')->put('post/' . $imageName, $postImage);
        } else {
            $imageName = 'default.png';
        }
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

       //notification to Admin
       $users = User::where('role_id',1)->get();
       Notification::send($users, new NewAuthorPost($post));

        Toastr::success('Data Saved Successfully!!', 'Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Sorry!! You are not Authorized.','error');
             return redirect()->back();
        }
        return view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Sorry!! You are not Authorized.','error');
             return redirect()->back();
        }
        $categories = Category::latest()->get();
        $tags = Tag::latest()->get();
        return view('author.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Sorry!! You are not Authorized.','error');
             return redirect()->back();
        }
        $request->validate([
            'title'=>'required',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required',
            'image'=>'mimes:jpg,jpeg,png',
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->title);
        if (isset($image))
        {
                //make unique name
                $currentDate = Carbon::now()->toDateString();
                $imageName   = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                //check directory exist
                if (!Storage::disk('public')->exists('post')) {
                    Storage::disk('public')->makeDirectory('post');
                }
                //delete old image
                    if (Storage::disk('public')->exists('post/'.$post->image)){
                        Storage::disk('public')->delete('post/'.$post->image);
                    }
                $postImage = Image::make($image)->resize(1600,1066)->save('my-image.jpg', 90);
                Storage::disk('public')->put('post/'.$imageName,$postImage);
            }else{
                $imageName = $post->image;
            }

            $post->user_id = Auth::id();
            $post->title   = $request->title;
            $post->slug    = $slug;
            $post->image   = $imageName;
            $post->body    = $request->body;
            if (isset($request->status)){
                $post->status = true;
            }else{
                $post->status = false;
            }
            $post->is_approved = false;
            $post->save();

            $post->categories()->sync($request->categories);
            $post->tags()->sync($request->tags);

            Toastr::success('Data updated Successfully!!','Success');
            return redirect()->route('author.post.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Sorry!! You are not Authorized.','error');
             return redirect()->back();
        }

        if(Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Data has been deleted !!','Success');
        return redirect()->back();
    }
}
