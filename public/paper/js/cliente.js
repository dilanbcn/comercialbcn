$(function() {

    $("#holding").autocomplete({
        source: function(request, response) {
            let ruta = $('#holding').data('rutaholding');
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
        minLength: 2
    });

    $('#tablaClientes thead tr').clone(true).appendTo('#tablaClientes thead');
    $('#tablaClientes thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != 'Seleccionar') {

            if (title == 'Comercial') {
                let valor = ($("#tablaClientes").data('comercial')) ? $("#tablaClientes").data('comercial') : '';
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

    var table = $('#tablaClientes').DataTable({
        language: {
            url: "/paper/js/spanish.json",
        },
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'" + $("#tablaClientes").data("rolexportar") + ">>" +
            "<'row mb-3'<'col-sm-9'i><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        buttons: [{
            extend: 'collection',
            text: 'Exportar',
            className: 'btn-sm btn-round dropdown-toggle',
            disable: true,
            buttons: [{
                    extend: 'excelHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    autoFilter: true,
                    sheetName: 'Clientes General',
                    title: 'Clientes General',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-excel"></i> Excel'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Clientes General',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-pdf"></i> Pdf'
                },
            ]
        }, {
            hide: true,
            className: 'btn-sm btn-round ml-1 btn-warning myButtonClass',
            text: 'Reiniciar Ciclo',
            action: function(e, dt, node, config) {
                restoreCiclo();
            }
        }],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/clientes-all/null",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let admin = $("#tablaClientes").data('rol');
                    let user = $("#tablaClientes").data('user');
                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';
                    let rutaProyecto = $("#tablaClientes").data('rutaproyecto');
                    let rutaContacto = $("#tablaClientes").data('rutacontacto');
                    let rutaEditar = $("#tablaClientes").data('rutaeditar');
                    let rutaDesechar = $("#tablaClientes").data('rutadesechar');
                    let rutaEliminar = $("#tablaClientes").data('rutaeliminar');

                    let btnDes = (row[8]) ? '<button class="btn btn-xs btn-outline-warning" data-accion="btnDes" data-ruta="' + rutaDesechar.replace("@@", row[9]) + '"><i class="fa fa-recycle"></i></button>' : '';
                    let btnNotif = '<button class="btn btn-xs btn-outline-info" data-accion="btnNotif"><i class="far fa-bell"></i></button>';

                    if ((user == row[8] && !admin) || (user == row[10] && !admin)) {
                        celda += '<a href="' + rutaProyecto.replace("@@", row[9]) + '" title="Tickets" class="btn btn-xs btn-outline-secondary" data-accion="btnProy"><i class="far fa-handshake"></i></a>';
                        celda += btnNotif;
                        celda += btnDes;
                    }

                    if (admin) {
                        celda += '<a href="' + rutaProyecto.replace("@@", row[9]) + '" title="Tickets" class="btn btn-xs btn-outline-secondary" data-accion="btnProy"><i class="far fa-handshake"></i></a>';
                        celda += '<a href="' + rutaContacto.replace("@@", row[9]) + '" title="Contactos" class="btn btn-xs btn-outline-secondary" data-accion="btnCon"><i class="fas fa-user-friends"></i></a>';
                        celda += '<a href="' + rutaEditar.replace("@@", row[9]) + '"  title="Editar" class="btn btn-xs btn-outline-secondary" data-accion="btnEdi"><i class="fa fa-edit"></i></a>';
                        celda += btnDes;
                        celda += btnNotif;
                        celda += '<button class="btn btn-xs btn-outline-danger" data-accion="btnEli" data-ruta="' + rutaEliminar.replace("@@", row[9]) + '"><i class="fa fa-times"></i></a>';
                    }
                    celda += '</div>';

                    return celda;
                }
            },
            { targets: [3, 4, 5], className: "text-center" },
            {
                targets: 3,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let badged = (row[3] == "Cliente") ? "badge-cliente" : "badge-prospecto";

                    return '<span class="badge p-2 ' + badged + '">' + row[3] + '</span>';

                },
            },
        ],
        initComplete: function(settings, json) {
            if ($("#tablaClientes").data('comercial') != undefined) {
                table.column(2)
                    .search($("#tablaClientes").data('comercial'))
                    .draw()
            }
            if ($("#tablaClientes").data('rol')) {
                $(".myButtonClass").show();
            }

        },
        headerCallback: function(settings, json) {
            $(".myButtonClass").hide();
        }
    });


    table.buttons().container().appendTo('#tablaClientes_wrapper .col-md-6:eq(0)');

    $("#tablaClientes tbody").on("click", 'button', function(e) {
        e.preventDefault();

        let showMsg = true;
        let accion = $(this).data('accion');
        let ruta = $(this).data('ruta');
        let estilo = {
            titulo: "Titulo",
            contenido: 'Contenido',
            color: 'orange',
            icono: 'fa fa-question-circle',
            boton: {
                texto_ok: 'Aceptar',
                clase_ok: 'btn-warning',
            },
            accion: 1
        };

        switch (accion) {
            case "btnDes":
                estilo.titulo = "Desechar Cliente";
                estilo.contenido = '¿Esta seguro que desea desechar este cliente?';
                estilo.boton.texto_ok = "Desechar";
                estilo.accion = 1;
                estilo.icono = 'fas fa-recycle';
                break;
            case "btnEli":
                estilo.titulo = "Eliminar Cliente";
                estilo.contenido = '¿Esta seguro que desea eliminar este cliente?';
                estilo.color = 'red';
                estilo.boton.texto_ok = "Eliminar";
                estilo.boton.clase_ok = "btn-danger";
                estilo.accion = 2;
                estilo.icono = 'fas fa-trash-alt';
                break;
            case "btnNotif":
                let data = table.row($(this).parents('tr')).data();
                let admin = $("#tablaClientes").data('rol');

                let destino = (data[11]) ? (admin ? data[8] : data[11]) : data[8];
                let nomDestino = (data[11]) ? (admin ? data[2] : data[12]) : data[2];

                let strRuta = $("#frm_modal_notificacion_comercial").attr('action');
                let ruta = strRuta.replace("des@", destino).replace("cli@", data[9]);

                showMsg = false;

                $(".inpt-metodo").val('post');
                $("#not_contenido").val('');
                $("#frm_modal_notificacion_comercial").attr('action', ruta);
                $("#inptNomComercial").html(nomDestino);
                $("#inptNomCliente").html(data[1]);
                $("#modal_notificacion_comercial").modal('show');

                break;
        }

        if (showMsg) {
            $.confirm({
                title: estilo.titulo,
                content: estilo.contenido,
                type: estilo.color,
                theme: 'modern',
                animation: 'scala',
                icon: estilo.icono,
                typeAnimated: true,
                buttons: {
                    confirm: {
                        text: estilo.boton.texto_ok,
                        btnClass: estilo.boton.clase_ok,
                        action: function() {

                            if (estilo.accion == 1) {
                                desCliente(ruta);

                            } else {
                                eliCliente(ruta);
                            }

                        },
                    },
                    cancel: {
                        text: 'No',
                    },
                }
            });
        }
    });
});

