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
                    if (data.fecha_reunion) {
                        let fecha = data.fecha_reunion.split(' ');
                        $("#upd_fechaReunion").val(fecha[0]);
                        $("#upd_horaReunion").val(fecha[1].substring(0, 5));
                    }
                    $('#frm_updt_reunion').attr('action', './cliente-comunicacion/' + info.event.id);
                    $("#upd-input-ruta").val('./cliente-comunicacion/' + info.event.id);
                    $("#upd_cliente").val(data.cliente_id);
                    $("#upd_fechaContacto").val(data.fecha_contacto);
                    $("#upd_observaciones").val(data.observaciones);
                    $('#upd_tipoComunicacion').bootstrapToggle((data.tipo_comunicacion == 1) ? 'off' : 'on');
                    $('#upd_linkedin').bootstrapToggle((data.linkedin == 1) ? 'on' : 'off');
                    $('#upd_envioCorreo').bootstrapToggle((data.envia_correo == 1) ? 'on' : 'off');
                    $('#upd_respuesta').bootstrapToggle((data.respuesta == 1) ? 'on' : 'off');
                    $("#updt_reunion").modal('show');
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
                $("#add_reunion").modal('show');
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