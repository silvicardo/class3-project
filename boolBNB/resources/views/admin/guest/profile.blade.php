@extends('layouts.app')

@section('content')

<div class="container profile">
  <div class="row">
    <div class="col-sm-5">
      <div class="card" style="width: 18rem;">
        <div class="card_user">
          <img class="img_user card-img-top" src="{{ asset('img/avatar1.png') }}" alt="Card image cap">
        </div>
        <div class="card-body">
          <h5 class="card-title">User Name: {{ $guest->name }}</h5>
          <h6 class="card-title">Email: {{ $guest->email }}</h6>
          <h6 class="card-title">Registrato il: {{ $guest->created_at }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="container_profile">
        <div class="container_profile_edit">
          <h2>Ciao, {{ $guest->name }}</h2>
          <a href="{{ route('guest.edit', Auth::user()->id )}}">Modifica profilo</a>
        </div>
        <div class="container_profile_delete">
          @if (!empty(Auth::user()) && Auth::user()->can('manage-guest'))
            <form action="{{ "/guest/" . $guest->id . "/delete"}}" method="POST">
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

{{-- richiesta info ospite  --}}
@if(Auth::user()->hasRole('proprietario'))
  <div class="container">
    <h2>Invia un messaggio all'ospite</h2>
    <form action="#" method="post">
      @csrf
      @method('POST')
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" class="form-control" value="{{ $currentUser->name }}" placeholder="Inserisci il tuo nome">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $currentUser->email }}" placeholder="name@example.com">
      </div>
      <div class="form-group">
        <label for="message">Messaggio</label>
        <textarea class="form-control" name="message" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Invia</button>
    </form>
  </div>
@else
  <div class="container">
    <h2>Richiedi informazioni</h2>
    <form action="#" method="post">
      @csrf
      @method('POST')
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" class="form-control" value="{{ $guest->name }}" placeholder="Inserisci il tuo nome">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $guest->email }}" placeholder="name@example.com">
      </div>
      <div class="form-group">
        <label for="message">Messaggio</label>
        <textarea class="form-control" name="message" placeholder="Inserisci il tuo messaggio" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Invia</button>
    </form>
  </div>
@endif

@endsection
