@extends('layouts.app')
@section('alerts')
  @if (!empty($error))
    <div class="container alert alert-primary" role="alert">
        {{$error}}
    </div>
  @endif
@endsection
@section('content')

<div class="container profile">
  <div class="row">
    <div class="col-sm-5">
      <div class="card d-flex flex-column align-items-center justify-content-center" style="width: 18rem;">
        <img class="img_user card-img-top" src="{{ asset('storage/' . $currentUser->image_profile) }}" alt="Card image cap">
        <form id="form_cambio_password" class="form-group" action="{{ route('owner.profilePictureUpdate') }}" method="post" enctype="multipart/form-data" >
          @method('PUT')
          @csrf
          <div class="form-group my-4 ml-5">
            <label for="image_file">Modifica immagine profilo</label>
            <br>
            <input type="file" name="image_file">

          </div>

          <button type="submit" class="ml-5 btn btn-primary">Carica Immagine</button>
        </form>
        <div class="card-body">
          <h5 class="card-title">User Name: {{ $currentUser->name }}</h5>
          <h6 class="card-title">Email: {{ $currentUser->email }}</h6>
          <h6 class="card-title">Registrato il: {{ $currentUser->created_at }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="container_profile">
        <div class="container_profile_edit">
          <h2 class="mb-4">Ciao, {{ $currentUser->name }}</h2>
          <a href="{{ route('owner.edit') }}">Modifica password</a>
          <a href="{{ route('messages.index') }}">Leggi messaggi</a>
          <a href="{{ route('messages.create') }}">Invia messaggio</a>
        </div>
        @if (!empty($alert))
          <div class="w-50 alert alert-primary" role="alert">
              {{$alert}}
          </div>
        @endif
        <div class="container_profile_delete">
          @if (!empty(Auth::user()) && Auth::user()->can('manage-owner'))
            <form action="{{ "/owner/" . $currentUser->id . "/delete"}}" method="POST">
              @method('DELETE')
               @csrf
              <button type="submit" class="btn btn-danger">Elimina il tuo account</button>
            </form>
          @endif
        </div>

      </div>

    </div>
  </div>
</div>

@endsection
