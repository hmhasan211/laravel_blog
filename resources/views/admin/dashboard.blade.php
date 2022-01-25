@extends('layouts.backend.app')
@section('title','Dashboard')
@push('css')

@endpush
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>
        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL POSTS</div>
                        <div class="number count-to" data-from="0" data-to="{{$posts->count()}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">favorite</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL FAVORITE POST</div>
                        <div class="number count-to" data-from="0" data-to="{{Auth::User()->favourite_posts()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">forum</i>
                    </div>
                    <div class="content">
                        <div class="text">PENDING POST</div>
                        <div class="number count-to" data-from="0" data-to="{{$pending_posts}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">visibility</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL VIEWS</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_view}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Widgets -->

        <!-- Widgets -->
        <div class="row clearfix">

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">apps</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL CATEGORIES</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_category}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>

                <div class="info-box bg-amber hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">labels</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL TAGS</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_tags}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>

                <div class="info-box bg-purple hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">account_circle</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL AUTHORS</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_authors}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>

                <div class="info-box bg-blue-grey hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">person_add</i>
                    </div>
                    <div class="content">
                        <div class="text">AUTHOR TODAY</div>
                        <div class="number count-to" data-from="0" data-to="{{$new_authors_perDay}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>

            </div>

            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="card">
                    <div class="header">
                        <h2>TOP POSTS</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Ranks</th>
                                    <th>Title</th>
                                    <th>Views</th>
                                    <th>Favourite</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($popular_posts as $key=>$post)
                                    <tr class="text-center">
                                        <td>{{$key + 1}}</td>
                                        <td>{{str_limit($post->title,30)}}</td>
                                        <td>{{$post->view_count}}</td>
                                        <td>{{$post->favourite_to_users_count}}</td>
                                        <td>{{$post->comments_count}}</td>
                                        <td>
                                            @if($post->status == true)
                                                <span class="badge bg-green">published</span>
                                            @else
                                                <span class="badge bg-yellow">pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{route('post.details',$post->slug)}}" class="btn btn-primary waves-effect btn-sm">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
        <!-- #END# Widgets -->

        <!-- Widgets -->
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>ACTIVE AUTHORS</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Ranks</th>
                                    <th>Name</th>
                                    <th>Posts</th>
                                    <th>Comments</th>
                                    <th>Favourite post</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($active_users as $key=>$author)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$author->name}}</td>
                                        <td>{{$author->posts_count}}</td>
                                        <td>{{$author->comment_count}}</td>
                                        <td>{{$author->favourite_posts_count}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
        <!-- #END# Widgets -->


    </div>
@endsection
@push('script')

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{asset('assets/backend')}}/plugins/jquery-countto/jquery.countTo.js"></script>

    <script src="{{asset('assets/backend')}}/js/pages/index.js"></script>
@endpush
