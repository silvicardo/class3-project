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


@endsection
