@extends('layouts.backend.app')
@section('title','comments')
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
                        All Comments
                        <span class="badge bg-pink">{{ $comments->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr  class="text-center">
                                <th class="text-center">Comment Info</th>
                                <th class="text-center">Post Info</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="">
                                                    <img src="{{asset('storage/profile/'.$comment->user->image)}}"  width="64" height="64" alt="commenter image">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$comment->user->name}}  <small>{{$comment->created_at->diffForHumans()}}</small></h4>
                                                <p>{{$comment->comment}}</p>
                                                <a target="_blank" href="{{route('post.details',$comment->post->slug.'#comments')}}">Reply</a>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="media">
                                            <div class="media-right">
                                                <a href="{{route('post.details',$comment->post->slug)}}">
                                                    <img class="media-object" src="{{asset('storage/post/'.$comment->post->image)}}"  width="64" height="64" alt="commenter image">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{str_limit($comment->post->title,'40')}}  <small>{{$comment->created_at->diffForHumans()}}</small></h4>
                                                <a target="_blank" href="{{route('post.details',$comment->post->slug.'#comments')}}">Reply</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="removeData({{$comment->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="remove-form-{{$comment->id}}" method="post"  action="{{route('admin.comments.destroy',$comment->id)}}" style="display: none">
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
