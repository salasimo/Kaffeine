@extends('layouts.app')

@section('content')
  <div class="container">
    <div>
      <h2>Tieni traccia della caffeina che assumi giornalmente.</h2>
      <h4>Prova a non superare il limite consigliato.</h4>
    </div>
    <a class="btn btn-primary" href="/user/dashboard">Vai alla dashboard</a>
    <div>
      <p>Non hai ancora un account?</p>
      <a class="btn btn-primary" href="/register">Registrati</a>
    </div>
    
  </div>
@endsection