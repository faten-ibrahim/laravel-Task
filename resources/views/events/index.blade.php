@extends('layouts.admin')
@section('content')
<h1>Manage Events</h1>
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
</div>
@endif
<br>


@can('create',App\Event::class)
<a class="btn btn-info btn-sm" href="{{route('events.create')}}"><i class="fa fa-plus"></i><span>Add New Event</span></a><br><br>
@endcan

<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Main Title </th>
            <th>Secondary Title</th>
            <th>Location</th>
            <th>Published</th>
            <th>Start date</th>
            <th>End date</th>
            @canAny(['event-update','event-delete'])
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
            url: "{{ route('events.index') }}",
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
                data: 'location'
            },
            {
                mRender: function(data, type, row) {
                    if(row.is_published){
                        return '<i class="fa fa-check" style="margin-left:40%"></i>'
                    }else{
                        return '<i class="fa fa-close" style="margin-left:40%"></i>'
                    }
                }
            },   
            {
                data:'start_date'
            },
            {
                data:'end_date'
            },
            
            @canAny(['event-update', 'event-delete']) {
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