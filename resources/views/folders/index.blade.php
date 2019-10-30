@extends('layouts.admin')
@section('content')
<h1>Manage Library</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>


@can('create',App\Folder::class)
<a class="btn btn-info btn-sm" href="{{route('folders.create')}}"><i class="fa fa-plus"></i><span>Add New Folder</span></a><br><br>
@endcan

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name </th>
            <th>Description</th>
            <th>created at</th>
            <th>Actions</th>
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
            url: "{{ route('folders.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'folderName',
                name: 'folderName',
                orderable: false,
                searchable: false
            },
            {
                data: 'description'
            },
            {
                data:'created_at'
            },
           {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
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