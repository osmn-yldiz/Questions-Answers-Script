@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Kaydedilmiş Sorular</div>

                    <div class="card-body">

                        @foreach($data as $k => $v)
                            <li class="list-group-item">
                                <a href="{{ route('view',['id'=>$v['questionId'],'selflink'=>\App\Models\Questions::getSelflink($v['questionId'])]) }}"> {{ \App\Models\Questions::getTitle($v['questionId']) }}</a>
                            </li>
                        @endforeach

                    </div>
                </div>
                {!! $data->links() !!}
            </div>

            <div class="col-md-4">
                @include('sidebar.settings')
            </div>
        </div>


    </div>
@endsection
