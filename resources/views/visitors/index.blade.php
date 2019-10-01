@extends('layouts.admin')
@section('content')
<h1>Manage Visitors</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>

@can('create',App\Visitor::class)
<a class="btn btn-info btn-sm" href="{{ route('visitors.create') }}"><i class="fa fa-plus"></i><span>Add Visitor</span></a><br><br>
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
            @canAny(['visitor-update','visitor-delete'])
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
            url: "{{ route('visitors.index') }}",
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
                data: 'city.name'
            },
            {
                data: 'city.country.full_name'
            },
            @canAny(['visitor-update', 'visitor-delete']) {
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