@extends('layouts.admin')
@section('content')
<h1>Manage Jobs</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>


@can('create',App\City::class) 
<a class="btn btn-info btn-sm" href="{{route('jobs.create')}}"><i class="fa fa-plus"></i><span>Add New Job</span></a><br><br>
@endcan

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            @if(auth()->user()->can('job-edit') ||auth()->user()->can('job-delete') )
            <th>Actions</th>
            @endif

        </tr>
    </thead>
</table>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $('#example').DataTable({
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('jobs.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'description'
            },
            @if(auth()->user()->can('job-edit') ||auth()->user()->can('job-delete') )
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            @endif
        ],

        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'paging': true,

    });
</script>

</div>

@endsection