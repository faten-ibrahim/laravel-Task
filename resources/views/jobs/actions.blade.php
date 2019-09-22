@if(auth()->user()->can('job-edit'))
@if($jobName == 'reporter' || $jobName == 'writter')
<a href="#" class="bttn btn btn-xs btn-success " disabled="disabled"> <i class="fa fa-edit"></i> <span>Edit</span></a>
@else
<a href="/jobs/{{$rowId}}/edit" class="bttn btn btn-xs btn-success " data-id="{{$rowId}}"><i class="fa fa-edit"></i><span>Edit</span></a> 
@endif
@endif

@if(auth()->user()->can('job-delete'))
@if($jobName == 'reporter' || $jobName == 'writter')
<a href="#" class="bttn btn btn-xs btn-danger" disabled="disabled"> <i class="fa fa-trash"></i><span>Delete</span></a>
@else
<form method="POST" style="display: inline;" action="jobs/{{$rowId}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this job\?');" class="bttn btn btn-xs btn-danger">
                   <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>
@endif
@endif