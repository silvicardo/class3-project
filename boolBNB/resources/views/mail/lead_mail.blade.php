@component('mail::message')

Hai una nuova richiesta di informazioni inviata da {{ $lead->name }} con email {{ $lead->email }} con questo contenuto : <br>

{{ $lead->message }}

@endcomponent
