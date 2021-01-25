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
});


function showMessage() {
    let msg = $("#msg-data").val();
    let titulo = $("#msg-data").data('titulo');
    let estilo = $("#msg-data").data('estilo');
    if (msg) {


        toastr[estilo](msg, titulo);
        // switch (estilo) {
        //     case 'info':
        //         toastr.info(msg, titulo);
        //         break;
        //     case 'warning':
        //         toastr.warning(msg, titulo);
        //         break;
        //     case 'success':
        //         toastr.success(msg, titulo);
        //         break;
        //     case 'error':
        //         toastr.error(msg, titulo);
        //         break;
        // }


        // $.toast({
        //     heading: titulo,
        //     text: msg,
        //     icon: estilo,
        //     position: 'top-right',
        //     hideAfter: 6000,
        //     afterShown: function() {
        //         $("#msg-data").val("");
        //     }
        // })
    }
}