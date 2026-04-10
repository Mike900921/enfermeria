@extends('layouts.base')

@section('content')
    <div class="container mt-4">
        <div class="row">

            <div class="row g-4">
                <!--inicio de tabla-->
                <div class="col-12 col-xl-7">
                    <div class="card p-3 shadow-sm h-100">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr class="align-middle">
                                        @if ($ver === 'programa')
                                            <th class=" text-center ">Nombre del Programa</th>
                                            <th class=" text-center">Coordinador del programa</th>
                                            <th class=" text-center">Total Atenciones</th>
                                        @elseif($ver === 'pacientes')
                                            <th class=" text-center">Nombre del Aprendiz</th>
                                            <th class=" text-center">Numero de documento</th>
                                            <th class=" text-center ">ficha</th>
                                            <th class=" text-center">total atenciones</th>
                                        @elseif($ver === 'motivos')
                                            <th class=" text-center">Motivo</th>
                                            <th class=" text-center">Total Atenciones</th>
                                        @else
                                            <th class=" text-center">Número de Ficha</th>
                                            <th class=" text-center ">Programa Relacionado</th>
                                            <th class=" text-center">Total Atenciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topData as $query)
                                        <tr>
                                            @if ($ver === 'programa')
                                                {{-- Vista por  Programa --}}
                                                <td class=" text-center">{{ $query->etiqueta }}</td>
                                                <td class=" text-center">{{ $query->nombre_coord . ' ' . $query->apellido_coord }}
                                                </td>
                                                <td class=" text-center "><span class="badge bg-primary ">{{ $query->total }}</span>
                                                </td>
                                            @elseif($ver === 'pacientes')
                                                {{-- Vista por Pacientes --}}
                                                <td class=" text-center">{{ $query->etiqueta }}</td>
                                                <td class=" text-center">{{ $query->numeroDocumento }}</td>
                                                <td class=" text-center">{{ $query->fichaPaciente }}</td>
                                                <td class=" text-center "><span class="badge bg-info ">{{ $query->total }}</span>
                                                </td>

                                            @elseif($ver === 'motivos')
                                                {{-- Vista por Motivos --}}
                                                <td class=" text-center">{{ $query->etiqueta }}</td>
                                                <td class=" text-center"><span class="badge bg-info">{{ $query->total }}</span>
                                                </td>
                                            @else
                                                {{-- Vista por Ficha --}}
                                                <td class=" text-center">{{ $query->etiqueta }}</td>
                                                <td class=" text-center">{{ $query->programa }}</td>
                                                <td class=" text-center"><span class="badge bg-primary">{{ $query->total }}</span>
                                                </td>
                                            @endif

                                        @empty
                                            <td colspan="4" class="text-muted text-center">No se encontraron datos para los
                                                filtros
                                                seleccionados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-xl-5">
                    <!--filtros para buscar-->
                    <div class="row">
                        <form action="{{ route('estadisticas.index') }}" method="GET" class="card p-3 mb-4 shadow-sm">
                            <div class="row g-3 align-items-end">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-bold">Desde:</label>
                                    <input type="date" name="fecha_inicio" class="form-control"
                                        value="{{ request('fecha_inicio') }}">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-bold">Hasta:</label>
                                    <input type="date" name="fecha_fin" class="form-control"
                                        value="{{ request('fecha_fin') }}">
                                </div>
                                <!--filtros por select-->
                                <div class="col-12 col-lg-4">
                                    <label class="form-label fw-bold">Agrupar por:</label>
                                    <select name="ver" class="form-control">
                                        <option value="ficha"@selected($ver == 'ficha')>Número de Ficha</option>
                                        <option value="programa" @selected($ver == 'programa')>Nombre del Programa</option>
                                        <option value="pacientes" @selected($ver == 'pacientes')>aprendiz</option>
                                        <option value="motivos" @selected($ver == 'motivos')>motivos</option>
                                    </select>
                                </div>
                                <!--filtros por buscador-->
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Buscar</label>
                                    <input type="text" placeholder="Buscar ficha, programa, aprendiz o motivo" name="buscador" class="form-control"
                                        value="{{ request('buscador') }}">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Buscar adicional</label>
                                    <input type="text" placeholder="Segundo criterio de búsqueda" name="buscador_dos" class="form-control"
                                        value="{{ request('buscador_dos') }}">
                                </div>

                                <!--filtros para limpiar la busqueda-->
                                <div class="col-12">
                                    <div class="row g-2 justify-content-center align-items-center mt-1">
                                        @if (request()->anyFilled(['fecha_inicio', 'fecha_fin', 'buscador', 'buscador_dos']))
                                            <div class="col-12 col-sm-4 col-lg-3">
                                                <a href="{{ route('estadisticas.index') }}" class="btn btn-danger w-100">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        @endif

                                        <div class="col-12 col-sm-4 col-lg-3">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>

                                        <div class="col-12 col-sm-4 col-lg-3">
                                            <a href="{{ route('estadisticas.export', request()->query()) }}"
                                                class="btn btn-sena-verde w-100">
                                                <i class="bi bi-file-earmark-excel-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <!--estadisticas-->
                        <div class="col-12 card p-3 shadow-sm">
                            <canvas id="myChart" style="min-height: 320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scripts para Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

        <script>
            // Registrar el plugin globalmente
            Chart.register(ChartDataLabels)

            //estadistica inicial
            const ctx = document.getElementById('myChart');
            const isMobile = window.matchMedia('(max-width: 576px)').matches;
            const labels = @json($labels);
            const values = @json($values);

            if (isMobile) {
                const minMobileHeight = 420;
                const dynamicHeight = labels.length * 48;
                ctx.style.minHeight = `${Math.max(minMobileHeight, dynamicHeight)}px`;
            }

            const wrapLabel = (label, maxChars = 16) => {
                if (!isMobile || typeof label !== 'string' || label.length <= maxChars) {
                    return label;
                }

                const words = label.split(' ');
                const lines = [];
                let currentLine = '';

                words.forEach((word) => {
                    const testLine = currentLine ? `${currentLine} ${word}` : word;
                    if (testLine.length <= maxChars) {
                        currentLine = testLine;
                    } else {
                        if (currentLine) {
                            lines.push(currentLine);
                        }
                        currentLine = word;
                    }
                });

                if (currentLine) {
                    lines.push(currentLine);
                }

                return lines;
            };

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Total de Atenciones ',
                        data: values,
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    indexAxis: 'y', // <--- ESTO CAMBIA LA ORIENTACIÓN
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            ticks: {
                                autoSkip: false,
                                callback: function(value) {
                                    const label = this.getLabelForValue(value);
                                    return wrapLabel(label);
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endsection
