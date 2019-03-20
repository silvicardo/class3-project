

@extends('layouts.app')

@section('content')

{{-- qui lavora il frontend per la dashboard owner --}}
<h1>frontend</h1>
<h2>{{ $currentUser->name }}</h2>

<a href="{{ route('apartment.create')}}">Crea nuovo</a>
<a href="{{ route('apartment.show', 10)}}">Mostrami appartamento 10</a>

{{-- tabella --}}
<tr><a href="{{ route('apartment.show',1)}}">Mostrami appartamento 10</a></tr>
@endsection
