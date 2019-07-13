<section class="menuIcon">
    <div class="listIcons">
        <ul>
            <li>
                <a href="#" class="iSearch">Search</a>
                <div class="box-find" id="box-find">
                    <form>
                        <input type="text" placeholder="Từ khóa tìm kiếm" name="keyword" class="txt"/>
                        <input type="submit" value="" name="submit" class="btn-find"/>
                    </form>
                </div>
            </li>
            <li><a href="#" class="iYou">Youtube</a></li>
            <li><a href="#" class="iSkype">Skype</a></li>
            <li><a href="#" class="iGoogle">Google</a></li>
        </ul>
    </div>
</section>
<div class="hotLine sp">
    <img src="{{url('frontend/imgs/hot.png')}}" alt="Hot">
</div>
	<meta property="fb:app_id" content="253971681611024" />
	<meta property="fb:admins" content="{1704641110}"/>
	<meta content='253971681611024' property='fb:app_id'/>
<header class="header">
    <div class="container">
        <h1 class="clearFix">
            <a href="http://www.cnattu.vn" class="logo" title="Logo">
                <img src="{{url('frontend/imgs/logo.png')}}" alt="Vitamin C" width="225" height="125" class="pc">
                <img src="{{url('frontend/imgs/logosp.png')}}" alt="Vitamin C" width="295" height="100" class="sp">
            </a>
        </h1>
        <ul id="globalNav" class="pc">
            <li><a href="{{url('http://www.cnattu.vn')}}" class="active">Trang chủ</a></li>
            @if ($menuProducts->count() > 0)
            <li>
                <a href="http://www.cnattu.vn/product/cnattu-kid">Vitamin C Tự nhiên</a>
                <ul>
                    @foreach ($menuProducts as $product)
                    <li><a href="{{url('product/'.$product->slug)}}">{{$product->title}}</a></li>
                    @endforeach
                </ul>
            </li>
            @endif
            @if ($headerCategories->count() > 0)
                @foreach ($headerCategories as $headerCategory)
                    <li>
                        <a href="{{url($headerCategory->slug)}}">{{$headerCategory->name}}</a>
                        @if ($headerCategory->subCategories->count() > 0)
                            <ul>
                                @foreach ($headerCategory->subCategories as $childCategory)
                                    <li><a href="{{url($childCategory->slug)}}">{{$childCategory->name}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif


            <li><a href="{{url('video')}}">Videos</a></li>
            <li><a href="{{url('cau-hoi-thuong-gap')}}">Hỏi đáp</a></li>
            <li><a href="{{url('lien-he')}}">Liên hệ</a></li>
            <li><a href="{{url('phan-phoi')}}">Phân phối</a></li>
        </ul>
        <a href="#" title="Menu" class="sp btnMenu" id="btnMenu">Menu</a>
    </div>
</header>

@if (isset($page) && $page == 'index')
<!-- /endHeader -->
<section class="boxBanner">
    <div class="boxSlider">
        <div class="owl-carousel" id="slideIndex">
           @foreach ($headerIndexBanners as $banner)
            <div class="item">
                <a class="thumb" href="{{$banner->url}}" title="">
                    <img src="{{url('files/'.$banner->image)}}"/>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <!--//box-Banner-->
</section>
@else
    <section class="boxBanner">
        <div class="boxSlider">
            <div class="owl-carousel" id="slideHomepage">
                @foreach ($headerNotIndexBanners as $banner)
                    <div class="item">
                        <a class="thumb" href="{{$banner->url}}" title="">
                            <img src="{{url('files/'.$banner->image)}}"/>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!--//box-Banner-->
    </section>
@endif