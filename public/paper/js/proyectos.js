$(function() {

    // PROYECTO
    $("#btnModalProy").on('click', function() {
        $(".inpt-metodo").val('post');
        limpiarModalProyecto();
        $("#add_proyecto_cliente").modal('show');
    });

    $(".btnProyEdit").on('click', function() {

        $(".inpt-metodo").val('put');
        let rutaEdit = $(this).data('editar');
        let rutaUpdate = $(this).data('actualizar');
        $(".inpt-ruta").val(rutaUpdate);
        limpiarModalProyecto(true);

        $.ajax({
            url: rutaEdit,
            success: function(data) {
                console.log('file: proyectos.js -> line 21 -> $ -> data', data);
                if (data.success == 'ok') {
                    $('#frm_update_proyectos').attr('action', rutaUpdate);
                    $("#nombre").val(data.nombre);
                    $("#fechaCierre").val(data.fecha_cierre);
                    $("#fechaFacturacion").val(data.proyecto_facturas.fecha_factura);
                    $("#inscripcionSence").val(data.proyecto_facturas.inscripcion_sence);
                    $("#montoVenta").val(data.proyecto_facturas.monto_venta);
                    $("#estado").val(data.proyecto_facturas.estado_factura_id);
                    $("#update_proyecto_cliente").modal('show');
                } else {
                    limpiarModalProyecto();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#update_proyecto_cliente").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos del proyecto, intente de nuevo mas tarde',
                    type: 'red',
                    theme: 'modern',
                    animation: 'scala',
                    icon: 'fa fa-exclamation-triangle',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            text: 'Aceptar',
                        },
                    }
                });
            }
        });
    });

    $(".inpt-proynombre").autocomplete({
        source: function(request, response) {
            let ruta = $('.inpt-proynombre').data('rutaproyectos');
            $.ajax({
                url: ruta,
                type: 'POST',
                dataType: "json",
                data: {
                    search: request.term,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
    });

    $(".inputNumber").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 44)
    }).on('keyup', function(e) {
        $(this).val(format_moneda($(this).val()));
    });

});

function limpiarModalProyecto(upd = false) {

    if (upd) {
        $(".nombre").removeClass('is-invalid');
        $(".fechaCierre").removeClass('is-invalid');
        $(".fechaFacturacion").removeClass('is-invalid');
        $(".inscripcionSence").removeClass('is-invalid');
        $(".montoVenta").removeClass('is-invalid');
        $(".estado").removeClass('is-invalid');
    } else {
        $(".nombre").val('').removeClass('is-invalid');
        $(".fechaCierre").val('').removeClass('is-invalid');
        $(".fechaFacturacion").val('').removeClass('is-invalid');
        $(".inscripcionSence").val('').removeClass('is-invalid');
        $(".montoVenta").val('').removeClass('is-invalid');
        $(".estado").val('').removeClass('is-invalid');
    }

    $(".invalid-feedback").hide();
}