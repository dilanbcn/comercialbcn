$(function() {

    $('#tablaVigencia thead tr').clone(true).appendTo('#tablaVigencia thead');
    $('#tablaVigencia thead tr:eq(1) th').each(function(i) {
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

    var table = $('#tablaVigencia').DataTable({
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
        ajax: "/clientes-vigencia-json",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let rutaInicio = $("#tablaVigencia").data('rutainicio');

                    return '<button title="Editar Inicio Relacion" class="btn btn-xs btn-outline-secondary" data-cliente="' + row[0] + '" data-ruta="' + rutaInicio.replace("@@", row[6]) + '" data-fecha="' + row[5] + '"><i class="far fa-calendar-alt"></i></button>';
                }
            },
            { targets: [1, 2, 5], className: "text-center" },
            {
                targets: 3,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let badged = (row[3] == "Activos") ? "badge-activos" : "badge-inactivos";

                    return '<span class="badge p-2 ' + badged + '">' + row[3] + '</span>';

                },
            },


        ],
        drawCallback: function(data) {

            let api = this.api();
            let celda = api.rows({ page: 'current' }).data();

            let totAct = 0;
            let totIna = 0;

            celda.each(function(value) {

                if (value[3] == 'Activos') {
                    totAct++;
                } else {
                    totIna++;
                }

            });

            $("#span-Activos").html('Activos ' + totAct);
            $("#span-Inactivos").html('Inactivos ' + totIna);

        }
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