@extends('layouts.app')

@section('content')
    <div class="container">
      <section>
        <h2>Tieni sotto controllo la quantità di caffeina che assumi.</h2>
        <p>Registra ogni tazza di caffè, tè o bevanda ricca di caffeina. Cerca di non superare il limite giornaliero di caffeina consigliato dall'OMS.</p>
        <a href="{{route('user.dashboard.create')}}">Aggiungi dose di caffeina</a>
      </section>
      <section>
        <div class="col-6">
          @php
            $limit = 400;
            $todayDose = DB::table('doses')->whereDate('date', Carbon\Carbon::today('Europe/Rome'))->join('drinks', 'doses.drink_id', '=', 'drinks.id')->sum('amount'); 
          @endphp
          <h4>Oggi hai assunto {{$todayDose}}mg di caffeina</h4>
        </div>
        <div class="col-6">
          @if ($todayDose <= $limit )
            <h4>Puoi assumerne ancora {{$limit - $todayDose}}mg</h4>
          @else
            <h4>Hai superato il limite giornaliero di {{$todayDose - $limit}}mg</h4>
          @endif
        </div>
      </section>
      <input type="text" name="user_id" value="{{Auth::id()}}" hidden>
      <canvas id="chart" width="300" height="100"></canvas>

      <section>
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
            <tr>
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
        {{ $doses->links() }}        
      </section>
    </div>

    {{-- ============CHART.JS SCRIPT================ --}}
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
                        label: 'Assunzione caffeina (mg) | Ultimi 7 giorni',
                        data: lastWeeekDoses,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        
                        borderWidth: 1
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