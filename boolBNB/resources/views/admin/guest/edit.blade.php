@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="form_container row">
      <div class="col-12">
        @include('partials.error')
        <h1>Modifica i tuoi dati</h1>
        <form class="form-group" action="#" method="post">
          @method('PUT')
          @csrf
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="title" class="form-control" placeholder="inserisci il tuo nome">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci la tua email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci la nuova password">
          </div>
          <div class="form-group">
            <input type="submit" class="form-control" value="Aggiorna i tuoi dati">
          </div>
        </div>
    </div>
  </div>
@endsection
