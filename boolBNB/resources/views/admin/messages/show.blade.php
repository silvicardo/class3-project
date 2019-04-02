
@extends('layouts.app')


@section('content')
  <div class="container py-5">

    <div class="card w-50">
      <div class="card-body">
        <h5 class="card-title"><strong>Oggetto: </strong>{{$message->subject}}</h5>
        <span><strong>Creato il: </strong> {{$message->created_at}}</span><br>

        <span><strong>Nome mittente: </strong> {{----}}</span><br>
        <span><strong>Mail mittente: </strong> {{-- --}}</span><br>

        <p><strong>Contenuto mail: </strong> {{$message->description_body }}</p>
      </div>
    </div>

  </div>
@endsection
