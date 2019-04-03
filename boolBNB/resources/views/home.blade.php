@extends('layouts.app')

@section('content')
  <div class="jumbo">
    <div class="container">

      @if(!empty($sponsoredApartments))

       <div class="jumbotron">
          <h2>Appartamenti in evidenza</h2>
          <ul>
            @foreach($sponsoredApartments as $sponsoredApartment)
              <li>{{$sponsoredApartment->title}}</li>
            @endforeach
          </ul>
        </div>

      @endif
      <div class="row">
        @foreach($allApartments as $key => $apartment)
          <div class="card_appartment col-md-4 mt-5">
            <a href="{{route('apartment.show', $apartment->id) }}">
              <div class="card">
               <img class="card-img-top" src="{{ ($apartment->image_url == 'https://www.labaleine.fr/sites/baleine/files/image-not-found.jpg') ? $apartment->image_url : (asset('storage/' . $apartment->image_url)) }}" alt="Card image cap">
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
