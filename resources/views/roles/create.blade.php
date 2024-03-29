@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create Role</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" method="POST" action="{{ route('roles.store') }}" style=" width:90% ">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description">
                                            <div class="col-md-12 error">
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <strong>Permission:</strong>
                                            <br />
                                            @foreach($permission as $value)
                                            <div style="width:50%;float:left">
                                            <label> 
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"> 
                                                {{ $value->name }}
                                            </label>
                                            </div>
                                            
                                            @endforeach
                                        </div>

                                        <div class="form-group mb-0">

                                            <button type="submit" class="btn btn-sm btn-primary pull-right m-t-n-xs" style="width: 100px ;margin-top:20px;">
                                                Submit
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('validation')
        {!! JsValidator::formRequest('App\Http\Requests\StoreRoleRequest') !!}
        @endsection