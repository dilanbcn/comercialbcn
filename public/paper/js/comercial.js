$(function() {
    $('#tablaComercialesIdex').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
        }
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    showMessage();


    // BOTON ELIMINAR
    $(".delRegistro").on("click", function(e) {
        e.preventDefault();

        // let nameForm = $(this).closest("form").attr('id');
        let nameTitle = $(this).attr('title');
        let recursivo = $(this).data('recurs');
        let ruta = $(this).data('ruta');
        let textherencia = $(this).data('textherencia');
        let textMsg = (textherencia != undefined) ? 'Al eliminar este registro, ' + textherencia + ', desea continuar?' : 'Al eliminar este registro, se eliminarán todos los que dependen de el, desea continuar?';

        $.confirm({
            title: nameTitle,
            content: '¿Esta seguro que desea eliminar este registro?',
            type: 'red',
            theme: 'modern',
            animation: 'scala',
            icon: 'fa fa-question-circle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: 'Eliminar',
                    btnClass: 'btn-red',
                    action: function() {

                        if (recursivo == '1') {
                            $.confirm({
                                title: 'Eliminar Herencia',
                                content: textMsg,
                                type: 'dark',
                                theme: 'modern',
                                animation: 'scala',
                                icon: 'fa fa-exclamation-triangle',
                                typeAnimated: true,
                                buttons: {
                                    confirm: {
                                        text: 'Eliminar',
                                        btnClass: 'btn-secondary',
                                        action: function() {
                                            $('#frm_del_registro').attr('action', ruta);
                                            $("#frm_del_registro").submit();
                                        },
                                    },
                                    cancel: {
                                        text: 'Cancelar',
                                    },
                                }
                            });
                        } else {
                            $('#frm_del_registro').attr('action', ruta);
                            $("#frm_del_registro").submit();
                        }
                    },
                },
                cancel: {
                    text: 'No',
                },
            }
        });
    });

    // USUARIO
    $("#usr_create_rut, #inst_create_rut").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 75 || key == 107)
    });

    $("#usr_create_rut").on('blur', function(e) {
        let valor = $(this).val();
        if (valor) {
            let rut = valor.substring(0, valor.length - 1) + '-' + valor.substring(valor.length - 1, valor.length);
            $(this).val(rut);
        }
    }).on('focus', function() {
        let valor = $(this).val();
        if (valor) {
            let datos = valor.replace('-', '');
            $(this).val(datos)
        }
    });


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
                console.log('file: comercial.js -> line 118 -> $ -> data', data);
                if (data.success == 'ok') {
                    $('#frm_update_proyectos').attr('action', rutaUpdate);
                    $("#nombre").val(data.nombre);
                    $("#fechaCierre").val(data.fecha_cierre);
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

    showModalWithErrors();


    // FACTURAS
    $("#btnFactura").on('click', function() {
        $(".inpt-metodo").val('post');
        limpiarModalFactura();
        $("#modal_factura_proyecto").modal('show');
    });

    $(".inputNumber").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 44)
    }).on('keyup', function(e) {
        $(this).val(format_moneda($(this).val()));
    });

    $(".btnFactEdit").on('click', function() {
        $(".inpt-metodo").val('put');
        let rutaEdit = $(this).data('editar');
        let rutaUpdate = $(this).data('actualizar');
        $(".inpt-ruta").val(rutaUpdate);
        limpiarModalFactura(true);

        $.ajax({
            url: rutaEdit,
            success: function(data) {
                if (data.success == 'ok') {
                    $('#frm_update_facturas').attr('action', rutaUpdate);
                    $("#fechaFacturacion").val(data.fecha_factura);
                    $("#fechaPago").val(data.fecha_pago);
                    $("#inscripcionSence").val(data.inscripcion_sence);
                    $("#montoVenta").val(data.monto_venta);
                    $("#estado").val(data.estado_factura_id);
                    $("#modal_update_factura_proyecto").modal('show');
                } else {
                    limpiarModalFactura();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#modal_update_factura_proyecto").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos de la factura, intente de nuevo mas tarde',
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

    $('.chart').easyPieChart({
        easing: 'easeOutBounce',
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        },
        size: 60,
        barColor: '#20c997',
        lineWidth: 5
    });

});

function showMessage() {
    let msg = $("#msg-data").val();
    let titulo = $("#msg-data").data('titulo');
    let estilo = $("#msg-data").data('estilo');
    if (msg) {
        toastr[estilo](msg, titulo);
        $("#msg-data").val('');
    }
}

function showModalWithErrors() {
    let error = $("#msg-modal").data('valor');
    let modalNew = $("#msg-modal").data('nombre');
    let modalUpd = $("#msg-modal").data('update');
    let metodo = $(".inpt-metodo").val();

    let modal = (metodo == 'put') ? modalUpd : modalNew;



    if (error == 1) {
        $("#" + modal).modal('show');

        if (metodo == 'put') {
            $('#frm_update_proyectos').attr('action', $(".inpt-ruta").val());
            $('#frm_update_facturas').attr('action', $(".inpt-ruta").val());
        }
    }
}

var format_moneda = function(num, type = null) {
    var str = num.toString().replace(",,", ""),
        parts = false,
        output = [],
        i = 1,
        formatted = null;
    if (!$.isNumeric(str.substr(0, 1))) {
        str = "";
    }
    if (str.substr(0, 2) == '00' && type == 'N') {
        str = "";
    }
    if (str.substr(0, 1) == '0' && str.substr(1, 1) > 0) {
        str = str.substr(1, str.length);
    }
    if (str.indexOf(",") > 0) {
        parts = str.split(",");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (var j = 0, len = str.length; j < len; j++) {
        if (str[j] != ".") {
            output.push(str[j]);
            if (i % 3 == 0 && j < (len - 1)) {
                output.push(".");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");

    let decimal = 2;
    let valorFormateado = formatted + ((parts) ? "," + parts[1].substr(0, decimal) : "");
    if (type == 'N') {
        decimal = 0;
        valorFormateado = formatted + ((parts) ? parts[1].substr(0, decimal) : "");
    }

    return (valorFormateado);
};

function limpiarModalFactura(upd = false) {

    if (upd) {
        $(".fechaFacturacion").removeClass('is-invalid');
        $(".fechaPago").removeClass('is-invalid');
        $(".inscripcionSence").removeClass('is-invalid');
        $(".montoVenta").removeClass('is-invalid');
        $(".estado").removeClass('is-invalid');
    } else {
        $(".fechaFacturacion").val('').removeClass('is-invalid');
        $(".fechaPago").val('').removeClass('is-invalid');
        $(".inscripcionSence").val('').removeClass('is-invalid');
        $(".montoVenta").val('').removeClass('is-invalid');
        $(".estado").val('').removeClass('is-invalid');
    }

    $(".invalid-feedback").hide();
}

function limpiarModalProyecto(upd = false) {

    if (upd) {
        $(".nombre").removeClass('is-invalid');
        $(".fechaCierre").removeClass('is-invalid');
    } else {
        $(".nombre").val('').removeClass('is-invalid');
        $(".fechaCierre").val('').removeClass('is-invalid');
    }

    $(".invalid-feedback").hide();
}