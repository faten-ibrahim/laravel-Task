@can('update',$row)
<a href="/events/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a>
@endcan

@can('delete',$row)
<form method="POST" style="display: inline;" action="events/{{$row->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this event\?');" class="bttn btn btn-xs btn-danger">
        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>


<a href="events/{{$row->id}}" class="bttn btn btn-xs btn-outline-dark" data-id="{{$row->id}}"><i class="fa fa-eye"></i><span>Show</span></a>
@endcan