@extends('layouts.app')

@section('user_feedback')

  @if(!empty($error))
    <div class="container alert alert-danger " role="alert">
        {{$error}}
    </div>
  @endif

  @if(!empty($success))
    <div class="container alert alert-success " role="alert">
        {{$success}}
    </div>
  @endif
@endsection

@section('content')


  {{-- <div class="hai_sponsor">
    <p>
      {{ dd($user->subscribed('main'))}}
    </p>
  </div> --}}

  @if(!empty($currentUser->apartments))

    <div class="container py-5">

      <h2  class="ownerhello mb-5">Ciao {{ $currentUser->name }}, ecco i tuoi appartamenti:</h2>

      <a href="{{ route('apartment.create', $currentUser->id)}}" class="btn btn-large btn-primary mb-5">Crea nuovo appartamento</a>
      <a href="{{ route('owner.sponsor.create')}}" class="btn btn-large btn-primary mb-5">Sponsorizza un appartamento</a>
      <div class="row">
        @foreach(array_reverse($currentUser->apartments()->get()->toArray()) as $apartment)
          <div class="col-md-4 mb-5">
            <div href="{{route('apartment.show', $apartment['id']) }}">
              <div class="card">
                <img class="card-img-top" src="{{ asset('storage/' . $apartment['image_url']) }}" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">{{ $apartment['title'] }}</h5>
                  <p class="card-text">{{ $apartment['description']}}</p>


                    <a class="btn btn-primary" href="{{ route('apartment.edit', $apartment['id'])}}">Modifica appartamento</a>


                    <form action="{{ route('apartment.destroy', $apartment['id'])}}" method="POST">
                      @method('DELETE')
                      @csrf
                      <button type="submit" class="btn btn-danger delete mt-4">Rimuovi appartamento</button>
                    </form>

                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>



@endsection
