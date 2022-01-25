@extends('layouts.frontend.app')
@section('title','Author Profile')
@push('css')
    <link href="{{asset('assets/frontend/css/profile-post')}}/styles.css" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/profile-post')}}/responsive.css" rel="stylesheet">
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
        <h1 class="title display-table-cell"><b>{{$author->name}}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">

                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                                <div class="col-lg-6 col-md-6">
                                    <div class="card h-100">
                                        <div class="single-post post-style-1">

                                            <div class="blog-image"><a href="{{route('post.details',$post->slug)}}"><img src="{{ asset('storage/post/'.$post->image)}}" alt="Blog Image"></a></div>

                                            <a class="avatar" href=""><img src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>

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
                            <div class="blog-info">
                                <h4 class="title">
                                    Sorry, No Post Found !!!
                                </h4>
                            </div><!-- blog-info -->
                        @endif


                    </div><!-- row -->

                    <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <b><u>{{$author->name}}</u></b>
                            <p>{{$author->about}}</p>

                        </div>

                        <div class="subscribe-area">

                            <h4 class="title"><b> OTHER INFORMATION</b></h4>
                            <strong>Since:-{{$author->created_at->toDateString()}}</strong>
                            <p>Total Post: {{$author->posts()->count()}}</p>

                        </div><!-- subscribe-area -->

                        <div class="tag-area">

                            <h4 class="title"><b>TAG CLOUD</b></h4>
                            <ul>
                                <li><a href="#">Manual</a></li>
                                <li><a href="#">Liberty</a></li>
                                <li><a href="#">Recomendation</a></li>
                                <li><a href="#">Interpritation</a></li>
                                <li><a href="#">Manual</a></li>
                                <li><a href="#">Liberty</a></li>
                                <li><a href="#">Recomendation</a></li>
                                <li><a href="#">Interpritation</a></li>
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->




@endsection
@push('script')

@endpush
