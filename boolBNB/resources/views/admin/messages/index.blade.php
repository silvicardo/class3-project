
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
      <div class="row">
        <div class="col-12">
          <h2 class="my-4">Ciao {{ $currentUser->name }}, questi sono i tuoi messaggi:</h2>

          <table class="table">
            <thead>
              <tr>
                <th>"Creata il"</th>
                <th>"Oggetto"</th>
                <th>"Nome Destinatario"</th>
                <th>"Mail Destinatario"</th>
                {{-- <th>"dal giorno - al giorno"</th> --}}
                <th>Visualizza</th>
                <th>Elimina</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($messages as $message)

                <tr>
                  <td>{{ $message->created_at }}</td>
                  <td>{{ $message->subject }}</td>
                  <td>{{ $message->recipient_name }}</td>
                  <td>{{ $message->recipient_mail }}</td>
                  {{-- <td>Periodo</td> --}}

                  <td>
                    <a href="{{route('messages.show',$message)}}" class="btn btn-primary">Visualizza</a>
                  </td>
                  <td>
                    <form action="{{ route('messages.destroy', $message)}}" method="post">
                      <input type="hidden" name="message_id" value="{{ $message->id }}">
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
      </div>
    </div>

  </div>
@endsection
