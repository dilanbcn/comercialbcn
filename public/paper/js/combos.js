$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#nombrePais").on('change', function() {
        let disa = ($(this).val() != "") ? false : true;
        $("#nombreRegion").val('');
        $("#nombreRegion").prop('disabled', disa);
        // $("#nombreComuna").val('');
        // $("#nombreComuna").prop('disabled', disa);
    });

    $("#nombreRegion").on('change', function() {
        let idRegion = $(this).val();
        let disa = (idRegion != "") ? false : true;
        $("#nombreComuna").val('');
        $("#nombreComuna").prop('disabled', disa);
        if (idRegion != "") {
            $.ajax({
                url: '/comunas/' + idRegion,
                success: function(comunas) {
                    let optSel = '<option value="" selected>[Seleccione]</option>';
                    $.each(comunas, function(key, comuna) {
                        optSel += '<option value="' + comuna.id + '">' + comuna.nombre + '</option>';
                    });

                    $("#nombreComuna").html('').append(optSel);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#nombreComuna").val('');
                    $("#nombreRegion").val('');
                    $.confirm({
                        title: 'Error',
                        content: 'Error al intentar consultar las comunas, intente de nuevo mas tarde',
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
        }

    })
});