@extends('layouts.admin')
@section('content')
<h1>Manage Roles</h1>
@if (session('status'))
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif
    <br>
<a class="btn btn-info btn-sm" href="roles/create"><i class="fa fa-plus"></i><span>Add New Role</span></a><br><br>
<table id="example" class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
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
            url: "/get_roles",
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
            {
                mRender: function(data, type, row) {
                    return '<a  href="/roles/' + row.id + '/edit" class="bttn btn btn-xs btn-success " data-id="' + row.id + '"><i class="fa fa-edit"></i><span>Edit</span></a>' +
                        '<form method="POST" style="display: inline;" action="roles/'+row.id+'">@csrf {{ method_field('DELETE')}}<button type="submit" onclick="return myFunction();" class="bttn btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>'
                }
            },

        ],

        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'paging': true,

    });

    //confirm deleting
    function myFunction() {
        var agree = confirm("Are you sure you want to delete this role\?");
        if (agree == true) {
            return true
        } else {
            return false;
        }
    }
</script>

</div>

@endsection
