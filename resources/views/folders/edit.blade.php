@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create Event</h5>
                        </div>

                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12"> 
                                    {!! Form::model($folder, array('route' => array('folders.update', $folder->id), 'method' => 'PUT') ) !!}
                                    <div class="form-group">
                                        {!! Form::label('Name', 'name') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('Description', 'description') !!}
                                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('staff', 'staff') !!}
                                        {!! Form::select('staff[]',$staff, null, array('class' => 'form-control chosen-select','multiple'=>'multiple')) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('CRUD permission', 'crud_permission') !!}
                                        {!! Form::checkbox('crud_permission','value',true) !!}
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
@section('script')
<script type="text/javascript">
    $(".chosen-select").select2();
</script>
@endsection
@section('validation')

{!! JsValidator::formRequest('App\Http\Requests\StoreFolderRequest') !!}
@endsection