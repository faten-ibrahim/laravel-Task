@extends('layouts.admin')
@section('content')
<h1>Manage News</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>


@can('create',App\News::class)
<a class="btn btn-info btn-sm" href="{{route('news.create')}}"><i class="fa fa-plus"></i><span>Add New News</span></a><br><br>
@endcan

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Main Title </th>
            <th>Secondary Title</th>
            <th>type</th>
            <th>Author</th>
            <th>created at</th>
            @canAny(['news-update','news-delete'])
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
            url: "{{ route('news.index') }}",
            dataType: 'json',
            type: 'get',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'main_title'
            },
            {
                data: 'secondary_title'
            },
            {
                data: 'type'
            },
            
            {
                data: 'staff_member.user.first_name'
            },
            {
                data:'created_at'
            },

            @canAny(['news-update', 'news-delete']) {
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