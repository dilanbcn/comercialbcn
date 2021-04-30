$(function() {

    function format(row) {
        return '<p><span>Para: ' + row[6] + '</span></p><p>' + row[7] + '</p>';
    }

    $('#tablaNotificaciones thead tr').clone(true).appendTo('#tablaNotificaciones thead');
    $('#tablaNotificaciones thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != '' && title != 'Contenido') {
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
            "<'row mb-3' <'col-sm-5 pl-0 ml-0'<'table-filter-container'>>>" +
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
                    limpiarModalNotificacion();
                    $("#modal_notificacion").modal('show');
                }
            },
            {
                extend: 'collection',
                text: 'Exportar',
                className: 'btn-sm btn-round dropdown-toggle',
                buttons: [{
                        extend: 'excelHtml5',
                        orientation: 'landscape',
                        pageSize: 'letter',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 6, 7]
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
                            columns: [1, 2, 3, 4, 6, 7]
                        },
                        title: 'Notificaciones',
                        className: 'dropdown-item',
                        text: '<i class="fas fa-file-pdf"></i> Pdf</a>'
                    },
                ]
            }
        ],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/notificaciones-json",
        columnDefs: [
            { targets: [1, 2], className: "text-center" },
            {
                targets: 0,
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                targets: [6, 7],
                visible: false
            },
        ],
        initComplete: function(settings, json) {
            var api = new $.fn.dataTable.Api(settings);
            $('.table-filter-container', api.table().container()).append(
                $('#table-filter').detach().show()
            );

            $('#table-filter select').on('change', function() {

                table.column(5).search(this.value).draw();

                var column = table.column(3);
                column.visible(!column.visible());

            });

            let valor = $('#table-filter select').val();
            table.column(5).search(valor).draw();

        }
    });

    table.buttons().container().appendTo('#tablaNotificaciones_wrapper .col-md-6:eq(0)');

    $("#tablaNotificaciones tbody").on("click", 'button', function(e) {
        e.preventDefault();
    });

    $('#tablaNotificaciones tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    setTimeout(marcar, 4000);
    recientes();
    showMessage();

});

function limpiarModalNotificacion() {
    $(".mensaje, .cliente, .destino").val('').removeClass('is-invalid');
    $("#destino").prop("selected", false);
    $('.selectpicker').selectpicker('refresh');
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

function recientes() {
    let ruta = $("#tablaNotificaciones").data('rutarecientes');

    $.ajax({
        url: ruta,
        success: function(resp) {
            if (resp.data.length > 0) {

                let celda = '<div class="notif-timeline-v2"><div class="notif-timeline-v2__items">';

                $.each(resp.data, function(key, notificacion) {
                    console.log('file: notificaciones.js -> line 264 -> $.each -> notificacion', notificacion);

                    celda += '<div class="notif-timeline-v2" ><div class="notif-timeline-v2__item">';
                    celda += '<span class="notif-timeline-v2__item-time">' + notificacion[0] + '</span>';
                    celda += '<div class="notif-timeline-v2__item-cricle"><i class="' + notificacion[1] + '"></i></div>';
                    celda += '<div class="notif-timeline-v2__item-text text-justify pr-2"><p class="block-with-text p-with-text">' + notificacion[2] + '</p> <a href="#" class="showNotif mb-3" id="' + notificacion[3] + '">[más]</a></div>';
                    celda += '</div></div>';
                    celda += '<div class="notif-timeline-v2__footer pt-2 animated fadeIn bg-light" id="footer_' + notificacion[3] + '">';
                    celda += '<div class="row">';
                    celda += '<div class="col-12 text-left pr-0"><span class="text-muted text-notif-footer pr-4">' + notificacion[5] + '</span></div>';
                    celda += '<div class="col-12 text-right pr-0"><span class="text-muted text-notif-footer pr-4">' + notificacion[4] + '</span></div>';
                    celda += '<div class="col-12 text-right pr-0"><span class="text-muted text-notif-footer pr-4">' + notificacion[6] + '</span></div>';
                    celda += '</div>';
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