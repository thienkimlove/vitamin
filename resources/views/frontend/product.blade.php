@extends('frontend')

@section('content')
    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">{{$mainProduct->title}}</li>
                </ul>
                <div class="boxProducts">
                    <ul class="proTabs clearFix">
                        <li class="tabLink active" data-tab="tabInfo">Thông tin sản phẩm</li>
                        <li class="tabLink" data-tab="tabChoose">Nghiên cứu lâm sàng</li>
                        <li class="tabLink" data-tab="tabRate">Người thật việc thật</li>
                    </ul>
                    <div id="tabInfo" class="tabProduct active">
                        <div class="item clearFix">
                            {!! $mainProduct->content_tab1 !!}
                        </div>

                        <div class="boxTags">
                            <span>Từ khóa</span>
                            @foreach ($mainProduct->tags as $tag)
                              <a href="{{url('tag/'.$tag->slug)}}" title="{{$tag->name}}">{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <!-- endTab01 -->
                    <div id="tabChoose" class="tabProduct">
                        <div class="item clearFix">
                           {!! $mainProduct->content_tab2 !!}
                        </div>
                    </div>
                    <!-- /endTab02 -->
                    <div id="tabRate" class="tabProduct">
                        <div class="item clearFix">
                            {!! $mainProduct->content_tab3 !!}
                        </div>
                    </div>
                    <!-- /endTab03 -->
                </div>

                <div class="boxLike">
                    <div class="addthis_native_toolbox"></div>
                </div>
                <div>
                 <!-- //listButton -->
                <ul class="listButton clearFix">
                    <li class="ilocal"><a href="{{url('phan-phoi')}}">Xem điểm bán C Nattu</a></li>
                    <li class="icall"><a href="{{url('lien-he')}}">1900 6482 - 0912 571 190</a></li>
                </ul>
				</div>
				<br />

                <div class="boxOrther">
                    <h3 class="globalTitle">
                        <a href="#">Tin liên quan</a>
                    </h3>
                    <ul class="listQuestion" id="listQuestion">
                        @foreach ($related as $post)
                          <li><a href="{{url($post->slug.'.html')}}">{{$post->title}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="boxComment">
                    <div class="fb-comments" data-href="{{url('product/'.$mainProduct->slug)}}" data-numposts="5"></div>
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
                        @foreach ($latestNews as $post)
                          <div class="item">
                            <a href="{{url($post->slug.'.html')}}" class="thumb">
                                <img src="{{url('img/cache/188x125/'.$post->image)}}" alt="List news">
                            </a>
                            <p>
                               <a href="{{url($post->slug.'.html')}}">{{$post->title}}</a>
                            </p>
                            <span class="datePost">{{$post->updated_at->format('m/d/Y')}}</span>
                            <span class="countView">{{$post->views}} lượt xem</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('frontend.right')
        </div>
    </section>
@endsection