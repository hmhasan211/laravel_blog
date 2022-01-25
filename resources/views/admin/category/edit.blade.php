@extends('layouts.backend.app')
@section('title','Category create')
@push('css')

@endpush
@section('content')

    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-6  col-md-6  col-sm-6  col-xs-6  col-md-offset-3">
            {{--show alert--}}
            @include('admin.alert')
            {{--end alert--}}
            <div class="card">
                <div class="header">
                    <h2>
                        Create New Category
                    </h2>
                </div>
                <div class="body">
                    <form method="POST" action="{{route('admin.category.update',$category->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" value="{{$category->name}}" id="" class="form-control">
                                <label class="form-label">Category name</label>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="image"/>
                                <img src="{{asset('storage/category/'.$category->image)}}" alt=" image" width="100px" height="100px">
                            </div>
                        </div>
                        <a href="{{ route('admin.category.index')  }}" class="btn btn-danger waves-effect m-t-15">Back</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
@endsection
@push('script')

@endpush
