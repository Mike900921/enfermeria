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
            error: function (xhr) {
                console.log(xhr.responseText);
                $('#tabla-pacientes').html(
                    '<div class="text-danger text-center p-3">Error al cargar los datos.</div>'
                );
            }
        });
    }

    function actualizarLinkExcel() {

        let url = URL_EXPORT_EXCEL;

        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();

        if (currentQuery.trim() !== '') {
            url += '?query=' + encodeURIComponent(currentQuery);
        }

        if (fecha_inicio) {
            url += (url.includes('?') ? '&' : '?') + 'fecha_inicio=' + encodeURIComponent(fecha_inicio);
        }

        if (fecha_fin) {
            url += (url.includes('?') ? '&' : '?') + 'fecha_fin=' + encodeURIComponent(fecha_fin);
        }

        $('#btn-excel').attr('href', url);
    }

});
