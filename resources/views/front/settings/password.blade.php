@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                @if(session("status"))
                    <div class="alert alert-info">{{ session("status") }}</div>
                @endif
                <div class="card">
                    <div class="card-header">Profili Düzenle</div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST"
                              action="{{ route('settings.passwordStore') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Mevcut Şifre</label>
                                    <input type="text" name="currentpassword" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">Şifreniz</label>
                                    <input type="password" name="password" required class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Şifreniz Tekrar</label>
                                    <input type="password" name="retrypassword" required class="form-control">
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Güncelle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @include('sidebar.settings')
            </div>
        </div>


    </div>
@endsection
