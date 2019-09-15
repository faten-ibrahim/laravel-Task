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
                                    <form role="form" method="POST" action="{{route('cities.update',['city' => $city->id])}}" style=" width:90% ">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" type="text" value="{{ $city->name }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="country_id">Country</label>
                                            <select class="form-control col-md-4" name="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->full_name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="col-md-12 error">
                                                @error('country_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group mb-0">

                                            <button type="submit" class="btn btn-sm btn-primary pull-right m-t-n-xs" style="width: 100px;">
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
