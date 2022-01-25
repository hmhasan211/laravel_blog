<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\NotifySubscriber;
use App\Subscriber;
use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AuthorPostApproved;

class PostController extends Controller
{
    
    public function index()
    {
        $data['posts'] = Post::latest()->get();
        return view('admin.post.index', $data);
    }

    
    public function create()
    {
        $data['categories'] = Category::latest()->get();
        $data['tags'] = Tag::latest()->get();
        return view('admin.post.create', $data);
    }

   
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
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        //notification to subscriber
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Notification::route('mail',$subscriber->email)->notify(new NotifySubscriber($post));
        }

        Toastr::success('Data Saved Successfully!!', 'Success');
        return redirect()->route('admin.post.index');
    }


    
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::latest()->get();
        $tags = Tag::latest()->get();
        return view('admin.post.edit',compact('post','categories','tags'));
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
            $post->is_approved = true;
            $post->save();

            $post->categories()->sync($request->categories);
            $post->tags()->sync($request->tags);

            Toastr::success('Data updated Successfully!!','Success');
            return redirect()->route('admin.post.index');
    }


    public function pending(){
        $posts  = Post::where('is_approved',false)->latest()->get();
        return view('admin.post.pending',compact('posts'));
    }

    public function approval($id){
        $post = Post::find($id);
        if( $post->is_approved == false)
        {
             $post->is_approved = true;
              $post->save();

            //notification send to Author
            $post->user->notify(new AuthorPostApproved($post));

            //notification to subscriber
            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) {
                Notification::route('mail',$subscriber->email)->notify(new NotifySubscriber($post));
            }
            Toastr::success('Post has been Approved','success');
        }else{
         Toastr::info('Post already Approved','info');
        }
       return redirect()->back();
    }



    public function destroy(Post $post)
    {
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


