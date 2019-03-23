
@extends('layouts.app')


@section('content')
  <div class="container py-5">

    <div class="card w-50">
      <div class="card-body">
        <h5 class="card-title">{{$message->subject}}</h5>
        <span>Creato il: {{$message->created_at}}</span><br>
        <span>Nome mittente: {{$sender->name}}</span><br>
        <span>Mail mittente: {{$sender->mail}}</span><br>

        <p>Contenuto mail:{{$message->description }}</p>
      </div>
    </div>

  </div>
@endsection
