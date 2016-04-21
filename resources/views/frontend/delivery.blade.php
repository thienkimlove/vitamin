@extends('frontend')

@section('content')

    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">Hệ thống phân phối</li>
                </ul>
                <div class="boxContact">
                    <div class="boxDist">
                        <h3 class="globalTitle">
                            <a href="#">Hệ thống phân phối</a>
                        </h3>

                       @foreach ($totalDeliveries as $area => $cities)
                        <div class="data clearFix">
                            <h3>{{$area}}</h3>
                            @foreach ($cities->chunk(6) as $partCities)
                            <div class="item">
                                @foreach ($partCities as $city)
                                  <a href="{{url('phan-phoi/'. $city->id)}}" title="">{{config('delivery')['city'][$city->city]}}</a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    <!-- /endboxDist -->
                </div>
            </div>
            @include('frontend.right')
        </div>
    </section>

@endsection