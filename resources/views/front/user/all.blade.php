@extends('layouts.app')
@section('content')
    <section class="container py-5">
        <h2 class="h4 block-title text-center mt-2">Tüm Kullanıcılar</h2>
        <div class="row pt-3">
        @foreach($data as $k => $v)
            <!-- Author-->
                <div class="col-lg-3 col-sm-6 mb-30 pb-2">
                    <div class="team-card-style-3 mx-auto">
                        <div class="team-thumb"><img src="{{ \App\Models\User::getPhoto($v['id']) }}" alt="Author Picture">
                        </div>
                        <a href="{{route('user.index',['id'=>$v['id']])}}" class="team-name">{{$v['first_name']}} {{ $v['last_name'] }}</a>

                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
