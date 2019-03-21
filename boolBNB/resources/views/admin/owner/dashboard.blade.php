

@extends('layouts.app')

@section('content')


<h1>La tua dashboard</h1>
<h2>Ciao {{ $currentUser->name }} ecco i tuoi appartamenti</h2>

<a class="btn btn-primary" href="{{ route('apartment.create')}}">Aggiungi nuovo appartamento</a>
  <div class="container">
    <div class="cardcontainer">
      @foreach(array_chunk($currentUser->apartments(), 3) as $row)
           <div class="row">
                @foreach($row as $allApartments)
                  <a href="{{route('apartment.show', $allApartments->id) }}">
                    <div class="card" style="width: 30rem;">
                     <img class="card-img-top" src="{{ $allApartments->image_url}}" alt="Card image cap">
                     <div class="card-body">
                       <h5 class="card-title">{{ $allApartments->title }}</h5>
                       <p class="card-text">{{ $allApartments->description}}</p>
                       <a class="btn btn-success" href="#">Modifica</a>
                       @if (!empty(Auth::user()) && Auth::user()->can('edit-apartment'))
                         <a class="btn btn-secondary btn-lg" href="{{ route('apartment.edit', $foundApartment->id)}}">Edita appartamento</a>
                       @endif
                       @if (!empty(Auth::user()) && Auth::user()->can('delete-apartment'))
                       <form action="{{ "/apartment/" . $foundApartment->id . "/delete"}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                     @endif
                     </div>
                    </div>
                  </a>

                @endforeach
           </div>
      @endforeach
    </div>
  </div>


{{-- <a href="{{ route('apartment.create')}}">Crea nuovo</a>
<a href="{{ route('apartment.show', 10)}}">Mostrami appartamento 10</a>

{{-- tabella --}}
{{-- <tr><a href="{{ route('apartment.show',1)}}">Mostrami appartamento 10</a></tr> --}}
@endsection
