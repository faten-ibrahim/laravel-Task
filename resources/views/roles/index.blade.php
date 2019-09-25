@extends('layouts.admin')
@section('content')
<h1>Manage Roles</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>


@can('create',App\Role::class) 
<a class="btn btn-info btn-sm" href="roles/create"><i class="fa fa-plus"></i><span>Add New Role</span></a><br><br>
@endcan

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            @if(auth()->user()->can('role-edit') ||auth()->user()->can('role-delete') )
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
            url: "{{ route('roles.index') }}",
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
            @if(auth()->user()->can('role-edit') ||auth()->user()->can('role-delete') )
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