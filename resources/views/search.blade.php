@extends('layouts.frontend.app')
@section('title')
    {{$query}}
@endsection
@push('css')
    <link href="{{asset('assets/frontend/css/category')}}/styles.css" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/category')}}/responsive.css" rel="stylesheet">
    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{asset('storage/category/default.jpg')}});
            background-size: cover;
        }
        .favourite_posts{
            color: blue;
        }
    </style>
@endpush
@section('content')
    <div class="slider display-table center-text header-bg">
        <h1 class="title display-table-cell"><b>Search result for "{{$query}}" </b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">
            @if($searchPost->count() > 0)
                @foreach($searchPost as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><a href="{{route('post.details',$post->slug)}}"><img src="{{ asset('storage/post/'.$post->image)}}" alt="Blog Image"></a></div>

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
                @else
                    <div class="display-table center-text">
                        <h4 class="title">
                            Sorry, No Post Found !!!
                        </h4>
                    </div><!-- blog-info -->
                @endif
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->

@endsection
@push('script')

@endpush
