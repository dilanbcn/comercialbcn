document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
        locale: 'es',
        showNonCurrentDates: false,
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        header: {
            left: 'prev today',
            center: 'title',
            right: 'next'
        },
        firstDay: 1,
        contentHeight: 800,
        aspectRatio: 3, // see: https://fullcalendar.io/docs/aspectRatio
        nowIndicator: true,
        editable: false,
        eventLimit: false, // for all non-TimeGrid views
        views: {
            timeGrid: {
                eventLimit: 6 // adjust to 6 only for timeGridWeek/timeGridDay
            }
        },
        eventClick: function(info) {
            let rutaEdit = '/cliente-comunicacion/' + info.event.id + '/edit';
            $.ajax({
                url: rutaEdit,
                success: function(data) {
                    $(".is-invalid").removeClass('is-invalid');
                    $(".invalid-feedback").hide();
                    if (data.fecha_reunion) {
                        let fecha = data.fecha_reunion.split(' ');
                        $("#updt_fechaReunion").val(fecha[0]);
                        $("#updt_horaReunion").val(fecha[1].substring(0, 5));
                    }
                    $('#frm_updt_reunion').attr('action', './cliente-comunicacion/' + info.event.id);
                    $("#upd-input-ruta").val('./cliente-comunicacion/' + info.event.id);
                    $("#updt_cliente option[value='" + data.cliente_id + "']").prop('selected', true);
                    $("#updt_tipoComunicacion option[value='" + data.tipo_comunicacion_id + "']").prop('selected', true);
                    $("#updt_cliente").val(data.cliente_id);
                    $("#updt_fechaContacto").val(data.fecha_contacto);
                    $("#updt_observaciones").val(data.observaciones);
                    $('#updt_linkedin').bootstrapToggle((data.linkedin == 1) ? 'on' : 'off');
                    $('#updt_envioCorreo').bootstrapToggle((data.envia_correo == 1) ? 'on' : 'off');
                    $('#updt_respuesta').bootstrapToggle((data.respuesta == 1) ? 'on' : 'off');
                    $("#updt_reunion").modal('show');

                    $.ajax({
                        url: './cliente-contacto-json/' + data.cliente_id,
                        success: function(contactos) {
                            let optSel = '<option value="" selected>[Seleccione]</option>';
                            if (contactos.length > 0) {
                                $.each(contactos, function(key, contacto) {
                                    seleccionado = (contacto.id == data.cliente_contacto_id) ? 'selected' : '';
                                    optSel += '<option value="' + contacto.id + '" ' + seleccionado + ' >' + contacto.nombre + ' ' + contacto.apellido + '</option>';
                                });
                            }
                            $("#updt_contactoId").html('').append(optSel);
                        }
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#updt_reunion").modal('hide');
                    $.confirm({
                        title: 'Error',
                        content: 'Error al intentar obtener los datos de comunicación, intente de nuevo mas tarde',
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
        },
        eventSources: [{
            url: '/cliente-comunicacion/reuniones',
            method: 'GET',
            failure: function() {
                alert('there was an error while fetching events!');
            },
        }],
        navLinks: true,
        navLinkDayClick: function(date, jsEvent) {
            let valido = validaFecha(date);

            if (valido) {
                let fecha = formatFecha(date);
                $("#fechaReunion").val(fecha);
                $(".is-invalid").removeClass('is-invalid');
                $(".invalid-feedback").hide();
                $("#add_reunion").modal('show');
            } else {
                $.confirm({
                    title: 'Atención',
                    content: 'No se pueden crear reuniones con fecha menor a la del día de hoy',
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
        }

    });
    calendar.render();
});

function formatFecha(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');

}

function validaFecha(date) {
    let hoy = new Date();
    let fecha = new Date(date);

    let f1 = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
    let f2 = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate());

    let valido = (f1 >= f2) ? false : true;
    valido = ((!valido && f1.getTime() == f2.getTime()) || valido) ? true : false;

    return valido;
}