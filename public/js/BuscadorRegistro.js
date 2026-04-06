//script para el buscador de registros en la vista y filtro de descarga de registros.blade.php
$(document).ready(function () {
    let currentQuery = "";

    $("#btn-buscar").on("click", function (e) {
        e.preventDefault();

        currentQuery = $("#input-busqueda").val();
        //console.log("BUSCANDO:", currentQuery);

        cargarPacientes(URL_REGISTROS);
        actualizarLinkExcel();
    });

    // Permitir búsqueda al presionar Enter en el input
    function cargarPacientes(url) {
        let query = $("#input-busqueda").val();
        let fecha_inicio = $("#fecha_inicio").val();
        let fecha_fin = $("#fecha_fin").val();
        let tipo_documento = $("#tipo_documento").val();
        let filtro_edad = $("#filtro_edad").val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                query: query,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                tipo_documento: tipo_documento,
                filtro_edad: filtro_edad,
            },
            beforeSend: function () {
                $("#tabla-pacientes").html(
                    '<div class="text-center p-3">Cargando...</div>',
                );
            },
            success: function (data) {
                $("#tabla-pacientes").html(data);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                $("#tabla-pacientes").html(
                    '<div class="text-danger text-center p-3">Error al cargar los datos.</div>',
                );
            },
        });
    }

    // Función para actualizar el enlace de descarga de Excel con los filtros actuales
    function actualizarLinkExcel() {
        let url = URL_EXCEL;

        let query = $("#input-busqueda").val();
        let fecha_inicio = $("#fecha_inicio").val();
        let fecha_fin = $("#fecha_fin").val();
        let tipo_documento = $("#tipo_documento").val();
        let filtro_edad = $("#filtro_edad").val();

        if (query) {
            url += "?query=" + encodeURIComponent(query);
        }

        if (fecha_inicio) {
            url +=
                (url.includes("?") ? "&" : "?") +
                "fecha_inicio=" +
                fecha_inicio;
        }

        if (fecha_fin) {
            url += (url.includes("?") ? "&" : "?") + "fecha_fin=" + fecha_fin;
        }

        if (tipo_documento) {
            url +=
                (url.includes("?") ? "&" : "?") +
                "tipo_documento=" +
                encodeURIComponent(tipo_documento);
        }

        if (filtro_edad) {
            url +=
                (url.includes("?") ? "&" : "?") +
                "filtro_edad=" +
                encodeURIComponent(filtro_edad);
        }

        console.log(url); // 👈 mira esto en la consola

        $("#btn-excel").attr("href", url);
    }
});
