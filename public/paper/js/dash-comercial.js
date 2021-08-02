$(function() {

    $('.tablaDashComercial thead tr').clone(true).appendTo('.tablaDashComercial thead');
    $('.tablaDashComercial thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();

        if (title != '% Distribución') {
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

    let nuevo = document.querySelectorAll('.pieChart');
    nuevo.forEach(element => {
        let ctxP = element.getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'doughnut',
            data: {
                labels: ["Clientes", "Prospectos"],
                datasets: [{
                    data: [element.dataset.client, element.dataset.prosp],
                    backgroundColor: ["#38D430", "#001B65"],
                    hoverBackgroundColor: ["#FF5A5E", "#FF5A5E"]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                },

            }
        });
    });

});