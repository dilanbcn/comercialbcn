$(function() {

    $('.tablaComercialesIndex thead tr').clone(true).appendTo('.tablaComercialesIndex thead');
    $('.tablaComercialesIndex thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != 'Seleccionar') {
            $(this).html('<input type="text" placeholder="Filtrar ' + title + '" />');
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        } else {
            $(this).html('');
        }
    });

    var table = $('.tablaComercialesIndex').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
        },
        "orderCellsTop": true,
        "fixedHeader": true,
    });

    $('.tablaIndicadores').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
        },
        order: [
            [0, 'asc']
        ],
        rowGroup: {
            dataSrc: 0
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
        let textMsg = (textherencia != undefined) ? 'Al eliminar este registro, ' + textherencia + ', ¿desea continuar?' : 'Al eliminar este registro, se eliminarán todos los que dependen de el, ¿desea continuar?';

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

    // CLIENTE
    $("#btnModalContacto").on('click', function() {
        $(".inpt-metodo").val('post');
        limpiarModalCliente();
        $("#add_contacto_cliente").modal('show');
    });

    $(".btnContactoEdit").on('click', function() {
        $(".inpt-metodo").val('put');
        let rutaEdit = $(this).data('editar');
        let rutaUpdate = $(this).data('actualizar');
        $(".inpt-ruta").val(rutaUpdate);
        limpiarModalCliente(true);

        $.ajax({
            url: rutaEdit,
            success: function(data) {
                if (data.success == 'ok') {
                    $('#frm_update_cliente_contacto').attr('action', rutaUpdate);
                    $("#nombre").val(data.nombre);
                    $("#apellido").val(data.apellido);
                    $("#cargo").val(data.cargo);
                    $("#telefono").val(data.telefono);
                    $("#celular").val(data.celular);
                    $("#email").val(data.email);
                    $("#email_confirmation").val(data.email);
                    $('#activo').bootstrapToggle((data.activo == 1) ? 'on' : 'off');
                    $("#modal_update_cliente_contacto").modal('show');
                } else {
                    limpiarModalCliente();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#modal_update_cliente_contacto").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos de contacto, intente de nuevo mas tarde',
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

    //PROSPECCION
    $("#btnModalContactoPros").on('click', function() {
        $(".inpt-metodo").val('post');
        limpiarModalCliente();
        $("#add_prospeccion_contacto").modal('show');
    });

    $(".btnProspContacto").on('click', function() {
        $(".inpt-metodo").val('put');
        let rutaEdit = $(this).data('editar');
        let rutaUpdate = $(this).data('actualizar');
        $(".inpt-ruta").val(rutaUpdate);
        limpiarModalCliente(true);

        $.ajax({
            url: rutaEdit,
            success: function(data) {
                if (data.success == 'ok') {
                    $('#frm_update_prospeccion_contacto').attr('action', rutaUpdate);
                    $("#cliente option[value='" + data.cliente_id + "']").attr("selected", true);
                    $("#nombre").val(data.nombre);
                    $("#apellido").val(data.apellido);
                    $("#cargo").val(data.cargo);
                    $("#telefono").val(data.telefono);
                    $("#celular").val(data.celular);
                    $("#email").val(data.email);
                    $("#email_confirmation").val(data.email);
                    $('#activo').bootstrapToggle((data.activo == 1) ? 'on' : 'off');
                    $("#modal_update_prospeccion_contacto").modal('show');
                } else {
                    limpiarModalCliente();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#modal_update_cliente_contacto").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos de contacto, intente de nuevo mas tarde',
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

    $("#filtro").on("change", function() {
        $("#frm_filtro_asignacion").submit();
    });

    $("#btnAsingProsp").on("click", function() {

        let arrChk = getSeleccionados();
        let trs = "";
        if (arrChk.length > 0) {
            $(".inpt-metodo").val('post');
            $("#tableSelect > tbody").html("");
            $.each(arrChk, function(key, check) {
                $('#tableSelect > tbody:last-child').append('<tr class="text-center trTable" id="tr_' + $(check).attr('id') + '"><td>' + $(check).data('rut') + '<input type="hidden" name="usuario[]" value="' + $(check).attr('id') + '"></td><td>' + $(check).data('nom') + '</td><td>' + $(check).data('ape') + '</td><td><a href="#" id="' + $(check).attr('id') + '" title="Quitar Comercial" class="btn btn-xs btn-outline-danger quitComercial"><i class="fa fa-times"></i></a></td></tr>');
            });
            $("#asing_prospector").modal('show');
            $(".quitComercial").on('click', function() {
                let idTr = $(this).attr('id');
                $('#tr_' + idTr).remove();
                let totalTr = $('.trTable').get();
                if (totalTr.length <= 0) {
                    $("#asing_prospector").modal('hide');
                }
            });

        } else {
            $.confirm({
                title: 'Atención',
                content: 'Debe seleccionar al menos un comercial',
                type: 'orange',
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

    // COMUNICACION
    $(".btnAddMeeting").on('click', function() {
        $(".inpt-metodo").val('post');
        let idCliente = $(this).data('cliente');

        limpiarModalMeeting();
        $("#add_cliente_comunicacion").modal('show');
        if (idCliente) {
            $("#cliente option[value='" + idCliente + "']").prop("selected", true);
        } else {
            $("#cliente option:eq(0)").prop("selected", true);
        }
    });

    $("#btnAddComunicacion").on('click', function() {
        $(".inpt-metodo").val('post');
        limpiarModalMeeting();
        $("#add_comunicacion_conversacion").modal('show');
    });

    $(".btnEditComunicacion").on('click', function() {
        $(".inpt-metodo").val('put');
        let rutaEdit = $(this).data('editar');
        let rutaUpdate = $(this).data('actualizar');
        $(".inpt-ruta").val(rutaUpdate);
        limpiarModalMeeting(true);
        $.ajax({
            url: rutaEdit,
            success: function(data) {
                if (data.success == 'ok') {
                    if (data.fecha_reunion) {
                        let fecha = data.fecha_reunion.split(' ');
                        $("#fechaReunion").val(fecha[0]);
                        $("#horaReunion").val(fecha[1].substring(0, 5));
                    }
                    $('#frm_upd_comunicacion_conversacion').attr('action', rutaUpdate);
                    $("#updt_contactoId").val(data.cliente_contacto_id);
                    $("#updt_fechaContacto").val(data.fecha_contacto);
                    $("#updt_observaciones").val(data.observaciones);
                    $('#updt_tipoComunicacion').val(data.tipo_comunicacion_id);
                    $('#updt_linkedin').bootstrapToggle((data.linkedin == 1) ? 'on' : 'off');
                    $('#updt_envioCorreo').bootstrapToggle((data.envia_correo == 1) ? 'on' : 'off');
                    $('#updt_respuesta').bootstrapToggle((data.respuesta == 1) ? 'on' : 'off');

                    $("#upd_comunicacion_conversacion").modal('show');
                } else {
                    limpiarModalMeeting();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#upd_comunicacion_conversacion").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos de comunicación, intente de nuevo mas tarde',
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

    $(".validarReunion").on('click', function() {
        let ruta = $(this).data('ruta');
        $.confirm({
            title: 'Validar Reunión',
            content: '¿Está seguro que desea validar esta reunión?',
            type: 'green',
            theme: 'modern',
            animation: 'scala',
            icon: 'fa fa-question-circle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: 'Validar',
                    btnClass: 'btn-success',
                    action: function() {
                        $('#frm_validar_reunion').attr('action', ruta);
                        $("#frm_validar_reunion").submit();
                    },
                },
                cancel: {
                    text: 'Cancelar',
                },
            }
        });
    });

    $("#nuevoContacto, #updt_nuevoContacto").on('change', function() {
        let data = $(this).prop('checked');

        if (data) {
            $("#rowContacto, #updt_rowContacto").removeClass('d-none');
            $("#contactoId, #updt_contactoId").val('');
        } else {
            $("#rowContacto, #updt_rowContacto").addClass('d-none');
        }

        limpiarDatosContacto();
    });

    $("#contactoId").on('change', function() {
        $('#nuevoContacto, #updt_nuevoContacto').bootstrapToggle('off');
    });

    $(".optCliente").on('change', function() {
        let cliente = $(this).val();

        if (cliente != "") {

            $("#nuevoContacto, #updt_nuevoContacto").prop('checked', false).change();
            limpiarDatosContacto(true);
            buscarContactos(cliente);
        } else {
            $("#contactoId, #updt_contactoId").html('').append('<option value="" selected>[Seleccione]</option>');
            limpiarDatosContacto($(this).prop('checked'));
        }


    });

});

function limpiarDatosContacto() {
    $("#nombreContacto, #updt_nombreContacto").val('').removeClass('is-invalid');
    $("#apellidoContacto, #updt_apellidoContacto").val('').removeClass('is-invalid');
    $("#cargoContacto, #updt_cargoContacto").val('').removeClass('is-invalid');
    $("#fonoContacto, #updt_fonoContacto").val('').removeClass('is-invalid');
    $("#celularContacto, #updt_celularContacto").val('').removeClass('is-invalid');
    $("#correoContacto, #updt_correoContacto").val('').removeClass('is-invalid');
}

function getSeleccionados() {
    let arrSel = new Array;

    arrSel = $('[name="activo[]"]:checked').get();

    return arrSel;
}

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
            $('.frm_modal_update').attr('action', $(".inpt-ruta").val());
        }
    }

    showContactos(error);
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

function limpiarModalCliente(upd = false) {

    if (upd) {
        $(".nombre, .apellido, .cargo, .telefono, .celular, .email, .cliente").removeClass('is-invalid');
    } else {
        $(".nombre, .apellido, .cargo, .telefono, .celular, .email, .cliente").val('').removeClass('is-invalid');
    }

    $(".invalid-feedback").hide();
}

function limpiarModalMeeting(upd = false) {
    if (upd) {
        $(".nombre, .apellido, .cargo, .telefono, .celular, .email, .cliente").removeClass('is-invalid');
    } else {
        $(".nombre, .apellido, .cargo, .telefono, .celular, .email, .cliente").val('').removeClass('is-invalid');
    }
    $(".invalid-feedback").hide();
}

function showContactos(error) {
    if (error == 1) {
        let cliente = $("#updt_cliente").val();
        if (cliente) {
            buscarContactos(cliente);
        } else {
            $("#updt_tipoComunicacion option[value='']").prop('selected', true);
        }
    }
}

function buscarContactos(cliente) {
    let oldContacto = $("#updt_reunion").data('contacto');
    $.ajax({
        url: './cliente-contacto-json/' + cliente,
        success: function(data) {
            let optSel = '<option value="" selected>[Seleccione]</option>';
            if (data.length > 0) {
                $.each(data, function(key, contacto) {
                    seleccionado = (contacto.id == oldContacto) ? 'selected' : '';
                    optSel += '<option value="' + contacto.id + '" ' + seleccionado + '>' + contacto.nombre + ' ' + contacto.apellido + '</option>';
                });
            }
            $("#contactoId, #updt_contactoId").html('').append(optSel);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $.confirm({
                title: 'Error',
                content: 'Error al intentar obtener los datos de los contactos, intente de nuevo mas tarde',
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
}