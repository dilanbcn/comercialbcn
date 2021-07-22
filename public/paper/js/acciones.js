$(function() {



    $('#tablaAcciones thead tr').clone(true).appendTo('#tablaAcciones thead');
    $('#tablaAcciones thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Seleccionar') {
            $(this).html('<input type="checkbox" id="chkAll"/>');

            $("#chkAll").on('click', function() {
                seleccionarTodos($(this).is(':checked'));
            });
        } else {


            $(this).html('<input type="text" placeholder="Filtrar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    var table = $('#tablaAcciones').DataTable({
        language: {
            url: "/paper/js/spanish.json",
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
        ajax: "/clientes-all/true",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';

                    celda += '<input type="checkbox" class="chkCliente"/ value="' + row[9] + '">';

                    celda += '</div>';

                    return celda;
                }
            },
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
        headerCallback: function(settings, json) {
            $(".myButtonClass").hide();
        }
    });

    $("#btn_modal_desechar").on('click', function() {
        let arrChekeados = new Array();
        $(".chkCliente:checked").each(function() {
            arrChekeados.push($(this).val());
        });

        if (arrChekeados.length > 0) {

            desechar(arrChekeados);

        } else {
            mostrarError();
        }
    });

    $("#btn_modal_asignar").on('click', function() {
        let arrChekeados = new Array();
        $(".chkCliente:checked").each(function() {
            arrChekeados.push($(this).val());
        });

        if (arrChekeados.length > 0) {

            let textClientes = 'Se asignaran un total de ';
            let nomComercial = $('#sel_comercial option:selected').text();

            if (arrChekeados.length > 1) {
                textClientes += arrChekeados.length + ' clientes';
            } else {
                textClientes = 'Se asignara un cliente ';
            }

            let textoComercal = ' a ' + nomComercial;

            $("#div_texto_asignacion").html(textClientes + textoComercal);

            $("#modal_asignar").modal('show');

            $("#sel_comercial").on('change', function() {
                let nomComercial = $(this).find("option:selected").text();
                textoComercal = ' a ' + nomComercial;

                $("#div_texto_asignacion").html(textClientes + textoComercal);
            });

            $("#btnAsignar").on('click', function() {
                let idComercial = $('#sel_comercial option:selected').val();
                asignar(arrChekeados, textoComercal, idComercial);
            });



        } else {
            mostrarError();
        }
    });

});

function mostrarError() {
    $.confirm({
        title: 'Atencion',
        content: 'Debe seleccionar al menos un cliente',
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

function seleccionarTodos(checked) {

    $(".chkCliente").prop('checked', checked);

}

function desechar(arrChekeados) {

    let cantidad = arrChekeados.length;

    let contenido = '¿Esta seguro que desea desechar ' + cantidad + ' cliente';
    contenido += (cantidad > 1) ? 's?' : '?';

    $.confirm({
        title: (cantidad > 1) ? 'Desechar Clientes' : 'Desechar Cliente',
        content: contenido,
        type: 'orange',
        theme: 'modern',
        animation: 'scala',
        icon: 'fa fa-recycle',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: 'Desechar',
                btnClass: 'btn-warning',
                action: function() {
                    let rutaDesechar = $('#tablaAcciones').data('desecharlote');

                    $.ajax({
                        url: rutaDesechar,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            clientes: arrChekeados,
                        },
                        success: function(data) {
                            if (data.success == 'ok') {
                                toastr['success'](data.msg, data.title);
                            }
                            $('#tablaAcciones').DataTable().ajax.reload();
                            $("#chkAll").prop('checked', false);

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            toastr['danger']('Error al intentar desechar', 'Error');

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

function asignar(arrChekeados, nomComercial, idComercial) {

    let cantidad = arrChekeados.length;

    let contenido = '¿Esta seguro que desea asignarle ' + cantidad + ' cliente';
    contenido += (cantidad > 1) ? 's?' : '?';

    $.confirm({
        title: (cantidad > 1) ? 'Asignar Clientes' + nomComercial : 'Asignar Cliente' + nomComercial,
        content: contenido,
        type: 'blue',
        theme: 'modern',
        animation: 'scala',
        icon: 'fas fa-user-plus',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: 'Asignar',
                btnClass: 'btn-blue',
                action: function() {
                    let rutaAsignar = $('#tablaAcciones').data('asignarlote');

                    let ddd = {
                        comercialDestino: idComercial,
                        clientes: arrChekeados,
                    }

                    $.ajax({
                        url: rutaAsignar,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            comercialDestino: idComercial,
                            clientes: arrChekeados,
                        },
                        success: function(data) {
                            if (data.success == 'ok') {
                                toastr['success'](data.msg, data.title);
                            }
                            $('#tablaAcciones').DataTable().ajax.reload();
                            $("#modal_asignar").modal('hide');
                            $("#chkAll").prop('checked', false);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $("#modal_asignar").modal('hide');
                            toastr['danger']('Error al intentar asignar', 'Error');

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