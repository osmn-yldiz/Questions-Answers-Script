@extends("layouts.app")
@section("header")
    <link rel="stylesheet" href="{{ asset("plugins/tokenfield/css/bootstrap-tokenfield.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/tokenfield/css/tokenfield-typeahead.css") }}">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">Yeni Soru Sor</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("question.store") }}">
                            @csrf
                            @method("POST")

                            <div class="row mb-3">
                                <label>Soru Başlığı</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="title"
                                           placeholder="Soru Başlığı Giriniz"
                                           value="{{ old('title') }}" required autocomplete="title" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label>Kategori Seçimi</label>
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($categories as $key => $value)
                                            <div class="col-md-3">
                                                <div class="m-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="category[]"
                                                           value="{{$value['id']}}" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{$value['name']}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label>Sorunuz</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Sorunuzu Giriniz" name="text"
                                              id="question--area" style="height: 100px"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label>Etiketler</label>
                                <div class="col-md-12">
                                    <input id="tokenfield" type="text" class="form-control" name="tags">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Soruyu Sor
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
