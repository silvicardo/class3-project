
@extends('layouts.app')

@section('user_feedback')

  @if(!empty($success))
    <div class="container alert alert-success" role="alert">
        A simple success alert—check it out!
    </div>
  @endif
@endsection

@section('content')


  <div class="container py-5">

    <div class="container">
      <button id="mostra_inviati" type="button" class="btn btn-primary">Inviati</button>
      <button id="mostra_ricevuti" type="button" class="btn btn-success d-none">Ricevuti</button>
      <div class="row">
        <div class="col-12">
          <div id="messaggi_inviati" class="container d-none">
            <h2 class="my-4">Ciao {{ $currentUser->name }}, messaggi inviati:</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>"Creata il"</th>
                  <th>"Oggetto"</th>
                  <th>"Nome Destinatario"</th>
                  <th>"Mail Destinatario"</th>

                  <th>Visualizza</th>
                  <th>Elimina</th>
                </tr>
              </thead>

              <tbody>
                @forelse ($messages as $message)

                  <tr>
                    <td>{{ $message['created_at'] }}</td>
                    <td>{{ $message['subject'] }}</td>
                    <td>{{ $message['recipient_name'] }}</td>
                    <td>{{ $message['recipient_mail'] }}</td>
                    {{-- <td>Periodo</td> --}}

                    <td>
                      <a href="{{route('messages.show',$message)}}" class="btn btn-primary">Visualizza</a>
                    </td>
                    <td>
                      <form action="{{ route('messages.destroy', $message)}}" method="post">
                        <input type="hidden" name="message_id" value="{{ $message['id'] }}">
                        @method('DELETE')
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Elimina">
                      </form>
                    </td>
                  </tr>
                @empty
                  <p>nessun messaggio</p>
                @endforelse
              </tbody>

            </table>
          </div>
          <div id="messaggi_ricevuti" class="container">
            <h2 class="my-4">Ciao {{ $currentUser->name }}, messaggi ricevuti:</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>"Creata il"</th>
                  <th>"Oggetto"</th>
                  <th>"Nome Mittente"</th>
                  <th>"Mail Mittente"</th>
                  <th>Visualizza</th>
                </tr>
              </thead>

              <tbody>
                @forelse ($receivedMessages as $message)

                  <tr>
                    <td>{{ $message['created_at'] }}</td>
                    <td>{{ $message['subject'] }}</td>
                    <td>{{ $message['sender_name'] }}</td>
                    <td>{{ $message['sender_email'] }}</td>


                    <td>
                      <a href="{{route('messages.show',$message)}}" class="btn btn-primary">Visualizza</a>
                    </td>
                  </tr>
                @empty
                  <p>nessun messaggio</p>
                @endforelse
              </tbody>

            </table>
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection

@section('scripts')
  <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
  </script>
  <script>

    $('#mostra_inviati').click(function(){
      $('#messaggi_inviati').removeClass('d-none');
      $('#messaggi_ricevuti').addClass('d-none');
      $('#mostra_inviati').addClass('d-none');
      $('#mostra_ricevuti').removeClass('d-none')
    });

    $('#mostra_ricevuti').click(function(){
      $('#messaggi_inviati').addClass('d-none');
      $('#messaggi_ricevuti').removeClass('d-none');
      $('#mostra_ricevuti').addClass('d-none');
      $('#mostra_inviati').removeClass('d-none');
    });
  </script>

@endsection
