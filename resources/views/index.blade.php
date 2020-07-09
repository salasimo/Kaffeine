@extends('layouts.app')

@section('content')
  <div class="container" id="page-index">
    <div class="titles-box">
      <h2 class="title">Tieni traccia della caffeina che assumi giornalmente.</h2>
      <h4 class="sub-title">Prova a non superare il limite consigliato.</h4>
      <div class="instructions">
        <p class="instructions-title">Come funziona?</p>
        <p class="instructions-body hidden">Con Kaffeine puoi registrare ogni tua assunziona di caffeina. Scegli il tipo di prodotto che hai bevuto, e Kaffeine calcolerà la caffeina assunta. Il limite giornaliero consigliato, per un adulto, è pari a 400mg di caffeina.</p>
      </div>
    </div>
    <div class="btn-dashboard-box">
      <p>Sei già registrato?</p>
      <a class="btn btn-primary" href="/user/dashboard">Vai alla dashboard</a>
    </div>
    <div class="new-account-box">
      <p>Non hai ancora un account?</p>
      <a class="btn btn-primary" href="/register">Registrati</a>
    </div>
    
  </div>
@endsection