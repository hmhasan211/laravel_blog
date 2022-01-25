@extends('layouts.backend.app')
@section('title','tag')
@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/')}}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush
@section('content')
    <div class="block-header">
        <h2>
            <a class="btn btn-primary waves-effect" href="{{ route('admin.tag.create') }}">
                <i class="material-icons">add</i>
                <span>Add New Tag</span>
            </a>
        </h2>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{--show alert--}}
          @include('admin.alert')
            {{--show alert--}}
            <div class="card">
                <div class="header">
                    <h2>
                        All Tags
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>#sl</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $key=>$tag)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.tag.edit',$tag->id)}}" class="btn btn-info waves-effect">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button  class="btn btn-danger waves-effect" type="button" onclick="if(confirm('Are you sure want to delete?')){
                                        event.preventDefault();document.getElementById('delete-form-{{$tag->id}}').submit();
                                        }else{
                                        even.preventDefault();
                                        }"><i class="material-icons">delete</i>
                                    </button>
                                    <form id="delete-form-{{$tag->id}}" method="post"  action="{{route('admin.tag.destroy',$tag->id)}}" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
@endsection
@push('script')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="{{asset('assets/backend')}}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <!-- Custom Js -->
    <script src="{{asset('assets/backend')}}/js/admin.js"></script>
    <script src="{{asset('assets/backend')}}/js/pages/tables/jquery-datatable.js"></script>

@endpush
