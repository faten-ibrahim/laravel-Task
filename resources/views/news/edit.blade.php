 
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Job</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" method="POST" action="{{route('news.update',['news' => $news->id])}}" enctype="multipart/form-data" style=" width:90% ">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="main_title">Main Title</label>
                                            <input name="main_title" value="{{ $news->main_title }}" id="main_title" type="text" class="form-control" required autocomplete="main_title" autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="secondary_title">Secondary Title</label>
                                            <input name="secondary_title" value="{{ $news->secondary_title }}" id="secondary_title" type="text" class="form-control" autocomplete="secondary_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select id="type" type="text" class="form-control" name="type">
                                                <option value="">-- Select --</option>
                                                <option {{ ($news->type == "news" ? "selected":"") }} value="news">News</option>
                                                <option {{ ($news->type == "article" ? "selected":"") }} value="article">Article</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <select class="form-control" id="author" name="staff_member_id">
                                                <option value="">-- Select --</option>
                                                @foreach($staff as $key => $staffMember)
                                                <option value="{{$key}}" {{ ($news->staff_member_id == $key ? "selected":"") }}> {{$staffMember}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea name="content" id="content">{{$news->content}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <!-- <label for="content">Content</label> -->
                                            <select name="related[]" class="chosen-select" multiple data-placeholder="Choose a News...">
                                                @foreach($News as $key => $new)
                                                <option class="option" value="{{$key}}" {{ (in_array($key, $related) ? "selected":"") }}> {{$new}}</option>
                                                @endforeach
                                            </select>
                                            <span id="hint" style="color:red;"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="document">Upload</label>
                                            <div class="needsclick dropzone" id="document-dropzone">
                                                @if ("{{ $files }}")
                                                @foreach($files as $key => $file)
                                                <input type="hidden" name="document[]" value="{{$file}} .$. {{$key}}" />
                                                @endforeach
                                                @endif
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
        <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('content');
            $('.chosen-select').chosen();
            var limit = 9;
            $("#hint").hide();
            $('.chosen-select').on('change', function(evt) {
                var numItems = $('.result-selected').length;
                if (numItems >= limit) {
                    $("#hint").show().text("maximum selections will be stored are 10");
                    // does not work
                    $("option[class='active-result']").attr("disabled", "disabled");
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
                url: '{{ route('news.storeFiles') }}',
                maxFilesize: 1, // MB
                acceptedFiles: ".jpg,.png,.pdf,.xlsx",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '$' + response.mimeType + '">')
                    uploadedDocumentMap[file.name] = response.name
                },
                removedfile: function(file) {
                    file.previewElement.remove()
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
        
       