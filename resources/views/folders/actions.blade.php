@can('update',$row)
<a href="/folders/{{$row->id}}/edit" class="bttn btn btn-sm btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a>
@endcan

@can('delete',$row)
<form method="POST" style="display: inline;" action="folders/{{$row->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this folder\?');" class="bttn btn btn-sm btn-danger">
        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>


<a href="folders/{{$row->id}}" class="bttn btn btn-sm btn-primary" data-id="{{$row->id}}"><i class="fa fa-eye"></i><span>Open</span></a>
@endcan