@extends('layouts.app')
@section('content')

  <div class="admission">

    @if (!empty($message))
    <div class="container">
      <div class="alert alert-success" role="alert">
        {{ $message }}
      </div>
    </div>
    @endif



    <div class="section">

      <h2>Richiedi Informazioni</h2>

      <div class="container section">
        <form action="{{ route('admission.save') }}" method="post">
          @csrf
          @method('POST')

          <div>
            <label for="name">Nome</label>
            <input type="text" name="name" placeholder="Inserisci il tuo nome">
          </div>

          <div>
            <label for="name">Email</label>
            <input type="text" name="email" placeholder="Inserisci la tua mail">
          </div>

          <div>
            <label for="message">Messaggio</label>
            <input type="text" name="message" placeholder="Inserisci il tuo messaggio">
          </div>

          <div>
            <button type="submit" name="button">Invia</button>
          </div>

        </form>
      </div>

    </div>

  </div>
@endsection
