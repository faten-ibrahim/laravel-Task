@if(auth()->user()->can('role-edit'))
<a href="staff/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif
@if(auth()->user()->can('role-delete'))
<form method="POST" style="display: inline;" action="staff/{{$row->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this staff member\?');" class="bttn btn btn-xs btn-danger">
                   <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>
@endif