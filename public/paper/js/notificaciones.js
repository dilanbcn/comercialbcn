$(function() {

    $('#tablaNotificaciones thead tr').clone(true).appendTo('#tablaNotificaciones thead');
    $('#tablaNotificaciones thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != '') {
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

    var table = $('#tablaNotificaciones').DataTable({
        language: {
            url: "/paper/js/spanish.json",
        },
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row mb-3'<'col-sm-9'i>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        buttons: [{
            text: 'Nueva',
            className: 'btn-sm btn-round btn-secondary',
            action: function(e, dt, node, config) {
                $(".inpt-metodo").val('post');
                // limpiarModalCliente();
                $("#modal_notificacion").modal('show');
            }
        }, {
            extend: 'collection',
            text: 'Exportar',
            className: 'btn-sm btn-round dropdown-toggle',
            buttons: [{
                    extend: 'excelHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    autoFilter: true,
                    sheetName: 'Notificaciones',
                    title: 'Notificaciones',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-excel"></i> Excel</a>'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Notificaciones',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-pdf"></i> Pdf</a>'
                },
            ]
        }],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/notificaciones-json",
        columnDefs: [
            // {
            //         targets: -1,
            //         data: null,
            //         className: "text-center",
            //         render: function(data, type, row) {

            //             let admin = $("#tablaNotificaciones").data('rol');
            //             let user = $("#tablaNotificaciones").data('user');
            //             let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';
            //             let rutaProyecto = $("#tablaNotificaciones").data('rutaproyecto');
            //             let rutaContacto = $("#tablaNotificaciones").data('rutacontacto');
            //             let rutaEditar = $("#tablaNotificaciones").data('rutaeditar');
            //             let rutaDesechar = $("#tablaNotificaciones").data('rutadesechar');
            //             let rutaEliminar = $("#tablaNotificaciones").data('rutaeliminar');

            //             if (user == row[8] && !admin) {
            //                 celda += '<a href="' + rutaProyecto.replace("@@", row[9]) + '" title="Tickets" class="btn btn-xs btn-outline-secondary" data-accion="btnProy"><i class="far fa-handshake"></i></a>';
            //                 celda += '<button class="btn btn-xs btn-outline-warning" data-accion="btnDes" data-ruta="' + rutaDesechar.replace("@@", row[9]) + '"><i class="fa fa-recycle"></i></button>';
            //             }

            //             if (admin) {
            //                 celda += '<a href="' + rutaProyecto.replace("@@", row[9]) + '" title="Tickets" class="btn btn-xs btn-outline-secondary" data-accion="btnProy"><i class="far fa-handshake"></i></a>';
            //                 celda += '<a href="' + rutaContacto.replace("@@", row[9]) + '" title="Contactos" class="btn btn-xs btn-outline-secondary" data-accion="btnCon"><i class="fas fa-user-friends"></i></a>';
            //                 celda += '<a href="' + rutaEditar.replace("@@", row[9]) + '"  title="Editar" class="btn btn-xs btn-outline-secondary" data-accion="btnEdi"><i class="fa fa-edit"></i></a>';
            //                 celda += '<button class="btn btn-xs btn-outline-warning" data-accion="btnDes" data-ruta="' + rutaDesechar.replace("@@", row[9]) + '"><i class="fa fa-recycle"></i></a>';
            //                 celda += '<button class="btn btn-xs btn-outline-danger" data-accion="btnEli" data-ruta="' + rutaEliminar.replace("@@", row[9]) + '"><i class="fa fa-times"></i></a>';
            //             }
            //             celda += '</div>';

            //             return celda;
            //         }
            //     },
            { targets: [0, 1], className: "text-center" },
            //     {
            //         targets: 3,
            //         data: null,
            //         className: "text-center",
            //         render: function(data, type, row) {

            //             let badged = (row[3] == "Cliente") ? "badge-cliente" : "badge-prospecto";

            //             return '<span class="badge p-2 ' + badged + '">' + row[3] + '</span>';

            //         },
            // },


        ],
        // initComplete: function(settings, json) {
        // if ($("#tablaNotificaciones").data('comercial') != undefined) {
        //     table.column(2)
        //         .search($("#tablaNotificaciones").data('comercial'))
        //         .draw()
        // }

        // }
    });

    table.buttons().container().appendTo('#tablaNotificaciones_wrapper .col-md-6:eq(0)');

    $("#tablaNotificaciones tbody").on("click", 'button', function(e) {
        e.preventDefault();

        // let accion = $(this).data('accion');
        // let ruta = $(this).data('ruta');
        // let estilo = {
        //     titulo: "Titulo",
        //     contenido: 'Contenido',
        //     color: 'orange',
        //     icono: 'fa fa-question-circle',
        //     boton: {
        //         texto_ok: 'Aceptar',
        //         clase_ok: 'btn-warning',
        //     },
        //     accion: 1
        // };

        // switch (accion) {
        //     case "btnDes":

        //         estilo.titulo = "Desechar Cliente";
        //         estilo.contenido = '¿Esta seguro que desea desechar este cliente?';
        //         estilo.boton.texto_ok = "Desechar";
        //         estilo.accion = 1;

        //         break;
        //     case "btnEli":
        //         estilo.titulo = "Eliminar Cliente";
        //         estilo.contenido = '¿Esta seguro que desea eliminar este cliente?';
        //         estilo.color = 'red';
        //         estilo.boton.texto_ok = "Eliminar";
        //         estilo.boton.clase_ok = "btn-danger";
        //         estilo.accion = 2;
        //         break;
        // }

        // $.confirm({
        //     title: estilo.titulo,
        //     content: estilo.contenido,
        //     type: estilo.color,
        //     theme: 'modern',
        //     animation: 'scala',
        //     icon: estilo.icono,
        //     typeAnimated: true,
        //     buttons: {
        //         confirm: {
        //             text: estilo.boton.texto_ok,
        //             btnClass: estilo.boton.clase_ok,
        //             action: function() {

        //                 if (estilo.accion == 1) {
        //                     desCliente(ruta);

        //                 } else {
        //                     eliCliente(ruta);
        //                 }

        //             },
        //         },
        //         cancel: {
        //             text: 'No',
        //         },
        //     }
        // });
    });



    setTimeout(marcar, 4000);
    recientes();



});

