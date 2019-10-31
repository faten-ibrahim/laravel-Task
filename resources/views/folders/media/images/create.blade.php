@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create Image</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'files.store', 'method'=>'post','enctype'=>'multipart/form-data' ]) !!}
                                    <div>
                                    {!! Form::hidden('folderId', $folder, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Name', 'name') !!}
                                        {!! Form::text('file_name', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('Description', 'description') !!}
                                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('upload image', 'file') !!}
                                        {!! Form::file('image',null,['class' => 'form-control']) !!}
                                    </div>

                                    <br>
                                    {!! Form::submit('submit' ,['class'=>'btn btn-sm btn-primary pull-right m-t-n-xs']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('validation')

{!! JsValidator::formRequest('App\Http\Requests\StoreMediaRequest') !!}
@endsection