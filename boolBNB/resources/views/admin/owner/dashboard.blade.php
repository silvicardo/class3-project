

@extends('layouts.app')

@section('content')


<h1>La tua dashboard</h1>
@if(!empty($userApartments));

<h2>Ciao {{ $currentUser->name }} ecco i tuoi appartamenti</h2>

<a class="btn btn-primary" href="{{ route('apartment.create')}}">Aggiungi nuovo appartamento</a>
  <div class="container">
    <div class="cardcontainer">
      @foreach(array_chunk($currentUser->apartments, 3) as $row)
           <div class="row">
                @foreach($row as $allApartments)
                  <a href="{{route('apartment.show', $allApartments->id) }}">
                    <div class="card" style="width: 30rem;">
                     <img class="card-img-top" src="{{ $allApartments->image_url}}" alt="Card image cap">
                     <div class="card-body">
                       <h5 class="card-title">{{ $allApartments->title }}</h5>
                       <p class="card-text">{{ $allApartments->description}}</p>
                       <a class="btn btn-success" href="#">Modifica</a>
                       <form action="{{ route('apartment.destroy', $apartments->id) }}" method="post">
                         @method('DELETE')
                         @csrf
                         <input class="btn btn-danger" type="submit" value="Cancella">
                       </form>
                     </div>
                    </div>
                  </a>
                @endforeach
           </div>
      @endforeach
    </div>
  </div>
@endif

{{-- <a href="{{ route('apartment.create')}}">Crea nuovo</a>
<a href="{{ route('apartment.show', 10)}}">Mostrami appartamento 10</a>

{{-- tabella --}}
{{-- <tr><a href="{{ route('apartment.show',1)}}">Mostrami appartamento 10</a></tr> --}}
@endsection
