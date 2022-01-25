@extends('layouts.frontend.app')
@section('title','single post')
@push('css')
    <link href="{{asset('assets/frontend/css/single-post')}}/styles.css" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/single-post')}}/responsive.css" rel="stylesheet">
    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{asset('storage/post/'.$post->image)}});
            background-size: cover;
        }
        .favourite_posts{
            color: blue;
        }
    </style>
@endpush
@section('content')
    <div class="header-bg">
        <div class="display-table  center-text">
            <h1 class="title display-table-cell"><b>{{$post->name}}</b></h1>
        </div>
    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{$post->user->name}}</b></a>
                                    <h6 class="date">on {{$post->created_at->diffForHumans()}}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>

                            <p class="para">{!! html_entity_decode($post->body)!!}</p>

                            <div class="post-image"><img src="{{asset('storage/post/'.$post->image)}}" width="50px" alt="Blog Imagee"></div>

                            <ul class="tags">
                                @foreach($post->tags as $tag)
                                    <li><a href="{{route('tag.posts',$tag->slug)}}">{{$tag->name}}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest()
                                        <a href="javascript:void(0);" onclick="toastr.info('To add favourite list, you have to login first','info',{
                                                closeButton:true,
                                                progressBar:true
                                            });"><i class="fa fa-heart"></i>{{$post->favourite_to_users->count()}}</a>
                                    @else
                                        <a href="javascript:void(0);" onclick="document.getElementById('favourite-form-{{$post->id}}').submit();"
                                           class="{{!Auth::user()->favourite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favourite_posts' :''}}"
                                        ><i class="fa fa-heart"></i>{{$post->favourite_to_users->count()}}</a>
                                        <form id="favourite-form-{{$post->id}}" method="POST" action="{{route('post.favourite',$post->id)}}" style="display: none">@csrf</form>
                                    @endguest

                                </li>
                                <li><a href="#"><i class="fa fa-comment-o"></i>{{$post->comments->count()}}</a></li>
                                <li><a href="#"><i class="fa fa-eye"></i>{{$post->view_count}}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-vimeo-square"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest-square"></i></a></li>
                            </ul>
                        </div>




                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p>{{$post->user->about}}</p>
                        </div>

                        <div class="tag-area">

                            <h4 class="title"><b>CATEGORIES </b></h4>
                            <ul>
                                @foreach($post->categories as $category)
                                <li><a href="{{route('category.posts',$category->slug)}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @foreach($randomPosts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image)}}" alt="Blog Image"></div>

                                <a class="avatar" href="{{route('post.author.profile',$post->user->username)}}"><img src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{route('post.details',$post->slug)}}"><b>{{$post->title}}</b></a></h4>

                                    <ul class="post-footer">

                                        <li>
                                            @guest()
                                                <a href="javascript:void(0);" onclick="toastr.info('To add favourite list, you have to login first','info',{
                                                closeButton:true,
                                                progressBar:true
                                            });"><i class="fa fa-heart"></i>{{$post->favourite_to_users->count()}}</a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById('favourite-form-{{$post->id}}').submit();"
                                                   class="{{!Auth::user()->favourite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favourite_posts' :''}}"
                                                ><i class="fa fa-heart"></i>{{$post->favourite_to_users->count()}}</a>
                                                <form id="favourite-form-{{$post->id}}" method="POST" action="{{route('post.favourite',$post->id)}}" style="display: none">@csrf</form>
                                            @endguest

                                        </li>
                                        <li><a href="#"><i class="fa fa-comment-o"></i>{{$post->comments->count()}}</a></li>
                                        <li><a href="#"><i class="fa fa-eye"></i>{{$post->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach



            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">

                        @guest()
                            To write a comment, you have to <a class="btn btn-info btn-sm" href="{{route('login')}}">Login </a>
                        @else
                        <form method="post" action="{{route('comment.store',$post->id)}}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                </div><!-- col-sm-12 -->
                            </div><!-- row -->
                        </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{$post->comments()->count()}})</b></h4>

                    @if($post->comments()->count() > 0)

                        @foreach($post->comments() as $comment)

                            <div class="commnets-area ">
                                <div class="comment">
                                    <div class="post-info">
                                        <div class="left-area">
                                            <a class="avatar" href="#"><img src="{{asset('storage/profile/'.$comment->user()->image)}}" alt="Profile Image"></a>
                                        </div>
                                        <div class="middle-area">
                                            <a class="name" href="#"><b>{{$comment->user()->name}}</b></a>
                                            <h6 class="date">on {{$comment->created_at->diffForHumans()}}</h6>
                                        </div>
                                    </div><!-- post-info -->
                                    <p>{{$comment->comment}}</p>
                                </div>-->
                                @endforeach
                            </div><!-- commnets-area-->
                    @else
                        <div class="commnets-area ">
                            <div class="comment">
                                <p> No comment yet, Be the first ...</p>
                            </div>

                        </div><!-- commnets-area -->
                    @endif




                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>

@endsection
@push('script')

@endpush
