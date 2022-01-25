<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $cmmntPosts = Auth::user()->posts;
        return view('author.comments',compact('cmmntPosts'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id())
        {
            Toastr::success('Comment Deleted Successfully!!','success');
        }else{
            Toastr::error('Sorry, you are not authorized to delete this comment!!','Error');
        }
        return redirect()->back();
    }
}
