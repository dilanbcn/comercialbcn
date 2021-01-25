$(function() {
    $('#tablaComercialesIdex').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
        }
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    showMessage();


    // BOTON ELIMINAR
    $(".delRegistro").on("click", function(e) {
        e.preventDefault();

        // let nameForm = $(this).closest("form").attr('id');
        let nameTitle = $(this).attr('title');
        let recursivo = $(this).data('recurs');
        let ruta = $(this).data('ruta');
        let textherencia = $(this).data('textherencia');
        let textMsg = (textherencia != undefined) ? 'Al eliminar este registro, ' + textherencia + ', desea continuar?' : 'Al eliminar este registro, se eliminarán todos los que dependen de el, desea continuar?';

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

                        if (recursivo == '1') {
                            $.confirm({
                                title: 'Eliminar Herencia',
                                content: textMsg,
                                type: 'dark',
                                theme: 'modern',
                                animation: 'scala',
                                icon: 'fa fa-exclamation-triangle',
                                typeAnimated: true,
                                buttons: {
                                    confirm: {
                                        text: 'Eliminar',
                                        btnClass: 'btn-secondary',
                                        action: function() {
                                            $('#frm_del_registro').attr('action', ruta);
                                            $("#frm_del_registro").submit();
                                        },
                                    },
                                    cancel: {
                                        text: 'Cancelar',
                                    },
                                }
                            });
                        } else {
                            $('#frm_del_registro').attr('action', ruta);
                            $("#frm_del_registro").submit();
                        }
                    },
                },
                cancel: {
                    text: 'No',
                },
            }
        });
    });

    // USUARIO
    $("#usr_create_rut, #inst_create_rut").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 75 || key == 107)
    });

    $("#usr_create_rut").on('blur', function(e) {
        let valor = $(this).val();
        if (valor) {
            let rut = valor.substring(0, valor.length - 1) + '-' + valor.substring(valor.length - 1, valor.length);
            $(this).val(rut);
        }
    }).on('focus', function() {
        let valor = $(this).val();
        if (valor) {
            let datos = valor.replace('-', '');
            $(this).val(datos)
        }
    });
});


function showMessage() {
    let msg = $("#msg-data").val();
    let titulo = $("#msg-data").data('titulo');
    let estilo = $("#msg-data").data('estilo');
    if (msg) {
        toastr[estilo](msg, titulo);
        $("#msg-data").val('');
    }
}