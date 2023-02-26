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
                        <form enctype="multipart/form-data" method="POST" action="{{ route('settings.store') }}">
                            @csrf

                            <div class="form-group row">
                                <img style="width:120px;height: 120px;"
                                     src="{{ \App\Models\User::getPhoto(\Illuminate\Support\Facades\Auth::id()) }}"
                                     alt="{{ Auth::user()->first_name }}">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="file" name="photo" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">Adınız</label>
                                    <input type="text" name="first_name" required class="form-control"
                                           value="{{ Auth::user()->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Soyadınız</label>
                                    <input type="text" name="last_name" required class="form-control"
                                           value="{{ Auth::user()->last_name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="text" name="email" required class="form-control"
                                           value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Doğum Tarih</label>
                                    <input type="date" name="birthdate" required class="form-control"
                                           value="{{ Auth::user()->birthdate }}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="">Telefon</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Website</label>
                                    <input type="text" name="website" class="form-control"
                                           value="{{ Auth::user()->website }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Meslek</label>
                                    <input type="text" name="job" class="form-control" value="{{ Auth::user()->job }}">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <label for="">Hakkında</label>
                                    <textarea name="bio" class="form-control" id="" cols="30"
                                              rows="10">{{\Illuminate\Support\Facades\Auth::user()->bio}}</textarea>
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
