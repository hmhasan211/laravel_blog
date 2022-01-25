@extends('layouts.backend.app')
@section('title','Post create')
@push('css')

@endpush
@section('content')
<a class="btn btn-danger waves-effect" href="{{ route('author.post.index') }}">
    <i class="material-icons">keyboard_return</i>
    <span class="">Back</span></a>
@if ($post->is_approved == true)
    <button disabled class="btn btn-success pull-right wave-effect">
        <i class="material-icons">done</i>
        <span class="">Approved</span>
    </button>
@else
    <button class="btn btn-warning pull-right wave-effect" disabled>
        <i class="material-icons">watch_later</i>
        <span class="">Pending </span>
    </button>
@endif
<br><br>
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">

        <div class="col-lg-8 ">

            <div class="card">
                <div class="header">
                    <h2>
                      {{$post->title}}
                        <small>Posted by: <strong><a href="">{{$post->user->name}}</a></strong> On {{$post->created_at->toFormattedDateString()}}</small>
                    </h2>
                </div>
                <div class="body">
                    {!! $post->body !!}
                </div>
            </div>
        </div>

        <div class="col-lg-4  ">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>
                      Categories
                    </h2>
                </div>
                <div class="body">
                    @foreach($post->categories as $category)
                        <span class="label bg-cyan">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="header bg-green">
                    <h2>
                        Tags
                    </h2>
                </div>
                <div class="body">
                    @foreach($post->tags as $tag)
                        <span class="label bg-cyan">{{$tag->name}}</span>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="header bg-amber">
                    <h2>
                        Feature Image
                    </h2>
                </div>
                <div class="body">
                    <img src="{{asset('storage/post/'.$post->image)}}" alt="{{$post->title}}" width="300px">
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
@endsection
@push('script')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- TinyMCE -->
    <script src="{{asset('assets/backend')}}/plugins/tinymce/tinymce.js"></script>
    <script type="text/javascript">
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend')}}/plugins/tinymce';
        });
    </script>
@endpush