function restoreCiclo() {
    $.confirm({
        title: 'Reiniciar Ciclo',
        content: '¿Esta seguro de reiniciar el ciclo de todos los prpospectos?',
        type: 'orange',
        theme: 'modern',
        animation: 'scala',
        icon: 'fas fa-undo',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: 'Reiniciar',
                btnClass: 'btn-warning',
                action: function() {
                    let rutaRestart = $('#tablaClientes').data('rutarestart');

                    $.ajax({
                        url: rutaRestart,
                        type: 'POST',
                        success: function(data) {
                            if (data.success == 'ok') {
                                toastr['success'](data.msg, data.title);
                            }
                            $('#tablaClientes').DataTable().ajax.reload();
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            toastr['danger']('Error al intentar reiniciar el ciclo', 'Error');

                        }
                    });

                },
            },
            cancel: {
                text: 'No',
            },
        }
    });
}

function desCliente(rutaDes) {
    $.ajax({
        url: rutaDes,
        type: 'POST',
        data: {
            "rutaDestino": true
        },
        success: function(data) {
            if (data.success == 'ok') {
                toastr['success'](data.msg, data.title);
            }
            $('#tablaClientes').DataTable().ajax.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            toastr['danger']('Error al intentar desechar un cliente', 'Error');

        }
    });
}

function eliCliente(rutaDel) {

    $.ajax({
        url: rutaDel,
        type: 'DELETE',
        data: {
            "rutaDestino": true
        },
        success: function(data) {
            if (data.success == 'ok') {
                toastr['success'](data.msg, data.title);
            }
            $('#tablaClientes').DataTable().ajax.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            toastr['danger']('Error al intentar eliminar un cliente', 'Error');

        }
    });
}