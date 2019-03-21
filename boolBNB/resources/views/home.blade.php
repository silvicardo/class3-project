@extends('layouts.app')

@section('content')
  <div class="jumbo">


    <div class="container">

      <div class="cardcontainer">
        @foreach(array_chunk($allApartments->all(), 3) as $row)
             <div class="row">
                  @foreach($row as $allApartments)
                    <a href="{{route('apartment.show', $allApartments->id) }}">
                      <div class="card" style="width: 16rem;">
                       <img class="card-img-top" src="{{ $allApartments->image_url}}" alt="Card image cap">
                       <div class="card-body">
                         <h5 class="card-title">{{ $allApartments->title }}</h5>
                         <p class="card-text">{{ $allApartments->description}}</p>
                       </div>
                      </div>
                    </a>

                  @endforeach
             </div>
        @endforeach
      </div>

    </div>

  </div>

@endsection
