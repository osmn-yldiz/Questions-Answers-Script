@extends('layouts.app')
@section("header")
    <link rel="stylesheet" href="{{ asset("plugins/tokenfield/css/bootstrap-tokenfield.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/tokenfield/css/tokenfield-typeahead.css") }}">
@endsection
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <ul class="list-unstyled">
                    <li class="media">
                        <img class="mr-3" src="{{ \App\Models\User::getPhoto($data[0]['userId']) }}"
                             alt="{{ $data[0]['title'] }}">
                        <div class="media-body">
                            <div class="title">
                                <a href="" class="mt-0">{{ $data[0]['title'] }}</a>
                                @foreach(\App\Models\QuestionsCategory::getCategoryList($data[0]['id']) as $k => $v)
                                    <span class="category--item">{{ $v['name'] }}</span>
                                @endforeach
                            </div>
                            <div class="description">
                                {!! $data[0]['text'] !!}
                            </div>
                            <div class="detail">
                                <a href="">
                                    {{ \App\Models\Comments::getCount($data[0]['id']) }} Yorum</a>
                                - <a href="">{{ \App\Models\Visitor::getCount($data[0]['id']) }} Görüntülenme</a>
                                - {{ \App\Helper\mHelper::time_ago($data[0]['created_at']) }}

                                - <a href="{{ route('save.store',['id'=>$data[0]['id']]) }}">
                                    @if(\App\Models\SaveQuestion::isSave($data[0]['id']))
                                        Soruyu Kayıttan Çıkar
                                    @else
                                        Soruyu kaydet
                                    @endif
                                </a>


                                @if(Auth::id() == $data[0]['userId'])
                                    - <a href="{{ route('question.edit',['id'=>$data[0]['id']]) }}"><i
                                            class="fa fa-edit"></i></a> - <a
                                        href="{{ route('question.delete',['id'=>$data[0]['id']]) }}"><i
                                            class="fa fa-trash"></i></a>
                                @endif
                            </div>

                        </div>
                    </li>


                    <div class="category--list">
                        @foreach(\App\Models\QuestionsTags::where('questionId',$data[0]['id'])->get() as $k => $v)
                            <a href="#">{{ $v['name'] }}</a>
                        @endforeach
                    </div>

                </ul>

                <h3>CEVAPLAR</h3>
                @if(\App\Models\Comments::getCount($data[0]['id'])!=0)
                    <ul class="list-unstyled">
                        @foreach($comments as $k => $v)
                            <li class="media">
                                <img class="mr-3" src="{{ \App\Models\User::getPhoto($v['userId']) }}"
                                     alt="Generic placeholder image">
                                <div class="media-body">
                                    <div class="title">
                                        <a class="mt-0">{{ \App\Models\User::getName($v['userId']) }}</a>
                                        - {{ \App\Helper\mHelper::time_ago($v['created_at']) }}
                                        @if($v['isCorrect'] == 1)
                                            <span class="isCorrect">Doğru Cevap</span>
                                        @endif

                                    </div>
                                    <div class="description">
                                        {!! $v['text'] !!}
                                    </div>
                                    <div class="detail">
                                        @if($v['userId'] != \Illuminate\Support\Facades\Auth::id())
                                            <a href="{{ route('comment.likeordislike',['id'=>$v['id']]) }}">Begen
                                                ({{ \App\Models\LikeComment::getCount($v['id']) }}) </a>
                                        @else
                                            <a href="{{ route('comment.delete',['id'=>$v['id']]) }}"><i
                                                    class="fas fa-pen"></i></a>
                                        @endif

                                        @if(\Illuminate\Support\Facades\Auth::id() == $data[0]['userId'] and \App\Models\Comments::isCorrectVariable($data[0]['id']) == 0)
                                            - <a href="{{ route('comment.correct',['id'=>$v['id']]) }}"><i
                                                    class="fa fa-check"></i></a>
                                        @endif
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info">Henüz Cevap yazılmamış , ilk sen olmalısın !</div>
                @endif


                @if(session("status"))
                    <div class="alert alert-success">{{ session("status") }}</div>
                @endif
                <div class="card">
                    <div class="card-header">Cevap Yaz</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('comment.store',['id'=>$data[0]['id']]) }}">
                            @csrf


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Cevabınız</label>
                                    <textarea required name="text" id="question--area" class="form-control" cols="30"
                                              rows="10"></textarea>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Cevabı Gönder
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

            <div class="col-md-4">

                <div class="team-card-style-3 mx-auto" style="margin-bottom: 20px;">
                    <div class="team-thumb"><img src="{{ \App\Models\User::getPhoto($data[0]['userId']) }}"
                                                 alt="{{ \App\Models\User::getName($data[0]['userId']) }}">
                    </div>
                    <a href="{{ route('user.index',['id'=>$data[0]['userId']]) }}"
                       class="team-name">{{ \App\Models\User::getName($data[0]['userId']) }}</a>
                    <span class="team-contact-link">
                     <i class="fe-icon-phone"></i>&nbsp; Toplam {{ \App\Models\Questions::where('userId',$data[0]['userId'])->count() }} Soru Soruldu.
                 </span>
                    <span class="team-contact-link">
                     <i class="fe-icon-mail"></i>&nbsp; Toplam {{ \App\Models\Comments::where('userId',$data[0]['userId'])->count() }} Cevap Verildi.
                 </span>
                    <div class="team-social-bar-wrap">
                        <div class="team-social-bar">
                            <a class="social-btn sb-style-1 sb-twitter" href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-github" href="#">
                                <i class="fa fa-github"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-stackoverflow" href="#">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-skype" href="#">
                                <i class="fa fa-skype"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <h3>Benzer Sorular</h3>
                <ul class="list-group">
                    @foreach(\App\Models\Questions::likeQuestions($data[0]['id']) as $k => $v)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('view',['id'=>$v['id'],'selflink'=>$v['selflink']]) }}">{{ $v['title'] }}</a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>


    </div>
@endsection

@section('footer')
    <script src="{{asset("plugins/tokenfield/bootstrap-tokenfield.js")}}"></script>
    <script src="{{asset("plugins/textboxio/textboxio.js")}}"></script>
    <script>
        $('#tokenfield').tokenfield();
        var editor = textboxio.replace('#question--area');
    </script>
@endsection
