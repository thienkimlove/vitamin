@extends('frontend')

@section('content')
    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">{{$post->category->name}}</li>
                </ul>
                <div class="boxDetails">
                    <div class="headBox">
                        <h3 class="titleBox">{{$post->title}}</h3>
                          <span class="datePost">
                            Ngày đăng: {{$post->updated_at->format('d/m/Y')}}
                          </span>
                          <span class="view">
                            Lượt xem: {{$post->views}}
                          </span>
                    </div>
                   {!! $post->content !!}
                </div>

                <div class="addthis_native_toolbox"></div>
                <div class="boxOrther">
                    <h3 class="globalTitle">
                        <a href="#">Tin liên quan</a>
                    </h3>
                    <ul class="listQuestion" id="listQuestion">
                        @foreach ($relatedPosts as $relatedPost)
                          <li><a href="{{url($relatedPost->slug.'.html')}}">{{$relatedPost->title}}</a></li>
                        @endforeach

                        @if ($additionPosts)
                                @foreach ($additionPosts as $additionPost)
                                    <li><a href="{{url($additionPost->slug.'.html')}}">{{$additionPost->title}}</a></li>
                                @endforeach
                        @endif
                    </ul>
                </div>
                @foreach ($postBanners as $banner)
                <div class="boxAdv">
                    <a href="{{$banner->url}}" title="adv">
                        <img src="{{url('files/'.$banner->image)}}" alt="ADV">
                    </a>
                </div>
                @endforeach
                <div class="boxNews">
                    <h3 class="globalTitle"><a href="#">Tin mới nhất</a></h3>
                    <div class="listNews clearFix">
                        @foreach ($latestNews as $latestNew)
                         <div class="item">
                            <a href="{{url($latestNew->slug.'.html')}}" class="thumb">
                                <img src="{{url('img/cache/188x125/'.$latestNew->image)}}" alt="List news">
                            </a>
                            <p>
                                {{$latestNew->title}}
                            </p>
                            <span class="datePost">{{$latestNew->updated_at->format('d/m/Y')}}</span>
                            <span class="countView">{{$latestNew->views}} lượt xem</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('frontend.right')
        </div>
    </section>
@endsection