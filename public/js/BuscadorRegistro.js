$(document).ready(function () {

    let currentQuery = '';

    $('#btn-buscar').on('click', function (e) {
        e.preventDefault();

        currentQuery = $('#input-busqueda').val();

        cargarPacientes(URL_REGISTROS);
        actualizarLinkExcel();
    });

    function cargarPacientes(url) {

        let query = $('#input-busqueda').val();
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                query: query,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin
            },
            beforeSend: function () {
                $('#tabla-pacientes').html('<div class="text-center p-3">Cargando...</div>');
            },
            success: function (data) {
                $('#tabla-pacientes').html(data);
            },
            error: function () {
                $('#tabla-pacientes').html(
                    '<div class="text-danger text-center p-3">Error al cargar los datos.</div>'
                );
            }
        });
    }

    function actualizarLinkExcel() {

        let url = URL_EXCEL;

        let query = $('#input-busqueda').val();
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();

        if (query) {
            url += '?query=' + encodeURIComponent(query);
        }

        if (fecha_inicio) {
            url += (url.includes('?') ? '&' : '?') + 'fecha_inicio=' + fecha_inicio;
        }

        if (fecha_fin) {
            url += (url.includes('?') ? '&' : '?') + 'fecha_fin=' + fecha_fin;
        }

        console.log(url); // 👈 mira esto en la consola

        $('#btn-excel').attr('href', url);

        // Limpia los inputs
        $('#input-busqueda').val('');
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
    }

});
