@extends('frontend')

@section('content')
    <section class="section vis">
        <div class="container">
            <div class="contentLeft">
                <ul class="breadCrumb clearFix">
                    <li><a href="{{url('/')}}">Trang chủ</a></li>
                    <li class="active">Câu hỏi thường gặp</li>
                </ul>
                <div class="boxQuestion">
                    <h3 class="globalTitle">
                        <a href="#">Góc chuyên gia</a>
                    </h3>
                    @if ($mainQuestion)
                    <div class="headQuestion clearFix">
                        <a href="{{url('cau-hoi-thuong-gap/'.$mainQuestion->slug)}}" class="thumb">
                            <img src="{{url('frontend/imgs/bg/avatar.png')}}" alt="">
                        </a>
                        <p>
                            {{$mainQuestion->question}}
                        </p>
                        <p>
                            Độc giả có thể gửi câu hỏi trực tiếp vào bảng đặt câu hỏi dưới đây, hoặc gửi trực tiếp vào Email:
                            <a href="#">tuvansuckhoe.bsdinh@gmail.com</a>
                            <a href="#">tuvanbigbb@gmail.com</a>
                        </p>
                    </div>
                    @endif
                    <div class="boxForm">
                        <h3>Gửi Câu hỏi</h3>
                        <div class="boxConsult clearFix">
                            {!! Form::open(array('url' => 'save_question', 'class' => 'formConsult')) !!}
                                <input type="text" name="ask_person" placeholder="* Họ và tên bố (mẹ)" class="txt txtName">
                                <input type="text" name="ask_phone" placeholder="* Điện thoại liên hệ" class="txt txtMob">
                                <input type="text" name="ask_email"  placeholder="* Email" class="txt txtMob">
                                <input type="text" name="ask_address" placeholder="* Địa chỉ liên hệ" class="txt txtMob">
                                <input type="text" name="title" placeholder="* Tiêu đề hỏi đáp" class="txt txtName">
                                <textarea name="question" class="txt txtArea" placeholder="* Nội dung"></textarea>
                                <input type="reset" value="Hủy" class="btnReset">
                                <input type="submit" value="Gửi đi" class="btnSubmit">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- //listQuestion -->
                    @foreach ($questions as $number => $question)
                    <article class="item{{ ($number % 2 == 0)? ' bg' : '' }}">
                        <h3 class="title-faq"><span>1</span>{{$question->title}}</h3>
                        <div class="content">
                            <p>
                                <span class="question">Câu hỏi:</span>
                                <span>{{$question->question}}</span>
                            </p>
                            <time class="time" datetime="{{$question->updated_at->format('d/m/Y')}}">{{$question->updated_at->format('d/m/Y')}}</time>
                        </div>
                        <div id="accordion">
                            <a href="javascript:void(0)" class="answer">Xem trả lời</a>
                            <div class="accordion">
                                <div class="content">
                                    <p>{{$question->answer}}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach

                    <div class="boxPaging">
                        @include('pagination.default', ['paginate' => $questions])
                        <div class="clear"></div>
                    </div>
                </div>
                <!-- /endboxNews -->
            </div>
           @include('frontend.right')
        </div>
    </section>
@endsection