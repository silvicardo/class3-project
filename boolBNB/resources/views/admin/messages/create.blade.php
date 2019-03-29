
@extends('layouts.app')


@section('content')

  {{-- richiesta info guest + owner  --}}
    <div class="container py-5">
      <h2 class="my-4">{{ $title }}</h2>
      <form id="send_message" action="{{ $action }}" method="post">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="name" class="form-control" value="{{ $currentUser->name }}" placeholder="Inserisci il tuo nome">
        </div>
        <div class="form-group">
          <label for="sender_email">Email mittente</label>
          <input type="email" name="sender_email" class="form-control" value="{{ $currentUser->email }}" placeholder="name@example.com">
        </div>
        <div class="form-group">
          <label for="recipient_email">Email destinatario</label>
          <input type="email" name="recipient_email" class="form-control" value="" placeholder="email-destinatario@test.com">
        </div>
        <div class="form-group">
          <label for="message">Messaggio</label>
          <textarea class="form-control" name="message" placeholder="Scrivi messaggio"rows="3"></textarea>
        </div>
        <button  type="submit" class="btn btn-primary">Invia</button>
      </form>
    </div>


@endsection

@section('scripts')
  <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
  // var $ = require('jquery');

  $(document).ready(function(){

    console.log('controlla la mail script');
    $('#send_message').submit(function(event){
      event.preventDefault();
      var mailToCheck = $("input[name*='email']").val();
      console.log(mailToCheck);
      $.getJSON('api/user/',{email: mailToCheck})
        .done((apiData) => {
          console.log(apiData);
        })
    })

  })





</script>

@endsection
