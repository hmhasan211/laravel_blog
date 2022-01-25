@extends('layouts.backend.app')
@section('title','post')
@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/')}}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        All Favourite Post
                        <span class="badge bg-pink">{{ $posts->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr  class="text-center">
                                <th>#sl</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th><i class="material-icons">visibility</i></th>
                                <th><i class="material-icons">favorite</i></th>
{{--                                <th><i class="material-icons">comment</i></th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $key=>$post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ str_limit( $post->title,'10') }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->view_count }}</td>
                                <td>{{ $post->user->favourite_posts->count() }}</td>
{{--                                {{ $post->user->favourite_posts->count() }}--}}
                                <td class="text-center">
                                    <a href="{{route('admin.post.show',$post->id)}}" class="btn btn-info btn-xs waves-effect">
                                        <i class="material-icons">visibility</i>
                                    </a>

                                    <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="removeData({{$post->id}})">
                                        <i class="material-icons">delete</i>
                                    </button>
                                    <form id="remove-form-{{$post->id}}" method="post"  action="{{route('post.favourite',$post->id)}}" style="display: none">
                                        @csrf
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
{{--    sweetalert--}}
    <script src="https://unpkg.com/sweetalert2@10.15.5/dist/sweetalert2.all.js" ></script>
    <script type="text/javascript">
        function removeData(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('remove-form-'+id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }

         function approvePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to Approve this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('approval-form').submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        ' Not Approved yet :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
