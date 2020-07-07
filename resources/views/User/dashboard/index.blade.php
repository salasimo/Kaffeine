@extends('layouts.app')

@section('content')
    <section>
      <h2>Tieni sotto controllo la quantità di caffeina che assumi.</h2>
      <p>Registra ogni tazza di caffè, tè o bevanda ricca di caffeina. Cerca di non superare il limite giornaliero di caffeina consigliato dall'OMS.</p>
      <a href="{{route('user.dashboard.create')}}">Aggiungi dose di caffeina</a>
    </section>
    
    <section>
      
    </section>
@endsection