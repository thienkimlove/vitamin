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
                <br/>
				
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '253971681611024',
      xfbml      : true,
      version    : 'v2.6'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
							<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src =   "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=253971681611024";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="fb-root"></div>

                <div class="boxLike">
                    <div class="addthis_native_toolbox"></div>
                </div>
                <div>
                 <!-- //listButton -->
                <ul class="listButton clearFix">
                    <li class="ilocal"><a href="{{url('phan-phoi')}}">Xem điểm bán C Nattu</a></li>
                    <li class="icall"><a href="{{url('lien-he')}}">18001190 - 0912 571 190</a></li>
                </ul>
				</div>
				<br />
				
				<div class="boxComment">
                    <div class="fb-comments" data-href="{{url($post->slug.'.html')}}" data-numposts="5"></div>
                </div>
				
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
                                <a href="{{url($latestNew->slug.'.html')}}">{{$latestNew->title}}</a>
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
