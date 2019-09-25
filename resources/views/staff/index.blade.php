@extends('layouts.admin')
@section('content')
<h1>Manage Staff Members</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>

@if(auth()->user()->can('user-create'))

<a class="btn btn-info btn-sm" href="{{ route('staff.create') }}"><i class="fa fa-plus"></i><span>Add New User</span></a><br><br>
@endif

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>gender</th>
            <th>City</th>
            <th>Country</th>
            <th>Job</th>
            <th>Role</th>
            @if(auth()->user()->can('user-edit') ||auth()->user()->can('user-delete') )
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
            url: "{{ route('staff.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'first_name'
            },
            {
                data: 'last_name'
            },
            {
                data: 'email'
            },
            {
                data: 'phone'
            },
            {
                data: 'gender'
            },
            {
                data: 'city_name'
            },
            {
                data: 'country_name'
            },
            {
                data: 'job_name'
            },
            {
                data: 'role_name'
            },
            
            @if(auth()->user()->can('user-edit') ||auth()->user()->can('user-delete') )
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