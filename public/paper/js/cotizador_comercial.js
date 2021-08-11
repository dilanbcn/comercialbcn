$(function() {

    $(".inputNumber").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 44)
    });

    $(".toggle-action").on('change', function() {

        let status = $(this).prop('checked');
        let venta = $(this).data('venta');
        let detalle = $(this).data('detalle');
        let disable = (status) ? false : true;

        $("#cant_precio_" + detalle).prop('disabled', disable);
        $("#cant_precio_" + detalle).val('');

        totDetalleCant(venta);

        calcularTotal();

    });

    $(".inptCantidad").on('keyup', function(e) {

        let venta = $(this).data('venta');
        let detalle = $(this).data('detalle');
        let totIptCantidad = $("#cant_precio_" + detalle).length;

        totDetalleCant(venta);

        calcularTotal();

    });

    $(".inpt-multiplicar").on('keyup', function(e) {

        if ($(this).val() == 0) {
            $(this).val('');
        }

        let cantidad = $(this).val();
        let esNumero = $.isNumeric(cantidad);
        let venta = $(this).data('venta');

        if (esNumero) {

            let total = $("#total_curso_" + venta).data('valor');

            if (total != undefined) {

                total *= cantidad;
                $("#total_curso_" + venta).html(format_moneda(total));
                $("#total_curso_" + venta).data('valor', total);

            } else {

                let minimo = $("#total_curso_minimo_" + venta).data('valor');
                let maximo = $("#total_curso_maximo_" + venta).data('valor');

                minimo *= cantidad;
                $("#total_curso_minimo_" + venta).html(format_moneda(minimo));
                $("#total_curso_minimo_" + venta).data('valor', minimo);

                maximo *= cantidad;
                $("#total_curso_maximo_" + venta).html(format_moneda(maximo));
                $("#total_curso_maximo_" + venta).data('valor', maximo);
            }

        } else {
            $(this).val('');

            totDetalleCant(venta);

        }

        calcularTotal();

    });

    $(".chk_rango").on('click', function() {
        let valorImp = Number($(this).data('implementacion'));
        let valorMan = Number($(this).data('mantencion'));
        let venta = $("#tblRangoCotizador").data('venta');

        let total = valorMan + valorImp;

        let extra = $("#chkbox_" + venta).prop('checked');

        if (extra) {
            let precioExtra = Number($("#chkbox_" + venta).data('precio'));
            total += precioExtra;
        }

        $("#total_curso_" + venta).html(format_moneda(total));
        $("#total_curso_" + venta).data('valor', total);

        calcularTotal();

    });

    $(".chkExtra").on('change', function() {

        let venta = $(this).data('venta');
        let status = $(this).prop('checked');

        let totalExtraMin = $("#total_curso_minimo_" + venta).data('valor');

        if (totalExtraMin != undefined) {

            let totalExtraMax = $("#total_curso_maximo_" + venta).data('valor');

            if (status) {
                let precioExtra = Number($("#chkbox_" + venta).data('precio'));
                totalExtraMin += precioExtra;
                totalExtraMax += precioExtra;
            } else {
                let precioExtra = Number($("#chkbox_" + venta).data('precio'));
                totalExtraMin -= precioExtra;
                totalExtraMax -= precioExtra;
            }

            $("#total_curso_maximo_" + venta).html(format_moneda(totalExtraMax));
            $("#total_curso_maximo_" + venta).data('valor', totalExtraMax);

            $("#total_curso_minimo_" + venta).html(format_moneda(totalExtraMin));
            $("#total_curso_minimo_" + venta).data('valor', totalExtraMin);

        } else {
            let totalExtra = $("#total_curso_" + venta).data('valor');

            if (status) {
                let precioExtra = Number($("#chkbox_" + venta).data('precio'));
                totalExtra += precioExtra;
            } else {
                let precioExtra = Number($("#chkbox_" + venta).data('precio'));
                totalExtra -= precioExtra;
            }

            $("#total_curso_" + venta).html(format_moneda(totalExtra));
            $("#total_curso_" + venta).data('valor', totalExtra);
        }

        calcularTotal();

    });

    $(".opt-action").on('click', function() {

        let status = $(this).prop('checked');
        let venta = $(this).data('venta');
        let detalle = $(this).data('detalle');
        let extra = $("#chkbox_" + venta).prop('checked');
        let precioUnico = Number($("#inpSum_min_" + detalle).data('precio'));

        if (extra) {

            let precioExtra = Number($("#chkbox_" + venta).data('precio'));
            precioUnico += precioExtra;

        }

        $("#total_curso_" + venta).html(format_moneda(precioUnico));
        $("#total_curso_" + venta).data('valor', precioUnico);

        calcularTotal();

    });

    calcularTotal();

});

