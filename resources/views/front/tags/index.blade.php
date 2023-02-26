@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                @if(session("status"))
                    <div class="alert alert-info">{{ session("status") }}</div>
                @endif
                <div class="card">
                    <div class="card-header">Etiketler ({{ count($data) }})</div>

                    <div class="card-body">

                        @foreach($data as $k => $v)
                            <li class="list-group-item">
                                <a href="{{route('tags.view',['selflink'=>$v['selflink']])}}">
                                    {{$v['name']}}
                                </a>
                            </li>
                        @endforeach

                    </div>
                </div>
                {!! $data->links() !!}
            </div>

        </div>
    </div>


@endsection
