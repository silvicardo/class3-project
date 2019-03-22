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
          <h5 class="card-title">User Name: {{ $currentUser->name }}</h5>
          <h6 class="card-title">Email: {{ $currentUser->email }}</h6>
          <h6 class="card-title">Registrato il: {{ $currentUser->created_at }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="container_profile">
        <div class="container_profile_edit">
          <h2>Ciao, {{ $currentUser->name }}</h2>
          <a href="{{ route('owner.edit', Auth::user()->id )}}">Modifica profilo</a>
        </div>
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


{{-- CRUD messaggio proprietario  --}}


<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>Ciao Proprietario, questi sono i tuoi messaggi:</h1>

      <table class="table">
        <thead>
          <tr>
            <th>"Creata il"</th>
            <th>"Oggetto"</th>
            <th>"Nome Mittente"</th>
            <th>"Mail mittente"</th>
            <th>"dal giorno - al giorno"</th>
            <th>Visualizza</th>
            <th>Elimina</th>
          </tr>
        </thead>

        {{-- <tbody>
          @foreach ()
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <a href="#" class="btn btn-primary">Visualizza</a>
              </td>
              <td>
                <a href="#" class="btn btn-success">Modifica</a>
              </td>
              <td>
                <form action="#" method="post">
                  @method('DELETE')
                  @csrf
                  <input class="btn btn-danger" type="submit" value="Elimina">
                </form>
              </td>
            </tr>
          @endforeach
        </tbody> --}}

      </table>


    </div>
  </div>
</div>



<div class="card w-50">
  <div class="card-body">
    <h5 class="card-title">{{-- 0ggetto --}}</h5>
    <span>Creato il: {{$message->created_at}}</span><br>
    <span>Nome mittente: {{}}</span><br>
    <span>Mail mittente: {{}}</span><br>

    <p>Contenuto mail:{{$message->description }}</p>
  </div>
</div>


@endsection