function totDetalleCant(venta) {

    let precioTotal = $("#total_curso_" + venta).data('valor');
    let total = 0;
    let totalMinimo = 0;
    let totalMaximo = 0;
    let maximo = $("#total_curso_maximo_" + venta).data('valor');

    $(".cant_precio_" + venta).each(function(element) {

        let cantidad = $(this).val();
        let detalle = $(this).data('detalle');

        if (cantidad) {
            if (precioTotal != undefined) {
                let precioUnico = $("#inpSum_min_" + detalle).data('precio');
                total += (cantidad * precioUnico);

            } else {
                let precioMinimo = $("#inpSum_min_" + detalle).data('precio');
                let precioMaximo = $("#inpSum_max_" + detalle).data('precio');

                if (precioMaximo != undefined) {
                    totalMinimo += (cantidad * precioMinimo);
                    totalMaximo += (cantidad * precioMaximo);
                } else {
                    let totalCelda = (cantidad * precioMinimo);
                    totalMinimo += totalCelda;
                    totalMaximo += totalCelda;
                }
            }
        }
    });

    let activos = 0;

    $('input[name="opt_radio_' + venta + '"]').each(function(element) {

        if ($(this).prop('checked')) {
            activos++;
        }

    });

    if (activos > 0) {
        if (precioTotal != undefined) {
            let precioBase = Number($("#inptPrecio_base_" + venta).data('precio'));
            if (!isNaN(precioBase)) {
                total += precioBase;
            }
        } else {
            let precioBase = Number($("#inptPrecio_base_" + venta).data('precio'));
            if (!isNaN(precioBase)) {
                totalMinimo += precioBase;
                totalMaximo += precioBase;
            }
        }
    }

    let multiplicar = $("#inpt_multiplicar_" + venta).val();

    if (maximo != undefined) {

        let showMin = (multiplicar != undefined && multiplicar > 0) ? totalMinimo *= multiplicar : totalMinimo;
        let showMax = (multiplicar != undefined && multiplicar > 0) ? totalMaximo *= multiplicar : totalMaximo;

        $("#total_curso_minimo_" + venta).html(format_moneda(showMin));
        $("#total_curso_maximo_" + venta).html(format_moneda(showMax));
        $("#total_curso_minimo_" + venta).data('valor', showMin);
        $("#total_curso_maximo_" + venta).data('valor', showMax);
    } else {
        let showTot = (multiplicar != undefined && multiplicar > 0) ? total *= multiplicar : total;
        $("#total_curso_" + venta).html(format_moneda(showTot));
        $("#total_curso_" + venta).data('valor', showTot);
    }

    calcularTotal();

    return total;
}

function calcularTotal() {
    let precioxAlumno = 480000;
    let multiplicador = 2;
    let totalAmbos = 0;
    let totSENCE_min = 0;
    let totSENCE_max = 0;

    $(".lblPrecioAmbos").each(function(element) {

        let valorVenta = Number($(this).data('valor'));
        totalAmbos += valorVenta;

    });

    let totalMinimo = totalAmbos;
    let totalMaximo = totalAmbos;

    $(".lblPrecioMinimo").each(function(element) {

        let valorVentaMinimo = Number($(this).data('valor'));
        totalMinimo += valorVentaMinimo;

    });

    $(".lblPrecioMaximo").each(function(element) {

        let valorVentaMaximo = Number($(this).data('valor'));
        totalMaximo += valorVentaMaximo;

    });

    if (totalMinimo > precioxAlumno) {
        totSENCE_min = Math.ceil(totalMinimo / precioxAlumno);
    }

    if (totalMaximo > precioxAlumno) {
        totSENCE_max = Math.ceil(totalMaximo / precioxAlumno);
    }


    $("#totalGRAL_min").html(format_moneda(totalMinimo));
    $("#totalGRAL_max").html(format_moneda(totalMaximo));

    $("#totSENCE_min").html(format_moneda(totSENCE_min));
    $("#totSENCE_max").html(format_moneda(totSENCE_max));

    $("#totBCN_min").html(format_moneda(totSENCE_min * multiplicador));
    $("#totBCN_max").html(format_moneda(totSENCE_max * multiplicador));




}