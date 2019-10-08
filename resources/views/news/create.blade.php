@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
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
                                                <option>-- Select --</option>
                                                <option value="news">News</option>
                                                <option value="article">Article</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <select id="author" name="author"></select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editor-content">Content</label>
                                            <textarea id="editor-content" name="editor-content">&lt;p&gt;Initial editor content.&lt;/p&gt;</textarea>
                                        </div>
                                        <!-- <div class="form-group">
                                            <input type="file" class="form-control" name="images[]" placeholder="image" multiple>
                                        </div> -->
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="files[]" placeholder="file" multiple>
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
                                $("#author").append('<option>Select</option>');
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
            CKEDITOR.replace('editor-content');
        </script>
        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

        {!! JsValidator::formRequest('App\Http\Requests\StoreVisitorRequest') !!}
        @endsection