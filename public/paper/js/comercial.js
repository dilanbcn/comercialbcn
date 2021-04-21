$(function() {

    $('.tablaComercialesIndex thead tr').clone(true).appendTo('.tablaComercialesIndex thead');
    $('.tablaComercialesIndex thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();

        if (title != 'Acciones' && title != 'Seleccionar') {
            if (title == 'Comercial') {
                let valor = ($("#tableCliente").data('comercial')) ? $("#tableCliente").data('comercial') : '';
                $(this).html('<input type="text" placeholder="Filtrar ' + title + '" value="' + valor + '" />');
            } else {
                $(this).html('<input type="text" placeholder="Filtrar ' + title + '" />');
            }

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
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
        },
        scrollCollapse: true,
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        dom: '<lif<t>p>',
        initComplete: function(settings, json) {
            if ($("#tableCliente").data('comercial') != undefined) {
                table.column(2)
                    .search($("#tableCliente").data('comercial'))
                    .draw()
            }

        }

    });

    $('.tablaLlamados').DataTable({
        scrollX: true,
        responsive: true,
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        dom: '<lif<t>p>',
        columns: [
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
            { "width": "60px" },
        ]
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

    $('.selectpicker').selectpicker();

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



    showModalPassWithErrors();

    showModalWithErrors();

    // FACTURAS

    let nuevo = document.querySelectorAll('.pieChart');
    nuevo.forEach(element => {
        let ctxP = element.getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'doughnut',
            data: {
                labels: ["Activos", "Inactivos"],
                datasets: [{
                    data: [element.dataset.act, element.dataset.inact],
                    backgroundColor: ["#38D430", "#001B65"],
                    hoverBackgroundColor: ["#FF5A5E", "#FF5A5E"]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                }
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

    // $(".btnInicio").on('click', function() {
    //     let rutaUpdate = $(this).data('ruta');
    //     let fechaInicio = $(this).data('fecha');
    //     $('#frm_inicio_relacion').attr('action', rutaUpdate);
    //     $('#inp_inicio_relacion').val(fechaInicio);
    //     $("#modal_inicio_relacion").modal('show');
    // });


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

    $(".disRegistro").on("click", function(e) {
        e.preventDefault();
        let nameTitle = $(this).attr('title');
        let ruta = $(this).data('ruta');

        $.confirm({
            title: nameTitle,
            content: '¿Esta seguro que desea desechar este cliente?',
            type: 'orange',
            theme: 'modern',
            animation: 'scala',
            icon: 'fa fa-question-circle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: 'Desechar',
                    btnClass: 'btn-warning',
                    action: function() {
                        $('#frm_validar_reunion').attr('action', ruta);
                        $("#frm_validar_reunion").submit();
                    },
                },
                cancel: {
                    text: 'No',
                },
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
        $('.selectpicker').selectpicker('refresh');
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

    $(".comunicacionEdit").on('click', function() {
        let id = $(this).attr('id');
        let rutaEdit = '/cliente-comunicacion/' + id + '/edit';
        editarComunicacion(rutaEdit, id);
    });

    // PRODUCTOS
    $("#btnModalProd").on('click', function() {
        $(".inpt-metodo").val('post');
        // limpiarModalProducto();
        $("#add_producto").modal('show');
    });

    // USER
    $("#cambioPass").on('click', function() {
        $("#modal_cambio_pass").modal('show');
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

function showModalPassWithErrors() {
    let error = $("#modal_cambio_pass").data('valorpass');
    if (error == 1) {
        $("#msg-modal").data('valor', 0);
        $("#modal_cambio_pass").modal('show');
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