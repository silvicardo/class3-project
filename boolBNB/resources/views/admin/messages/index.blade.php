
@extends('layouts.app')


@section('content')
  <div class="container py-5">

    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Ciao Proprietario, questi sono i tuoi messaggi:</h1>

          <table class="table">
            <thead>
              <tr>
                <th>"Creata il"</th>
                <th>"Oggetto"</th>
                <th>"Nome Mittente"</th>
                <th>"Mail mittente"</th>
                <th>"dal giorno - al giorno"</th>
                <th>Visualizza</th>
                <th>Elimina</th>
              </tr>
            </thead>

            <tbody>
              @foreach ()
                <tr>
                  <td>{{ $message->created_at }}</td>
                  <td>{{ $message->subject }}</td>
                  <td>{{ $sender->name }}</td>
                  <td>{{ $sender->email }}</td>
                  <td>Periodo</td>
                  <td>
                    <a href="#" class="btn btn-primary">Visualizza</a>
                  </td>
                  <td>
                    <form action="{{ route('messages.destroy',$message)}}" method="post">
                      <input type="hidden" name="sender_id" value="{{ $message->sender_id }}">
                      @method('DELETE')
                      @csrf
                      <input class="btn btn-danger" type="submit" value="Elimina">
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>

          </table>


        </div>
      </div>
    </div>

  </div>
@endsection
