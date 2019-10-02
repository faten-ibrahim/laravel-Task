@can('update',$row)
<a href="/visitors/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a>
@endcan
@can('delete',$row)
<form method="POST" style="display: inline;" action="/visitors/{{$row->id}}/">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this visitor \?');" class="bttn btn btn-xs btn-danger">
                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>

@if($row->is_active)
<a href="visitors/{{$row->id}}/toggle" class="bttn btn btn-xs btn-warning " data-id="{{$row->id}}"><i class="fa fa-ban"></i><span>Deactive</span></a>
@else
<a href="visitors/{{$row->id}}/toggle" class="bttn btn btn-xs btn-info" data-id="{{$row->id}}"><i class="fa fa-check"></i><span>Active</span></a>
@endif
@endcan