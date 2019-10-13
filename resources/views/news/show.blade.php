@extends('layouts.admin')
@section('content')
<div style="text-align:center">
<div class="card" style="width:500px; margin:auto; margin-top:30px">
  <div class="card-header" style="background-color: #ddd;height: 40px;padding-top: 10px;">
  {{ $news->main_title }}
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
        {{ $news->secondary_title }}
    </li>
    <li class="list-group-item">
        <h4 style="color:gray">content<h4>
       <p>{{ $news->content }}</p>
    </li>
    <li class="list-group-item"> <a href="{{route('news.index')}}" class="btn btn-info">Back</a></li>
  </ul>
</div>

<!-- <embed src="" style="width:600px; height:800px;" frameborder="0"> -->

<br><br>
<!-- Grid row -->
<div class="row">

    <!-- Grid column -->
    <div class="col-md-12 d-flex justify-content-center mb-5">

        <!-- <button type="button" class="btn btn-outline-black waves-effect filter" data-rel="all">All</button> -->
        <button type="button" class="btn btn-outline-black waves-effect filter" data-rel="1">Images</button>
        <button type="button" class="btn btn-outline-black waves-effect filter" data-rel="2">Files</button>

    </div>
    <!-- Grid column -->

</div>
<!-- Grid row -->
<br><br>
<!-- Grid row -->
<div class="gallery" id="gallery">
    @if ($images)
    @foreach($images as $image)
    <!-- Grid column -->
    <div class="mb-3 pics animation 1">
        <img class="img-fluid img-responsive" src="<?php echo asset("/uploads/news/$image") ?>" width="400px" height="400px" alt="Card image cap">
    </div>
    @endforeach
    @endif

    <!-- Grid column -->
    @if ($files)
    @foreach($files as $file)
    <div class="mb-3 pics animation 2">
        <h2>test</h2>
        <embed  src="<?php echo asset("/uploads/news/$file") ?>"  style="width:400px; height:800px;" frameborder="0">
    </div>
    @endforeach
    @endif



</div>
<!-- Grid row -->
</div>
@endsection

@section('script')

<script>
    $(function() {
        var selectedClass = "";
        $(".filter").click(function() {
            selectedClass = $(this).attr("data-rel");
            $("#gallery").fadeTo(100, 0.1);
            $("#gallery div").not("." + selectedClass).fadeOut().removeClass('animation');
            setTimeout(function() {
                $("." + selectedClass).fadeIn().addClass('animation');
                $("#gallery").fadeTo(300, 1);
            }, 300);
        });
    });
</script>

@endsection