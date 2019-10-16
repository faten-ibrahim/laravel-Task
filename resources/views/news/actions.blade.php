@can('update',$row)
<a href="/news/{{$row->id}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$row->id}}"><i class="fa fa-edit"></i><span>Edit</span></a>
@endcan

@can('delete',$row)
<form method="POST" style="display: inline;" action="news/{{$row->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this news\?');" class="bttn btn btn-xs btn-danger">
        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>


@if($row->is_published)
<a href="news/{{$row->id}}/toggle" class="bttn btn btn-xs btn-warning " data-id="{{$row->id}}"><i class="fa fa-ban"></i><span>Unpublish</span></a>
@else
<a href="news/{{$row->id}}/toggle" class="bttn btn btn-xs btn-info" data-id="{{$row->id}}"><i class="fa fa-check"></i><span>Publish</span></a>
@endif
<a href="news/{{$row->id}}" class="bttn btn btn-xs btn-outline-dark" data-id="{{$row->id}}"><i class="fa fa-eye"></i><span>Show</span></a>
@endcan