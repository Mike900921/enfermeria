@extends('layouts.base')

@section('content')

<div class="container mt-4">

    <div class="row">

        <div class="col-6 me-5 card p-3  shadow-sm">
            <table class="table  table-striped">
              <thead>
                <tr>
                @if($ver === 'programa')
                    <th>Nombre del Programa</th>
                    <th>Coordinador del programa</th>
                    <th>Total Atenciones</th>
                @else
                    <th>Número de Ficha</th>
                    <th>Programa Relacionado</th>
                    <th>Total Atenciones</th>
                @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($topData as $query)
                <tr>
                  @if($ver === 'programa')
                        {{-- Vista por  Programa --}}
                        <td>{{ $query->etiqueta }}</td>
                        <td>{{ $query->nombre_coord .' '.$query->apellido_coord }}</td>
                        <td><span class="badge bg-primary">{{ $query->total }}</span></td>
                    @else
                        {{-- Vista por Ficha --}}
                        <td>{{ $query->etiqueta }}</td>
                        <td>{{ $query->programa }}</td>
                        <td><span class="badge bg-success">{{ $query->total }}</span></td>
                    @endif
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>


        <div class="col">

            <!--filtros para buscar-->
            <div class="row">
                <form action="{{ route('estadisticas.index') }}" method="GET" class="card p-3 mb-4 shadow-sm">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Desde:</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Hasta:</label>
                            <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Agrupar por:</label>
                            <select name="ver" class="form-select">
                                <option value="ficha" {{ request('ver') == 'ficha' ? 'selected' : '' }}>Número de Ficha</option>
                                <option value="programa" {{ request('ver') == 'programa' ? 'selected' : '' }}>Nombre del Programa</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!--estadisticas-->
            <div class="row">
              <div class="card p-3  shadow-sm">
                <canvas id="myChart"></canvas>
              </div>
            </div>
  


              
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/topbar.js') }}"></script>

<script>

//estadistica inicial
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($labels),
      datasets: [{
        label: 'Total de Atenciones ',
        data: @json($values),
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

@endsection