@extends('layouts.admin')

@section('content')
        <div class="col-md-5">
            <div class="card"  style="margin-top: -20px; min-height:600px;">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Staff Member</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" method="POST" action="{{route('staff.update',['staff' => $user->id])}}" style=" width:90% ">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group" style="float:left; max-width:45%; margin-right:10%">
                                            <label for="first_name">{{ __('First Name') }}</label>
                                            <input id="first_name" type="text" value="{{ $user->first_name }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group" style="float:left; max-width:45%;">
                                            <label for="first_name">{{ __('Last Name') }}</label>
                                            <input id="first_name" type="text" value="{{ $user->last_name }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group" style="float:left; max-width:45%; margin-right:10%">
                                            <label for="first_name">{{ __('Email') }}</label>
                                            <input id="first_name" type="email" value="{{ $user->email }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group" style="float:left; max-width:45%;">
                                            <label for="first_name">{{ __('Phone') }}</label>
                                            <input id="first_name" type="text" value="{{ $user->phone }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            <div class="col-md-12 error">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="role_id">Role</label>
                                            <select class="form-control col-md-4" name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                                @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="col-md-12 error">
                                                @error('role_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>



                                            <div class="form-group">
                                                <label for="job_id">Job</label>
                                                <select class="form-control col-md-4" name="job_id" class="form-control @error('job_id') is-invalid @enderror" required>
                                                    @foreach($jobs as $job)
                                                    <option value="{{$job->id}}">{{$job->name}}</option>
                                                    @endforeach
                                                </select>

                                                <div class="col-md-12 error">
                                                    @error('job_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
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



                                                    <div class="form-group">
                                                        <label for="city_id">City</label>
                                                        <select class="form-control col-md-4" name="city_id" class="form-control @error('city_id') is-invalid @enderror" required>
                                                            @foreach($cities as $city)
                                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                                            @endforeach
                                                        </select>

                                                        <div class="col-md-12 error">
                                                            @error('city_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <strong>Gendre:</strong>
                                                        <input type="radio" name="gender" value="{{$user->male}}"> Male<br>
                                                        <input type="radio" name="gender" value="{{$user->female}}"> Female<br>
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
        @endsection