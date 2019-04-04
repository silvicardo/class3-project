
@extends('layouts.app')


@section('content')

  <div class="container py-5">

    <div class="card w-50 m-auto">
      <div class="card-body">
        <h5 class="card-title">
          <strong>Oggetto: </strong>{{ $message->subject }}
        </h5>
        <span>
          <strong>Creato il: </strong>{{ $message->created_at }}
        </span><br>
        <span>
          <strong>{{($utente == true ) ? $data['nomeMittente'] : $data['nomeDestinatario']}}: </strong>{{($utente == true ) ? $message['sender_name'] : $message['recipient_name']}}
        </span><br>
        <span>
          <strong>{{($utente == true ) ? $data['emailMittente'] : $data['emailDestinatario']}}: </strong>{{($utente == true ) ? $message['sender_email'] : $message['recipient_mail']}}
        </span><br>
        <p>
          <strong>Contenuto mail: </strong>{{ $message->description_body }}
        </p>
      </div>
    </div>

  </div>
@endsection
