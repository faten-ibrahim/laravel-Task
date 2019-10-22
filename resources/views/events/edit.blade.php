 @extends('layouts.admin')

 @section('content')
 <div class="container">
     <div class="row justify-content-center">
         <div class="col-md-9">
             <div class="card">
                 <div class="card-body">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>Edit Event</h5>
                         </div>
                         <div class="ibox-content">
                             <div class="row">
                                 <div class="col-md-12">
                                 <form role="form" method="POST" action="{{route('events.update',['event' => $event->id])}}" style=" width:90% ">
                                        @csrf
                                        @method('PUT')
                                         <div class="form-group">
                                             <label for="main_title">Main Title</label>
                                             <input name="main_title" value="{{ $event->main_title }}" id="main_title" type="text" class="form-control" required autocomplete="main_title" autofocus>
                                         </div>

                                         <div class="form-group">
                                             <label for="secondary_title">Secondary Title</label>
                                             <input name="secondary_title" value="{{ $event->secondary_title }}" id="secondary_title" type="text" class="form-control" autocomplete="secondary_title">
                                         </div>

                                         <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea name="content" id="content">{{ trim($event->content,'<p></p>') }}</textarea>
                                        </div>

                                         <div class="form-group">
                                            <label for="address_address">Location</label>
                                            <input type="text" value="{{$event->location}}" id="address-input" name="location" class="form-control map-input">
                                            <input type="hidden" value="{{$event->location_lat}}" name="location_lat" id="address-latitude" value="0" />
                                            <input type="hidden" value="{{$event->location_lang}}" name="location_lang" id="address-longitude" value="0" />
                                        </div>
                                        <div id="address-map-container" style="width:100%;height:400px; ">
                                            <div style="width: 100%; height: 100%" id="address-map"></div>
                                        </div>
                                        <br>
                                         <div class="form-group">
                                            <label for="">Start date</label>
                                            <div class='input-group date' id='example1'>
                                                <input type='text' name="start_date" value="{{ $event->start_date }}" class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date">End date</label>
                                            <div class='input-group date' id='example2'>
                                                <input type='text' name="end_date" value="{{ $event->end_date }}" class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label for="document">Upload</label>
                                            <div class="needsclick dropzone" id="document-dropzone">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <!-- <label for="content">Content</label> -->
                                            <select id="mySelect2" name="visitors[]" class="chosen-select" multiple data-placeholder="Choose visitors...">
                                                @foreach($visitors as $visitor)
                                                    <option value="{{$visitor->visitor_id}}" selected>{{$visitor->first_name." ".$visitor->last_name}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                        <br>

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
         @section('script')
         @parent
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
        <script src="{{ asset('/theme/js/api/googleMap.js') }}"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>
        <script>   
            ClassicEditor
                    .create( document.querySelector('#content') )    
                    .catch( error => {
                        console.error( error );
                    } );
        </script>
         @endsection
         @section('fileZoneScript')
         <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
         <script>
             var uploadedDocumentMap = {}
             Dropzone.autoDiscover = false;
             var path = '/uploads/events/';
             let dropzone = new Dropzone('#document-dropzone', {

                 url: '{{ route('files.storeFiles') }}?path=' + path,
                 maxFilesize: 1, // MB
                 acceptedFiles: ".jpg,.png,.pdf,.xlsx",
                 addRemoveLinks: true,
                 headers: {
                     'X-CSRF-TOKEN': "{{ csrf_token() }}"
                 },
                 init: function() {
                    var eventId = {!! $event->id !!};
                    var coverImageId = {!! $event->cover_image !!}
                    var thisDropzone = this;
                    $.ajax({
                        type: "GET",
                        url: '{{ route('files.getFiles') }}?id=' + eventId+'&model=event',
                        success: function(res) {
                            console.log(res);
                            if (res) {
                                $.each(res, function(key,value) {
                                    // var mockFile = { name: value , size: value.size};
                                    var mockFile = { name: value , size:12345};
                                    thisDropzone.emit("addedfile", mockFile);
                                    thisDropzone.emit("thumbnail", mockFile, "/uploads/events/"+mockFile.name);
                                    thisDropzone.emit("complete",mockFile);
                                    let preview = $('.dz-preview').has('img[alt="'+mockFile.name+'"]').last();
                                    if(key==coverImageId){
                                        $(preview).append('Select as cover <input type="radio" name="cover_image" value="' + key + '" checked >');
                                    }else{
                                        $(preview).append('Select as cover <input type="radio" name="cover_image" value="' + key + '">');
                                    }
                                   
                                });
                            } 
                        }
                    });
                    
                },
                 success: function(file, response) {
                    // console.log(response.fileId);
                    $('form').append('<input type="hidden" name="document[]" value="' + response.fileId + '">');
                    if (RegExp('image/*').test(file.type)){
                        let preview = $('.dz-preview').has('img[alt="'+file.name+'"]').last();
                        // console.log(preview)
                        $(preview).append('Select as cover <input type="radio" name="cover_image" value="' + response.fileId + '">');
                    }
                    uploadedDocumentMap[file.name] = response.fileId
                 },
                 removedfile: function(file) {
                     file.previewElement.remove()
                     $.post({
                         url: '{{ route('files.removeFile') }}?path=' + path,
                         data: {
                             name: file.name,
                             _token: $('[name="_token"]').val()
                         },
                         dataType: 'json',
                         success: function(data) {
                             console.log("deleted successfully from", path)
                         }
                     });
                     var name = ''
                     if (typeof file.file_name !== 'undefined') {
                         name = file.file_name
                     } else {
                         name = uploadedDocumentMap[file.name]
                     }
                     $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                 },
             })
             // Dropzone.options.documentDropzone = 

             $('#mySelect2').select2({
                 minimumInputLength: 1,
                 ajax: {
                     url: '{{url('get-visitors-list')}}',
                     dataType: 'json',
                     data: function(params) {
                         return {
                             q: $.trim(params.term)
                         };
                     },
                     processResults: function(data) {
                         return {
                             results: data
                         };
                     }
                 }
             });
         </script>
        <script>
            $(function () {
                $('#example1').datetimepicker({
                    minDate : new Date(),
                });
                $('#example2').datetimepicker();
            });
        </script>
         @stop
         @section('validation')
        {!! JsValidator::formRequest('App\Http\Requests\StoreEventRequest') !!}
        @endsection