@extends('layouts.app')

@section('content')
    <section>
      <div class="container">
        <h2>Aggiungi la quantità di caffeina che hai assunto.</h2>
        <form action="{{route('user.dashboard.store')}}" method="POST" enctype="multipart/form-data">
          @method("POST")
          @csrf
          <div class="form-group">
            <select class="custom-select" name="drink_id">
              <option value="-1" selected>Seleziona una bevanda</option>
              @foreach ($drinks as $drink)
                <option value="{{$drink->id}}">{{$drink->type}}</option>
              @endforeach 
            </select>   
            @error('drink_id')
                <small class="form-text">Seleziona una bevanda per continuare.</small>
              @enderror 
            
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Conferma">
          </div>
        </form>
      </div>
    </section>
    
@endsection