function recientes() {
    let ruta = $("#tablaNotificaciones").data('rutarecientes');

    $.ajax({
        url: ruta,
        success: function(resp) {
            if (resp.data.length > 0) {

                let celda = '<div class="notif-timeline-v2"><div class="notif-timeline-v2__items">';

                $.each(resp.data, function(key, notificacion) {

                    let texto = (notificacion[2].length > 160) ? notificacion[2].substr(0, 160) + '...' : notificacion[2];

                    celda += '<div class="notif-timeline-v2" ><div class="notif-timeline-v2__item">';
                    celda += '<span class="notif-timeline-v2__item-time">' + notificacion[0] + '</span>';
                    celda += '<div class="notif-timeline-v2__item-cricle"><i class="' + notificacion[1] + '"></i></div>';
                    celda += '<div class="notif-timeline-v2__item-text text-justify pr-2"><p class="block-with-text p-with-text">' + notificacion[2] + '</p> <a href="#" class="showNotif mb-3" id="' + notificacion[3] + '">[más]</a></div>';
                    celda += '</div></div>';
                    celda += '<div class="notif-timeline-v2__footer pt-2 animated fadeIn bg-light" id="footer_' + notificacion[3] + '">';
                    celda += '<div class="row"><div class="col-8">' + notificacion[4] + '</div><div class="col-4 text-right">' + notificacion[5] + '</div></div>';
                    celda += '</div>';
                });

                celda += '</div></div>';

                $("#notifRecientes").html(celda);

            } else {
                $("#notifRecientes").html('<div class="d-flex justify-content-center">Sin Notificaciones</div>');
            }

            $(".showNotif").on('click', function() {
                let btn = $(this);
                let id = btn.attr("id");
                let selector = "#footer_" + id;


                $(selector).toggle("slow", function() {
                    let disp = $(this).css('display');
                    console.log('file: notificaciones.js -> line 255 -> $ -> disp', disp);
                    let label = '';

                    if (disp == 'none') {
                        label = '[más]';
                        btn.parent().find(".p-with-text").addClass('block-with-text');
                    } else {
                        label = '[menos]';
                        btn.parent().find(".p-with-text").removeClass('block-with-text');
                    }

                    btn.html(label)
                });

            });

        },
        beforeSend: function() {
            let loading = '<div class="d-flex justify-content-center"><div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div></div>';

            $("#notifRecientes").html(loading);
        },

    });


}

function marcar() {

    let rutaPush = $("#tablaNotificaciones").data('rutamarcar');
    let usuario = $("#tablaNotificaciones").data('identif');

    $.ajax({
        url: rutaPush.replace("@@", usuario),
        type: 'POST',
        data: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(resp) {
            notificar();


        }
    });
}