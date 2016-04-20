@extends('frontend')

@section('content')

    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">{{$category->name}}</li>
                </ul>
                <div class="boxNews clearFix">
                    <h3 class="globalTitle">
                        <a href="#">{{$category->name}}</a>
                    </h3>
                    <div class="topNews clearFix">
                        <a href="{{url($featurePost->slug.'.html')}}" class="thumb">
                            <img src="{{url('img/cache/400x289/'.$featurePost->image)}}" alt="">
                        </a>
                        <h3>
                            <a href="{{url($featurePost->slug.'.html')}}">{{$featurePost->title}}</a>
                        </h3>
                        <p>
                            {{$featurePost->desc}}
                        </p>
                    </div>
                    <div class="listNews fullWidth">
                        @foreach ($posts as $post)
                          <div class="item clearFix">
                            <a href="#" class="thumb">
                                <img src="{{url('img/cache/320x180/'.$post->image)}}" alt="List news" width="320" height="180">
                            </a>
                            <h3><a href="{{url($post->slug.'.html')}}">{{$post->title}}</a></h3>
                            <span class="date">{{$post->updated_at->format('d/m/Y')}}</span> | <span class="tag">{{implode(',', $post->tags->lists('name')->all())}}</span>
                            <p>
                              {{$post->desc}}
                            </p>
                            <a href="{{url($post->slug.'.html')}}" class="readMore">Chi tiết</a>
                        </div>
                        @endforeach
                        <!-- /paging -->
                            <div class="boxPaging">
                                @include('pagination.default', ['paginate' => $posts])
                                <div class="clear"></div>
                            </div>
                    </div>
                </div>
                <!-- /endboxNews -->
            </div>
            @include('frontend.right')
        </div>
    </section>

@endsection
