@extends('layouts.admin')
@section('content')
<div class="new-product">
    <div class="col-md-5 zoom-grid">
        <div class="flexslider">
            <ul class="slides">

                <img src="<?php echo asset("/uploads/visitors/$image_name") ?>" width="100px" height="100px" />

                @if ("{{ $files }}")
                @foreach( $news->files as $ph)
                @if()
                <li>
                    <div class="image">
                        <img src="{{ $ph->name }}" class="img-responsive" alt="" />
                    </div>
                </li>
                @endforeach
                @endif

                <li>
                    <div class='col-sm-8'>
                        {{ $document }}

                        <embed src="{{ Storage::url($document->file_path) }}" style="width:600px; height:800px;" frameborder="0">
                </li>
        </div>
        </ul>
    </div>
</div>
<div class="col-md-7 dress-info">
    <div class="dress-name">
        <h3>{{ $news->main_title }}</h3>
        <h3>{{ $news->secondary_title }}</h3>
        <div class="clearfix"></div>
        <p>{{ $news->content }}</p>
    </div>


</div>
</div>

@endsection