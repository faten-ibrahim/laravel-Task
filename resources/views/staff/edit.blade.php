@extends('layouts.admin')

@section('content')
<div class="col-md-5">
    <div class="card" style="margin-top: -20px; min-height:600px;">
        <div class="card-body">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Staff Member</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" class="mystyle" enctype="multipart/form-data" method="POST" action="{{route('staff.update',['staff' => $staff->id])}}" style=" width:90% ">
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
                                    <label for="last_name">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text" value="{{ $user->last_name }}" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                    <div class="col-md-12 error">
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group" style="float:left; max-width:45%; margin-right:10%">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" type="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <div class="col-md-12 error">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group" style="float:left; max-width:45%;">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input id="phone" type="text" value="{{ $user->phone }}" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="first_name" autofocus>
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
                                            <select class="form-control col-md-4" id="country" name="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                                <option value="" selected disabled>Select</option>
                                                @foreach($countries as $key => $country)
                                                <option value="{{$key}}"> {{$country}}</option>
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
                                                <label for="title">Select City:</label>
                                                <select name="city_id" id="city" class="form-control" style="width:350px">
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
                                                <input type="radio" name="gender" value="Male" {{ $user->gender == 'Male' ? 'checked' : ''}}> Male<br>
                                                <input type="radio" name="gender" value="Female" {{ $user->gender == 'Female' ? 'checked' : ''}}> Female<br>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <input type="file" name="image_name" class="form-control" id="name" value="">
                                                @if($errors->has('image_name'))
                                                <span class="help-block">{{ $errors->first('image_name') }}</span>
                                                @endif
                                            </div>
                                            <br>
                                            <br>
                                            <div class="form-group mb-0">

                                                <button type="submit" class="btn btn-sm btn-primary pull-right m-t-n-xs" style="width: 100px;">
                                                    Submit
                                                </button>
                                                <br>
                                                <br>
                                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $('#country').change(function() {
            var countryID = $(this).val();
            // alert(countryID);
            if (countryID) {
                $.ajax({
                    type: "GET",
                    url: "{{url('get-city-list')}}?country_id=" + countryID,
                    success: function(res) {
                        if (res) {
                            $("#city").empty();
                            $("#city").append('<option>Select</option>');
                            $.each(res, function(key, value) {
                                $("#city").append('<option value="' + key + '">' + value + '</option>');
                            });

                        } else {
                            $("#city").empty();
                        }
                    }
                });
            } else {
                $("#city").empty();
            }
        });
    </script>

    @endsection