$(function() {

    $('#tablaCerrados thead tr').clone(true).appendTo('#tablaCerrados thead');
    $('#tablaCerrados thead tr:eq(1) th').each(function(i) {
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

    var table = $('#tablaCerrados').DataTable({
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
        ajax: "/clientes-cerrados-json",
        drawCallback: function(data) {

            let api = this.api();
            let celda = api.rows({ page: 'current' }).data();
            let totalAnnio = 0;
            let hoy = new Date();
            let annio = hoy.getFullYear().toString().substr(-2);

            celda.each(function(value) {

                let n = value[2].search("-" + annio);

                if (n > 0) {
                    totalAnnio += parseInt(value[4])
                }

            });

            valorFinal = new Intl.NumberFormat(["ban", "id"]).format(totalAnnio);

            $("#total").html('Total (' + hoy.getFullYear() + '): $' + valorFinal);

        },
        rowCallback: function(row, data, index) {
            let mesFacturacion = data[2];

            let hoy = new Date();
            let annio = hoy.getFullYear().toString().substr(-2);

            let n = mesFacturacion.search("-" + annio);
            if (n >= 0) {
                $(row).css('background-color', '#C6FFC7')
            }

        },

        columnDefs: [
            { targets: 4, render: $.fn.dataTable.render.number('.', ',', 0), className: "text-right", },
            { targets: [1, 2], className: "text-center" },
        ]
    });



});