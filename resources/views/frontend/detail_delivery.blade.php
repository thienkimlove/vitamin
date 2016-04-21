@extends('frontend')

@section('content')

    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li><a href="{{url('phan-phoi')}}">Phân phối</a></li>
                    <li class="active">Phân phối chi tiết</li>
                </ul>
                <div class="boxDetails">
                    <div class="headBox">
                        <h3 class="titleBox">Hệ thống phân phối của CKids tại {{config('delivery')['city'][$delivery->city]}}</h3>
                    </div>

                    {!! $delivery->content !!}

                </div>

            </div>
            @include('frontend.right')
        </div>
    </section>

@endsection