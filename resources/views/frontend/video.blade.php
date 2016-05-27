@extends('frontend')

@section('content')
    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">Video</li>
                </ul>
                <div class="boxMedia">
                    <h3 class="globalTitle">
                        <a href="#">Video</a>
                    </h3>
                    @if ($mainVideo)
                    <div class="hotVideo clearFix">
                        <div class="thumbVideo">
                            <iframe width="100%" height="315" src="{{$mainVideo->url}}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif
                    @foreach ($videos as $video)
                        <article class="item">
                            <a class="thumb" href="{{url('video/'.$video->slug)}}" title="{{$video->title}}">
                                <img src="{{url('img/cache/303x130/'.$video->image)}}" width="257" height="169" alt=""/>
                            </a>
                            <h3>
                                <a href="{{url('video/'.$video->slug)}}" title="{{$video->title}}">{{$video->title}}</a>
                            </h3>
                            <span class="view">{{$video->views}} lượt xem</span>
                        </article>
                    @endforeach
                    <!-- /paging -->
                    <div class="boxPaging">
                        @include('pagination.default', ['paginate' => $videos])
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div><!--//box-media-->
                <!-- /endboxNews -->
            </div>
            @include('frontend.right')
        </div>
    </section>
@endsection