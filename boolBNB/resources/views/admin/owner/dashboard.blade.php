@extends('layouts.app')

@section('content')

@if(!empty($userApartments))

<div class="container py-5">

  <h1 class="ownerdashboardtitle">La tua dashboard</h1>
  <h2 class="ownerhello">Ciao {{ $currentUser->name }}, ecco i tuoi appartamenti</h2>

      <div class="row">
              @foreach($userApartments as $key => $apartment)
                <div class="col-md-4 mb-5">
                  <div href="{{route('apartment.show', $apartment->id) }}">
                    <div class="card">
                     <img class="card-img-top" src="{{ $apartment->image_url}}" alt="Card image cap">
                     <div class="card-body">
                       <h5 class="card-title">{{ $apartment->title }}</h5>
                       <p class="card-text">{{ $apartment->description}}</p>

                       @if (!empty(Auth::user()) && Auth::user()->can('edit-apartment'))
                         <a class="btn btn-primary btn-lg" href="{{ route('apartment.edit', $apartment->id)}}">Modifica appartamento</a>
                       @endif
                       @if (!empty(Auth::user()) && Auth::user()->can('delete-apartment'))
                         <form action="{{ "/apartment/" . $apartment->id . "/delete"}}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger delete">Rimuovi appartamento</button>
                         </form>
                       @endif
                     </div>
                    </div>
                  </div>
                </div>
              @endforeach
      </div>
@endif
</div>




@endsection
