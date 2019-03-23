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
      <div class="card" style="width: 18rem;">
        <div class="card_user">
          <img class="img_user card-img-top" src="{{ asset('img/avatar1.png') }}" alt="Card image cap">
        </div>
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
          <h2>Ciao,{{ $currentUser->name }}</h2>
          <a class="btn btn-success text-white" href="{{ route('owner.edit', $currentUser->id) }}">Modifica profilo</a>
          <a class="btn btn-primary text-white" href="{{ route('messages.index') }}">Leggi i tuoi messaggi</a>
          <a class="btn btn-primary text-white" href="{{ route('messages.create') }}">Invia un nuovo messaggio</a>
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
