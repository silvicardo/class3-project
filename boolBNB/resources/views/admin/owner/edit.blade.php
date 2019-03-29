@extends('layouts.app')

@section('user_feedback')

  @if(!empty($error))
    <div class="container alert alert-danger " role="alert">
        {{$error}}
    </div>
  @endif
@endsection
@section('content')

<div class="container">
  <div class="form_container row">
    <div class="col-12">
      @include('partials.error')
      <h2 class="my-4">Modifica la tua password:</h2>
      <form id="form_cambio_password" class="form-group" action="{{ route('owner.updatePassword') }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        {{--<div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="title" class="form-control" placeholder="inserisci il tuo nome">
        </div>--}}

        {{-- <div class="form-group">
          <label for="email">Email</label>
          <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci la tua email">
        </div> --}}

        <div class="form-group">
          <label for="old_password">Vecchia Password</label>
          <input type="password" name="old_password" class="form-control" id="" placeholder="Inserisci vecchia Password">
        </div>
        <div class="form-group">
          <label for="new_password">Nuova Password</label>
          <input type="password" name="new_password" class="form-control" id="new_password_1" placeholder="Inserisci nuova Password">
        </div>
        <div class="form-group">
          <label for="new_password_2">Conferma nuova Password</label>
          <input type="password" name="new_password_confirmation" class="form-control" id="new_password_2" placeholder="Conferma nuova Password">
        </div>
        <div class="form-group">
          <input id="bottone_invio_form" type="submit" class="form-control mt-5" value="Aggiorna i tuoi dati">
        </div>
      </form>
      <div class="alert alert-danger d-none" id="alert_errore" role="alert">

      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>


<script type="text/javascript">

$(document).ready(function(){

  $('#bottone_invio_form').click(function(event){

    event.preventDefault();

    if($('#new_password_1').val() === $('#new_password_2').val()){
      $('#form_cambio_password').submit();

    }
    else {
      $('#alert_errore').html('Le password inserite non coincidono').removeClass('d-none');
    }

  })

});





</script>

@endsection
