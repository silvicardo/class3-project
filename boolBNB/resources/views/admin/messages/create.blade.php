
@extends('layouts.app')


@section('content')

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
