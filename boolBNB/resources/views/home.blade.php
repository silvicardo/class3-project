@extends('layouts.app')

@section('content')
  <div class="jumbo">
  <div class="container">
    <div class="row">
            @foreach($allApartments as $key => $apartment)
              <div class="col-md-4 mb-5">
                <div href="{{route('apartment.show', $apartment->id) }}">
                  <div class="card">
                   <img class="card-img-top" src="{{ $apartment->image_url}}" alt="Card image cap">
                   <div class="card-body">
                     <h5 class="card-title">{{ $apartment->title }}</h5>
                     <p class="card-text">{{ $apartment->description}}</p>

                   </div>
                  </div>
                </div>
              </div>
            @endforeach
    </div>
  </div>



  </div>

@endsection


{{-- <div class="container">

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

</div> --}}
