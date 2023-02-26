@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                @if(session("status"))
                    <div class="alert alert-info">{{ session("status") }}</div>
                @endif
                <div class="card">
                    <div class="card-header">Bildirimler ({{ count($data) }})</div>

                    <div class="card-body">

                        @foreach($data as $k => $v)
                            <li class="list-group-item">
                                {{$v['text']}}
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
