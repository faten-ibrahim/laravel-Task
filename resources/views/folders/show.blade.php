@extends('layouts.admin')
@section('content')
<div class="row">
    <h3 style="text-align:center">{{ $folder->name }}</h3>
    <br>
    <br>
    <div class="col-md-12">
        <div class="col-md-4">
            <a class="btn btn-info btn-sm" href="/folders/image/create/{{$folder->id}}"><i class="fa fa-plus"></i><span>Image</span></a>


        </div>
        <div class="col-md-4">
            <a class="btn btn-info btn-sm" href="/folders/file/create/{{$folder->id}}"><i class="fa fa-plus"></i><span>File</span></a>

        </div>
        <div class="col-md-4">
            <a class="btn btn-info btn-sm" href="/folders/video/create/{{$folder->id}}"><i class="fa fa-plus"></i><span>Video</span></a>


        </div>
        @foreach($files as $file)
        @if($file->type=='image')
        <div class="col-md-4 fileBox">
            <h5>image</h5>
            <a class="btn btn-success btn-sm" href="/folders/{{$folder->id}}/media/edit/{{$file->id}}"><i class="fa fa-edit"></i><span>edit</span></a>
            <form method="POST" style="display: inline;" action="/files/{{$file->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this image \?');" class="bttn btn btn-sm btn-danger">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>
        </div>
        @elseif($file->type=='file')
        <div class="col-md-4 fileBox">
            <h5>File</h5>
            <a class="btn btn-success btn-sm" href="/folders/{{$folder->id}}/media/edit/{{$file->id}}"><i class="fa fa-edit"></i><span>edit</span></a>
            <form method="POST" style="display: inline;" action="/files/{{$file->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this file \?');" class="bttn btn btn-sm btn-danger">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>
        </div>
        @else
        <div class="col-md-4 fileBox">
            <h5>Video</h5>
            <a class="btn btn-success btn-sm" href="/folders/{{$folder->id}}/media/edit/{{$file->id}}"><i class="fa fa-edit"></i><span>edit</span></a>
            <form method="POST" style="display: inline;" action="/files//{{$file->id}}">@csrf {{ method_field('
                   DELETE ')}}<button type="submit" onclick=" confirm('Are you sure you want to delete this video \?');" class="bttn btn btn-sm btn-danger">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>
        </div>
        @endif
        @endforeach
    </div>
</div>


@endsection