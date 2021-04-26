$(function() {
    notificar();
    setInterval(notificar, 60000);
});



function notificar() {

    let rutaPush = $("#mnuNotif").data('rutapush');

    $.ajax({
        url: rutaPush,
        success: function(resp) {
            let texto = $("#mnuNotif").text()
            if (resp.total > 0) {
                $("#notBadge").removeClass('notif-ocultar').addClass('notif-mostrar');
                $("#mnuNotif").html('Notificaciones <span class="badge p-2 badge-info">' + resp.total + '</span>');
            } else {
                $("#notBadge").removeClass('notif-mostrar').addClass('notif-ocultar');
                $("#mnuNotif").html('Notificaciones');
            }

        }
    });
}