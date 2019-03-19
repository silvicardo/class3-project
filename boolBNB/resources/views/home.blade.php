@extends('layouts.app')

@section('content')
  <div class="jumbo">


    <div class="container">
     @foreach(array_chunk($allApartments->all(), 3) as $row)
          <div class="row">
               @foreach($row as $allApartments)
                 <div class="card" style="width: 16rem;">
                  <img class="card-img-top" src="{{ $allApartments->image_url}}" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                  </div>
                </div>
               @endforeach
          </div>
       @endforeach
    </div>

  </div>

@endsection
