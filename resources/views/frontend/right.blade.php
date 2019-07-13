<div class="contentRight">
    <div class="boxVideo">
        <h3 class="globalTitle">
            <a href="http://www.cnattu.vn/video">Góc Video</a>
        </h3>
        @if ($featureVideos->count() > 0)
            <div class="content">
                <iframe width="100%" height="250" src="{{$featureVideos->first()->url}}" frameborder="0" allowfullscreen></iframe>
                <ul class="listVideo">
                    @foreach ($featureVideos as $video)
                        <li><a href="{{url('video/'.$video->slug)}}">{{$video->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="boxSale">
        <h3 class="globalTitle">
            <a href="#">Cộng đồng mẹ thông thái</a>
        </h3>
        <div class="Social">
            <div class="fb-page" data-href="https://www.facebook.com/cnattu.vn" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/cnattu.vn"><a href="https://www.facebook.com/cnattu.vn">Cnattu Kids</a></blockquote></div></div>
        </div>
    </div>
    <!-- /endSale -->
    <div class="boxHot clearFix" id="sidebar">
        <h3 class="globalTitle"><a href="#">Tin nổi bật</a></h3>
        @if (isset($page) && $page == 'index')
            @foreach ($featureNews->splice(0, 2) as $post)
                <div class="item clearFix">
                    <a href="{{url($post->slug.'.html')}}" class="thumb">
                        <img src="{{url('img/cache/100x80/'.$post->image)}}" alt="hot" width="100" height="80">
                    </a>
                    <h4>
                        <a href="{{url($post->slug.'.html')}}">{{$post->title}}</a>
                    </h4>
                </div>
            @endforeach
        @else
            @foreach ($featureNews as $post)
                <div class="item clearFix">
                    <a href="{{url($post->slug.'.html')}}" class="thumb">
                        <img src="{{url('img/cache/100x80/'.$post->image)}}" alt="hot" width="100" height="80">
                    </a>
                    <h4>
                        <a href="{{url($post->slug.'.html')}}">{{$post->title}}</a>
                    </h4>
                </div>
            @endforeach
        @endif

    </div>
    <!-- /endHot -->
</div>