@extends('layouts.backend.app')
@section('title','Post create')
@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{asset('assets/backend')}}/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
@endpush
@section('content')

    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <form method="POST" action="{{ route('author.post.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="col-lg-8 ">
           
            <div class="card">
                <div class="header">
                    <h2>
                       Title and Feature Image 
                    </h2>
                </div>
                <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="title" id="" class="form-control">
                                <label class="form-label">Title</label>
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="image">Select Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                    <div class="form-group">
                        <input type="checkbox" name="status" id="publish" class="filled-in" value="1">
                        <label for="publish">Published</label>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-4  ">
            <div class="card">
                <div class="header">
                    <h2>
                      Categories and Tags
                    </h2>
                </div>
                <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line {{$errors->has('categories')?'focused error':''}} ">
                                <label for="category">Select Category </label>
                                <select name="categories[]" id="category" data-live-search="true" multiple class="form-control show-tick">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line {{$errors->has('tags')?'focused error':''}}">
                                <label for="category">Select Tag </label>
                                <select name="tags[]" id="tag" data-live-search="true" multiple class="form-control show-tick">
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <a href="{{ route('author.post.index') }}" class="btn btn-danger waves-effect m-t-15">Back</a>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-lg-12 ">
            <div class="card">
                <div class="header">
                    <h2>
                       Body
                    </h2>
                </div>
                <div class="body">
                        <textarea id="tinymce" name="body">

                        </textarea>
                </div>
            </div>
        </div>
        </form>
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
