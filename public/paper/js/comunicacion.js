$(function() {

    $('#tablaComunicacion thead tr').clone(true).appendTo('#tablaComunicacion thead');
    $('#tablaComunicacion thead tr:eq(1) th').each(function(i) {
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
    var table = $('#tablaComunicacion').DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        dom: '<lif<t>p>',
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/cliente-comunicacion-json",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';
                    let rutaEdit = $("#tablaComunicacion").data('rutaedit');
                    let rutaComunicacion = $("#tablaComunicacion").data('rutacomunicacion');

                    celda += '<button data-accion="btnVer" id="' + row[4] + '" data-rutaedit="' + rutaEdit.replace("@@", row[4]) + '" title="Ver" class="btn btn-xs btn-outline-secondary"><i class="fas fa-eye"></i></button>';
                    celda += '<button data-accion="btnAdd" id="' + row[4] + '" title="Agregar" class="btn btn-xs btn-outline-secondary"><i class="fas fa-comment-medical"></i></button>';

                    if (row[5] > 0) {
                        celda += '<a href="' + rutaComunicacion.replace("@@", row[4]) + '" title="Ver Conversación" class="btn btn-xs btn-outline-secondary"><i class="far fa-comments"></i></a>';
                    }

                    celda += '</di>';

                    return celda;

                },
            },
            {
                targets: 3,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let badged = (row[3] == "Activos") ? "badge-activos" : "badge-inactivos";

                    return '<span class="badge p-2 ' + badged + '">' + row[3] + '</span>';

                },
            }
        ],

    });

    // table.columns([-1]).visible($("#tablaComunicacion").data('rol'));

    $("#tablaComunicacion tbody").on("click", 'button', function(e) {
        e.preventDefault();

        let accion = $(this).data('accion');
        let clienteId = $(this).attr("id");
        let urlForm = $(this).data('rutaedit');

        switch (accion) {
            case "btnVer":
                let ruta = './cliente/' + clienteId;
                $.ajax({
                    url: ruta,
                    success: function(data) {
                        if (data.success == 'ok') {

                            let strFechaInicio = '';
                            if (data.inicio_relacion) {
                                let fechaIni = new Date(data.inicio_relacion.split('-'));
                                strFechaInicio = fechaIni.getDay() + '/' + fechaIni.getMonth() + '/' + fechaIni.getFullYear();
                            }

                            $("#holding").html((data.padre) ? data.padre.razon_social : '&nbsp;');
                            $("#comercial").html((data.user) ? data.user.name : '&nbsp;');
                            $("#tipo_cliente").html((data.tipo_cliente) ? data.tipo_cliente.nombre : '&nbsp;');
                            $("#inicio_relacion").html(strFechaInicio);
                            $("#estado").html((data.activo == 1) ? 'Activo' : 'Inactivo');
                            $('#nombre_cliente').html(data.razon_social);
                            $('#razon_social').val(data.razon_social);
                            $('#activo').val(data.activo);
                            $('#rut').html((data.rut_cliente) ? data.rut_cliente : '&nbsp;');
                            $('#rubro').html(data.rubro);
                            $("#telefono").html(data.telefono);
                            $('#correo').html(data.email);
                            $('#cantidadEmpleados').val((data.cantidad_empleados) ? data.cantidad_empleados : 0);
                            $('#direccion').html(data.direccion);
                            $("#modal_cliente").modal('show');
                            $("#frm_cliente_prosp").attr('action', urlForm);

                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $("#modal_cliente").modal('hide');
                        $.confirm({
                            title: 'Error',
                            content: 'Error al intentar obtener los datos del cliente, intente de nuevo mas tarde',
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

                break;
            case "btnAdd":
                $("#opt_cliente").val(clienteId);
                $("#opt_cliente option[value='" + clienteId + "']").prop("selected", true);
                $('.selectpicker').selectpicker('refresh');
                $("#add_cliente_comunicacion").modal('show');

                $.ajax({
                    url: './cliente-contacto-json/' + clienteId,
                    success: function(contactos) {
                        let optSel = '<option value="" selected>[Seleccione]</option>';
                        if (contactos.length > 0) {
                            $.each(contactos, function(key, contacto) {
                                optSel += '<option value="' + contacto.id + '" >' + contacto.nombre + ' ' + contacto.apellido + '</option>';
                            });
                        }
                        $("#contactoId").html('').append(optSel);
                    }
                });
                break;
        }
    });


});