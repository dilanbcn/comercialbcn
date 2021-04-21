$(function() {

    $('#tableProspectos thead tr').clone(true).appendTo('#tableProspectos thead');
    $('#tableProspectos thead tr:eq(1) th').each(function(i) {
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
    var table = $('#tableProspectos').DataTable({
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
        ajax: "/clientes-disponibles-json",
        columnDefs: [{
            targets: -1,
            data: null,
            className: "text-center",
            render: function(data, type, row) {
                let rutaDel = $("#tableProspectos").data('rutadel');
                let rutaEdit = $("#tableProspectos").data('rutaedit');
                let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones"><a href="' + rutaEdit.replace("@@", row[3]) + '" title="Editar" class="btn btn-xs btn-outline-secondary"><i class="fa fa-edit"></i></a>'
                celda += '<button title="Eliminar Cliente" class="btn btn-xs btn-outline-danger delRegistro" data-recurs="0" data-ruta="' + rutaDel.replace("@@", row[3]) + '"><i class="fa fa-times"></i></button></div>';

                return celda;

            },
        }],

    });

    table.columns([-1]).visible($("#tableProspectos").data('rol'));

    $("#tableProspectos tbody").on("click", 'button', function(e) {
        e.preventDefault();

        // let nameForm = $(this).closest("form").attr('id');
        let nameTitle = $(this).attr('title');
        let ruta = $(this).data('ruta');

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

                        delProspecto(ruta);

                    },
                },
                cancel: {
                    text: 'No',
                },
            }
        });
    });

});

function delProspecto(rutaDel) {
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
            $('#tableProspectos').DataTable().ajax.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            toastr['danger']('Error al intentar eliminar un cliente', 'Error');

        }
    });
}