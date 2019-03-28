@extends('layouts.app')

@section('content')
  <div class="jumbo">
    <div class="container">
      <div class="sponsor">
        <h2>Appartamenti in evidenza</h2>

      </div>
      <div class="row">
        @foreach($allApartments as $key => $apartment)
          <div class="card_appartment col-md-4 mt-5">
            <a href="{{route('apartment.show', $apartment->id) }}">
              <div class="card">
               <img class="card-img-top" src="{{ asset('storage/' . $apartment->image_url) }}" alt="Card image cap">
               <div class="card-body">
                 <h5 class="card-title">{{ $apartment->title }}</h5>
                 <p class="card-text">{{ $apartment->description}}</p>
               </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
