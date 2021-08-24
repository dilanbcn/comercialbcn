$(function() {



    $('#tablaVigencia thead tr').clone(true).appendTo('#tablaVigencia thead');
    $('#tablaVigencia thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != '') {
            $(this).html('<input type="text" placeholder="Filtrar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();

                    $('#tablaVigencia').DataTable().ajax.reload(foo);

                }
            });
        } else {
            $(this).html('');
        }
    });

    var table = $('#tablaVigencia').DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'B>>" +
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
                sheetName: 'Clientes Vigencia',
                title: 'Clientes Vigencia',
                className: 'dropdown-item',
                text: '<i class="fas fa-file-excel"></i> Excel'
            }]
        }],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/clientes-vigencia-json",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let rutaInicio = $("#tablaVigencia").data('rutainicio');

                    return '<button title="Editar Inicio Relacion" class="btn btn-xs btn-outline-secondary" data-cliente="' + row[0] + '" data-ruta="' + rutaInicio.replace("@@", row[7]) + '" data-fecha="' + row[4] + '"><i class="far fa-calendar-alt"></i></button>';
                }
            },
            { targets: [1, 2, 4, 5], className: "text-center" },
            {
                targets: 6,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let checked = (row[6] == "Activos") ? "checked" : "";
                    let rutaAct = $("#tablaVigencia").data('rutaactividad');
                    let admin = $("#tablaVigencia").data('rol');
                    let celda = "";
                    if (admin) {
                        celda += '<div ><input class="chkActivo" ' + checked + ' type="checkbox" name="activo"  data-ruta="' + rutaAct.replace("@@", row[7]) + '" data data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="outline-success" data-offstyle="outline-danger" data-size="sm"></div>';
                    }
                    return celda;

                },
            },
            {
                targets: 5,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let badged = (row[5] == "Activos") ? "badge-activos" : "badge-inactivos";

                    return '<span class="badge p-2 ' + badged + '">' + row[5] + '</span>';

                },
            },

        ],
        drawCallback: function(data) {

            let api = this.api();
            let celda = api.rows({ page: 'current' }).data();

            let totAct = 0;
            let totIna = 0;

            celda.each(function(value) {

                if (value[5] == 'Activos') {
                    totAct++;
                } else {
                    totIna++;
                }

            });

            $("#span-Activos").html('Activos ' + totAct);
            $("#span-Inactivos").html('Inactivos ' + totIna);

        },
        initComplete: foo,

    });

    table.columns([-1]).visible($("#tablaVigencia").data('rol'));

    $("#tablaVigencia tbody").on("click", 'button', function(e) {

        let rutaUpdate = $(this).data('ruta');
        let fechaInicio = $(this).data('fecha').split("/").reverse().join("-");
        let cliente = $(this).data('cliente');

        $('#frm_inicio_relacion').attr('action', rutaUpdate);
        $('#inp_inicio_relacion').val(fechaInicio);
        $("#titleModalInicio").html('Editar Inicio Relación ' + cliente);
        $("#modal_inicio_relacion").modal('show');
    });







});


function foo() {

    $(".chkActivo").each(function() {
        $(this).bootstrapToggle();
    });
    $(".chkActivo").on('change', function() {
        let rutaAct = $(this).data('ruta');
        let estado = $(this).prop('checked');
        $.ajax({
            url: rutaAct,
            success: function(resp) {
                if (resp.success == 'ok') {
                    toastr['success'](resp.msg, resp.title);
                }

                let totAct = 0;
                let totIna = 0;

                $(".chkActivo").each(function() {
                    let checked = $(this).prop('checked');

                    if (checked) {
                        totAct++;
                    } else {
                        totIna++;
                    }
                });

                $("#span-Activos").html('Activos ' + totAct);
                $("#span-Inactivos").html('Inactivos ' + totIna);

                $('#tablaVigencia').DataTable().ajax.reload(foo);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar editar el status del cliente, intente de nuevo mas tarde',
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
}