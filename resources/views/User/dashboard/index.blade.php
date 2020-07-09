@extends('layouts.app')

@section('content')
    <div class="container" id="page-dashboard"">
      <section class="row today-info-box">
        <div class="col-5 today-info today-dose">
          {{-- @php
            $limit = 400;
            $todayDose = DB::table('doses')->where('user_id', $userLogged)->whereDate('date', Carbon\Carbon::today('Europe/Rome'))->join('drinks', 'doses.drink_id', '=', 'drinks.id')->sum('amount'); 
          @endphp --}}
          <p>Oggi hai assunto<span>{{$todayDose}}mg</span>di caffeina</p>
        </div>
        <div class="offset-2 col-5 today-info today-limit">
          @if ($todayDose <= $limit )
            <p class="limit-ok">Puoi assumere ancora<span>{{$limit - $todayDose}}mg</span>di caffeina</p>
          @else
            <p class="limit-over">Hai superato di<span>{{$todayDose - $limit}}mg</span>il limite giornaliero</p>
          @endif
        </div>
      </section>
      <section>
        <div class="add-dose-box">
          <p>Registra ogni tazza di caffè, tè o bevanda ricca di caffeina. Cerca di non superare il limite giornaliero di caffeina consigliato dall'OMS.</p>
          <a class="btn btn-primary" href="{{route('user.dashboard.create')}}">Aggiungi dose di caffeina</a>
        </div>
      </section>
      
      <input type="text" name="user_id" value="{{Auth::id()}}" hidden>
      <section class="canvas-info-display">Ruota il tuo dispositivo o allarga la finestra del browser per visualizzare il grafico.</section>
      <section class="canvas-box">
        <canvas id="chart"></canvas>
      </section>

      <section class="doses-table">
        <h4 class="title-table">Registro della caffeina</h4>
        <table class="table table-sm">
          <thead>
            <tr>
              <th scope="col">Data</th>
              <th scope="col">Tipologia</th>
              <th scope="col">Caffeina (mg)</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @php
              $today = date('d/m/Y',strtotime("+2 hours"));;
              $yesterday = date('d/m/Y',strtotime("-22 hours"));
            @endphp
            
            @foreach ($doses as $dose)
            <tr class="dose-row">
              <td>
                @if (date('d/m/Y',strtotime($dose->date)) == $today)
                  Oggi, {{date('H:i', strtotime($dose->date))}}
                @elseif (date('d/m/Y',strtotime($dose->date)) == $yesterday)
                  Ieri, {{date('H:i', strtotime($dose->date))}}
                @else
                {{date('d/m/Y H:i', strtotime($dose->date))}}
                @endif 
              </td>
              <td>{{$dose->drink->type}}</td>
              <td>{{$dose->drink->amount}}</td>
              <td>
                <form action="{{route('user.dashboard.destroy', $dose->id)}}" method="post">
                  @method('DELETE')
                  @csrf
                  <button class="btn btn-outline-danger btn-sm" type="submit" name="" value="Elimina">Elimina</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if ($doses->isEmpty())
              <p class="no-data-info">Ancora nessun dato</p>
        @endif
        {{ $doses->links() }}        
      </section>
    </div>

    {{-- ============AJAX + CHART.JS SCRIPT================ --}}
    <script>

      getStats();

      function getStats() {
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                          }
                      });
                      $.ajax({
                          url: '/json-stats',
                          type: 'get',
                          // dataType: "json",
                          data: {
                              user_id: $('input[name=user_id]').val(),
                          },
                          success: function (response) {
                              makeChart(response);

                          },
                          error: function (response) {
                              console.log('Error:', response);
                          }
                      });
      }

      /////////////////////////////////////////////////////////////
          function makeChart(lastWeeekDoses) {
            var ctx = $('#chart');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['6 giorni fa', '5 giorni fa', '4 giorni fa', '3 giorni fa', '2 giorni fa', 'Ieri', 'Oggi'],
                    datasets: [{
                        label: 'Assunzione caffeina (mg)',
                        data: lastWeeekDoses,
                        backgroundColor: [
                            '#DE6B4880'
                        ],
                        pointBackgroundColor:  ['#DE6B48','#DE6B48','#DE6B48','#DE6B48','#DE6B48','#DE6B48','#DE6B48'],
                        borderWidth: 0
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
          }
            
      </script>
@endsection