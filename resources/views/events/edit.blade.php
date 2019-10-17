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
                                     <form role="form" method="POST" action="{{route('events.update',['events' => $event->id])}}" enctype="multipart/form-data" style=" width:90% ">
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
                                             <label for="location">Location</label>
                                             <input type="text" value="{{ $event->location }}" id="location" name="location" class="form-control map-input">
                                             <input type="hidden" name="location_lat" id="location_lat" value="0" />
                                             <input type="hidden" name="location_lang" id="location_lang" value="0" />
                                         </div>
                                         <div id="address-map-container" style="width:100%;height:400px; ">
                                             <div style="width: 100%; height: 100%" id="address-map"></div>
                                         </div>

                                         <div class="form-group">
                                             <label for="start_date">Start date</label>
                                             <div class='input-group date' id='datetimepicker1'>
                                                 <input id="start_date" value="{{ $event->start_date }}" type="text" class="date form-control" name="start_date">
                                                 <span class="input-group-addon">
                                                     <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                             </div>
                                         </div>

                                         <div class="form-group">
                                             <label for="end_date">End date</label>
                                             <div class='input-group date' id='datetimepicker1'>
                                                 <input name="end_date" value="{{ $event->end_date }}" type='text' class="date form-control" />
                                                 <span class="input-group-addon">
                                                     <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                             </div>
                                         </div>
                                         <br>
                                         <div class="form-group mb-0"></div>
                                         <button type="submit" class="btn btn-sm btn-primary pull-right m-t-n-xs" style="width: 100px;">
                                             Submit
                                         </button>

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
         <script src="/js/mapInput.js"></script>

         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
         <script type="text/javascript">
             $('.date').datepicker({
                 format: 'mm-dd-yyyy',
                 startDate: new Date()
             });
         </script>
         @endsection


         @section('fileZoneScript')
         <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
         <script>
             var uploadedDocumentMap = {}
             Dropzone.autoDiscover = false;
             let dropzone = new Dropzone('#document-dropzone', {
                 url: '{{ route('news.storeFiles ') }}',
                 maxFilesize: 1, // MB
                 acceptedFiles: ".jpg,.png,.pdf,.xlsx",
                 addRemoveLinks: true,
                 headers: {
                     'X-CSRF-TOKEN': "{{ csrf_token() }}"
                 },
                 init: function() {
                     var newsId = {
                         !!$news - > id!!
                     };
                     var thisDropzone = this;
                     $.ajax({
                         type: "GET",
                         url: '{{ route('
                         news.getFiles ') }}?id=' + newsId,
                         success: function(res) {
                             console.log(res);
                             if (res) {
                                 $.each(res, function(key, value) {
                                     // var mockFile = { name: value , size: value.size};
                                     var mockFile = {
                                         name: value,
                                         size: 12345
                                     };
                                     thisDropzone.emit("addedfile", mockFile);
                                     thisDropzone.emit("thumbnail", mockFile, "/uploads/news/" + mockFile.name);
                                     thisDropzone.emit("complete", mockFile);
                                 });
                             }
                         }
                     });

                 },
                 success: function(file, response) {
                     console.log(response.fileId);
                     $('form').append('<input type="hidden" name="document[]" value="' + response.fileId + '">')
                     uploadedDocumentMap[file.name] = response.fileId
                 },
                 removedfile: function(file) {
                     file.previewElement.remove()
                     $.post({
                         url: '{{ route('news.removeFile ') }}',
                         data: {
                             name: file.name,
                             _token: $('[name="_token"]').val()
                         },
                         dataType: 'json',
                         success: function(data) {
                             console.log("deleted successfully")
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
         </script>
         @stop

         @section('validation')
         {!! JsValidator::formRequest('App\Http\Requests\StoreNewsRequest') !!}
         @endsection