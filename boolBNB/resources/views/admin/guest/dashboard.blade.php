

@extends('layouts.app')


@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="mt-4">Ciao User, queste sono le tue prenotazioni:</h2>

        <a href="#" class="btn btn-primary mb-5 mt-4">Aggiungi nuova prenotazione</a>

        <table class="table">
          <thead>
            <tr>
              <th>"Id prenotazione"</th>
              <th>"Titolo appartamento"</th>
              <th>"Prezzo"</th>
              <th>"N° notti"</th>
              <th>"dal giorno - al giorno"</th>
              <th>Visualizza</th>
              <th>Modifica</th>
              <th>Elimina</th>
            </tr>
          </thead>

          {{-- <tbody>
            @foreach ()
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <a href="#" class="btn btn-primary">Visualizza</a>
                </td>
                <td>
                  <a href="#" class="btn btn-success">Modifica</a>
                </td>
                <td>
                  <form action="#" method="post">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-danger" type="submit" value="Elimina">
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody> --}}

        </table>


      </div>
    </div>
  </div>

@endsection
