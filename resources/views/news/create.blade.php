@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create News</h5>
                        </div>

                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data" style=" width:90% ">
                                        @csrf
                                        <div class="form-group">
                                            <label for="main_title">Main Title</label>
                                            <input id="main_title" type="text" class="form-control" name="main_title" required autocomplete="main_title" autofocus>
                                        </div>


                                        <div class="form-group">
                                            <label for="secondary_title">Secondary Title</label>
                                            <input id="secondary_title" type="text" class="form-control" name="secondary_title" autocomplete="secondary_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select id="type" type="text" class="form-control" name="type">
                                                <option value="">-- Select --</option>
                                                <option value="news">News</option>
                                                <option value="article">Article</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <select class="form-control" id="author" name="staff_member_id">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea id="content" name="content"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <!-- <label for="content">Content</label> -->
                                            <select id="mySelect2" name="related[]" class="chosen-select" multiple data-placeholder="Choose a News...">

                                            </select>

                                            <span id="hint" style="color:red;"></span>
                                        </div>





                                        <!-- <div class="form-group">
                                            <input type="file" class="form-control" name="files[]" placeholder="image" multiple>
                                        </div> -->


                                        <div class="form-group">
                                            <label for="document">Upload</label>
                                            <div class="needsclick dropzone" id="document-dropzone">
                                            </div>
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
       
        <script type="text/javascript">
            $('#type').change(function() {
                var selectedType = $(this).val();
                if (selectedType) {
                    // alert(selectedType);
                    $.ajax({
                        type: "GET",
                        url: "{{url('get-author-list')}}?type=" + selectedType,
                        success: function(res) {
                            if (res) {
                                $("#author").empty();
                                $("#author").append('<option>--Select--</option>');
                                $.each(res, function(key, value) {
                                    $("#author").append('<option value="' + key + '">' + value + '</option>');
                                });

                            } else {
                                $("#author").empty();
                            }
                        }
                    });
                } else {
                    $("#author").empty();
                }
            });
           
        </script>
        <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>
        <script>   
            ClassicEditor
                    .create( document.querySelector('#content') )    
                    .catch( error => {
                        console.error( error );
                    } );
        </script>
        <script>
            $('#mySelect2').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{url('get-news-list')}}',
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

            var limit = 9;
            $("#hint").hide();
            $('#mySelect2').on('change', function(evt) {
                var numItems = $('#mySelect2').length;
                if (numItems >= limit) {
                    $("#hint").show().text("maximum selections will be stored are 10");
                } else {
                    $("#hint").hide();
                }
            });
        </script>

        @endsection

        @section('fileZoneScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script>
            var uploadedDocumentMap = {}
            Dropzone.autoDiscover = false;
            let dropzone = new Dropzone('#document-dropzone', {
                url: '{{ route('files.storeFiles') }}',
                maxFilesize: 1, // MB
                acceptedFiles: ".jpg,.png,.pdf,.xlsx",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.fileId + '">')
                    uploadedDocumentMap[file.name] = response.fileId
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    $.post({
                        url: '{{ route('files.removeFile') }}',
                        data: 
                        {
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
        </script>
        @stop


        @section('validation')
        {!! JsValidator::formRequest('App\Http\Requests\StoreNewsRequest') !!}
        @endsection