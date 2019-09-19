@extends('layouts.admin')
@section('content')
<h1>Manage Cities</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>

@if(auth()->user()->can('city-create')
<a class="btn btn-info btn-sm" href="cities/create"><i class="fa fa-plus"></i><span>Add New City</span></a><br><br>
@endif
<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Country</th>
            @if(auth()->user()->can('city-edit') ||auth()->user()->can('city-delete') )
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
            url: "{{ route('cities.index') }}",
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
                mRender: function(data, type, row) {
                    return row.country.full_name

                }
            },
            @if(auth() - > user() - > can('city-edit') || auth() - > user() - > can('city-delete')) {
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