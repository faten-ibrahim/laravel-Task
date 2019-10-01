@extends('layouts.admin')
@section('content')
<h1>Manage Staff Members</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>

@can('create',App\StaffMember::class)
<a class="btn btn-info btn-sm" href="{{ route('staff.create') }}"><i class="fa fa-plus"></i><span>Add Staff Member</span></a><br><br>
@endcan

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
            @canAny(['staff-update','staff-delete','staff-active'])
            <th>Actions</th>
            @endcan

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
                data: 'user.first_name'
            },
            {
                data: 'user.last_name'
            },
            {
                data: 'user.email'
            },
            {
                data: 'user.phone'
            },
            {
                data: 'user.gender'
            },
            {
                data: 'user.city.name'
            },
            {
                data: 'user.city.country.full_name'
            },
            {
                data: 'job.name'
            },
            {
                data: 'role.name'
            },

            @canAny(['staff-update','staff-delete','staff-active']){
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            @endcan
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