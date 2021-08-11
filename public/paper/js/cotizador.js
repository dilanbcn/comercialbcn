$(function() {

    $('.tablaCotizador thead tr').clone(true).appendTo('.tablaCotizador thead');
    $('.tablaCotizador thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();

        if (title != 'Acciones') {
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

    var table = $('#tablaCotizador').DataTable({
        language: {
            url: "/paper/js/spanish.json",
        },
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/cotizador/all",
        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let rutaEditar = $("#tablaCotizador").data('rutaeditar');
                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';

                    celda += '<a href="' + rutaEditar.replace("@@", row[2]) + '" data-detalleactualizar=""  title="Editar" class="btn btn-xs btn-outline-secondary" data-accion="btnEdi"><i class="fa fa-edit"></i></a>';

                    celda += '</div>';

                    return celda;
                }
            },
            { targets: [1], className: "text-center" },

        ]
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    showMessage();


    $(".btnEdi").on("click", function(e) {
        e.preventDefault();

        let ruta = $(this).attr('href');

        $.ajax({
            url: ruta,
            success: function(data) {
                if (data.success == 'ok') {
                    let inputs = Array();
                    $(".modal_tipoVenta").addClass('d-none');
                    switch (data.tipo_venta_id) {
                        case 1:
                            $("#inptDesde").html(data.desde);
                            $("#inptHasta").html(data.hasta);
                            $("#inp_valor_implementacion").val(format_moneda(data.valor_implementacion));
                            $("#inp_valor_mantencion").val(format_moneda(data.valor_mantencion));
                            inputs.push('#inp_valor_implementacion', '#inp_valor_mantencion');
                            break;
                        case 2:
                            $("#inptOrden").html(data.orden);
                            $("#inptTipo").html(data.tipo_precio);
                            $("#inptDescripcion").html(data.descripcion_tipo_precio);
                            $("#inp_precio").val(format_moneda(data.precio));
                            inputs.push('#inp_precio');
                            break;
                        case 3:
                            $("#inptTipoPrecio").html(data.tipo_precio);
                            $("#inptDescripcionPrecio").html(data.descripcion_tipo_precio);
                            $("#inp_precio_minimo").val((data.precio) ? format_moneda(data.precio) : format_moneda(data.precio_minimo));
                            $("#inp_precio_maximo").val((data.precio_maximo) ? format_moneda(data.precio_maximo) : '');
                            inputs.push('#inp_precio_minimo');
                            break;
                    }

                    $("#tipoVenta" + data.tipo_venta_id).removeClass('d-none');
                    $("#modal_detalle_venta").modal('show');

                    $("#btnEditarDetalle").on('click', function() {
                        let errores = 0;
                        inputs.forEach(element => {

                            let valor = $(element).val();

                            if (!valor) {
                                errores++;
                                let msg = $(element + '_error').data('mensaje');
                                $(element + '_error').show();
                                $(element + '_error').html(msg);
                                $(element).addClass('is-invalid');

                            } else {

                                $(element + '_error').hide();
                                $(element + '_error').html('');
                                $(element).removeClass('is-invalid');

                            }

                        });

                        if (errores <= 0) {
                            let rutaUpdate = $("#tablaCotizadorDetalle").data('detalleactualizar');
                            $('#frm_detalle_venta').attr('action', rutaUpdate.replace("@@", data.id));
                            $("#tipo_venta").val(data.tipo_venta_id);
                            $("#frm_detalle_venta").submit();
                        }

                    });
                } else {
                    // limpiarModalProyecto();
                }


            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#modal_detalle_venta").modal('hide');
                $.confirm({
                    title: 'Error',
                    content: 'Error al intentar obtener los datos del producto, intente de nuevo mas tarde',
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

    $(".inputNumber").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 44)
    }).on('keyup', function(e) {
        $(this).val(format_moneda($(this).val()));
    });

});