@extends('layouts.admin')

@section('content')
<div class="col-md-7">
    <div class="card" style="margin-top: -20px;">
        <div class="card-body">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Visitor</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" class="mystyle" enctype="multipart/form-data" method="POST" action="{{route('visitors.update',['visitor' => $visitor->id])}}" style=" width:90% ">
                                @csrf
                                @method('PUT')
                                <div class="form-group" style="float:left; max-width:45%; margin-right:10%">
                                    <label for="first_name">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text" value="{{ $visitor->first_name }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                </div>

                                <div class="form-group" style="float:left; max-width:45%;">
                                    <label for="last_name">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text" value="{{ $visitor->last_name }}" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                </div>

                                <div class="form-group" style="float:left; max-width:45%; margin-right:10%">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" type="email" value="{{ $visitor->email }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                </div>

                                <div class="form-group" style="float:left; max-width:45%;">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input id="phone" type="text" value="{{ $visitor->phone }}" class="form-control @error('phone') is-invalid @enderror" name="phone" required autocomplete="phone" autofocus>

                                </div>


                                <div class="form-group" style="clear:both">
                                    <label for="country_id">Country</label>
                                    <select class="form-control col-md-4" id="country" name="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Select</option>
                                        @foreach($countries as $key => $country)
                                        <option value="{{$key}}" {{ ($visitor->country_id == $key ? "selected":"") }}> {{$country}}</option>
                                        @endforeach
                                    </select>

                                    <div class="form-group">
                                        <label for="title">Select City:</label>
                                        <select name="city_id" id="city" class="form-control" style="width:350px">
                                            @foreach($cities as $key => $city)
                                            <option value="{{$key}}" {{ ($visitor->city_id == $key ? "selected":"") }}> {{$city}}</option>
                                            @endforeach
                                        </select>


                                    </div>

                                    <!--radiobutton -->
                                    <div class="form-group">
                                        <strong>Gendre:</strong>
                                        <input type="radio" name="gender" value="Male" {{ $visitor->gender == 'Male' ? 'checked' : ''}}> Male<br>
                                        <input type="radio" name="gender" value="Female" {{ $visitor->gender == 'Female' ? 'checked' : ''}}> Female<br>
                                    </div>

                                    <div class="form-group">
                                        @if($image_name)
                                        <img src="<?php echo asset("/uploads/visitors/$image_name") ?>" width="100px" height="100px" />
                                        @endif
                                        <input type="file" name="image_name" class="form-control" id="name" value="">

                                    </div>

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
    @endsection
    @section('script')
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

    @section('validation')
    {!! JsValidator::formRequest('App\Http\Requests\StoreVisitorRequest') !!}
    @endsection