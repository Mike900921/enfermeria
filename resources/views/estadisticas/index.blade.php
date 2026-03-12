@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="row">
  {{-- verificacion de errores de fechas --}}

    @if ($errors->any())
        <div style="
            position: fixed; 
            top: 20px; 
            left: 50%; 
            transform: translateX(-50%); 
            z-index: 9999; 
            width: auto; 
            max-width: 90%;
        ">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0" role="alert" style="border-radius: 20px; padding-right: 50px;">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    @endif
    </div>

    <div class="row">

        <div class="col-6 me-5 card p-3  shadow-sm">
            <table class="table  table-striped">
              <thead>
                <tr>
                @if($ver === 'programa')
                    <th class=" text-center">Nombre del Programa</th>
                    <th class=" text-center">Coordinador del programa</th>
                    <th class=" text-center">Total Atenciones</th>

                @elseif($ver === 'pacientes')
                    <th class=" text-center">Nombre del Paciente</th>
                    <th class=" text-center">Numero de documento</th>
                    <th class=" text-center">ficha</th>
                    <th class=" text-center">total atenciones</th>
                
                @else
                    <th class=" text-center">Número de Ficha</th>
                    <th class=" text-center">Programa Relacionado</th>
                    <th class=" text-center">Total Atenciones</th>
                @endif
                </tr>
              </thead>
              <tbody>
                @forelse ($topData as $query)
                <tr>
                  @if($ver === 'programa')
                        {{-- Vista por  Programa --}}
                        <td class=" text-center">{{ $query->etiqueta }}</td>
                        <td class=" text-center">{{ $query->nombre_coord .' '.$query->apellido_coord }}</td>
                        <td class=" text-center align-middle"><span class="badge bg-primary ">{{ $query->total }}</span></td>
                    
                    @elseif($ver === 'pacientes')

                        {{-- Vista por Pacientes --}}
                        <td class=" text-center">{{ $query->etiqueta }}</td>
                        <td class=" text-center">{{ $query->numeroDocumento }}</td>
                        <td class=" text-center">{{ $query->fichaPaciente }}</td>
                        <td class=" text-center align-middle"><span class="badge bg-info ">{{ $query->total }}</span></td>

                    @else
                        {{-- Vista por Ficha --}}
                        <td class=" text-center">{{ $query->etiqueta }}</td>
                        <td class=" text-center">{{ $query->programa }}</td>
                        <td class=" text-center align-middle"><span class="badge bg-success">{{ $query->total }}</span></td>
                  @endif

                    @empty
                        <td colspan="3" class="text-center">No se encontraron datos para los filtros seleccionados.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
        </div>


        <div class="col-5">
             <!--filtros para buscar-->
            <div class="row">
                <form action="{{ route('estadisticas.index') }}" method="GET" class="card p-3 mb-4 shadow-sm">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Desde:</label>
                            <input type="date" name="fecha_inicio" class="form-control"
                                value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Hasta:</label>
                            <input type="date" name="fecha_fin" class="form-control"
                                value="{{ request('fecha_fin') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Agrupar por:</label>
                            <select name="ver" class="form-control">
                                <option value="ficha"  @selected(request('ver') == 'ficha') >Número de Ficha</option>
                                <option value="programa" @selected(request('ver') == 'programa') >Nombre del Programa</option>
                                 <option value="pacientes" @selected(request('ver') == 'pacientes') >paciente</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <input type="text" placeholder="Buscar" name="buscador" class="form-control mt-4" value="{{ request('buscador') }}">
                        </div>

                        {{-- Si existe algún parámetro en la URL, mostramos el botón de limpiar --}}

                        @if(request()->anyFilled(['fecha_inicio', 'fecha_fin', 'buscador']))
                        <div class="col-md-2">
                            <a href="{{ route('estadisticas.index') }}" class="btn btn-danger mt-4 w-100">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                        @endif

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12 card p-3 shadow-sm">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
  // Registrar el plugin globalmente
Chart.register(ChartDataLabels)

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
      indexAxis: 'y', // <--- ESTO CAMBIA LA ORIENTACIÓN
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

@endsection
