@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="form_container row">
      <div class="col-12">
        @include('partials.error')
        <h2 class="my-4">Modifica i tuoi dati:</h2>
        <form class="form-group" action="#" method="post" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <div class="form-group">
            <label for="#">Modifica immagine profilo</label>
            <br>
            <input type="file" name="#">
          </div>
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="title" class="form-control" placeholder="inserisci il tuo nome">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci la tua email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Vecchia Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Inserisci vecchia Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Nuova Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Inserisci nuova Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Conferma nuova Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Conferma nuova Password">
          </div>
          <div class="form-group">
            <input type="submit" class="form-control mt-5" value="Aggiorna i tuoi dati">
          </div>
        </div>
    </div>
  </div>
@endsection
