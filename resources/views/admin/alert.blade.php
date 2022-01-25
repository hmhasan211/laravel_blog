@if(session('success'))
    <div class="alert alert-success alert-dismissable ">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{session('success')}}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissable ">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{session('warning')}}
    </div>
@endif

@if(session('delete'))
    <div class="alert alert-danger alert-dismissable ">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{session('delete')}}
    </div>
@endif
