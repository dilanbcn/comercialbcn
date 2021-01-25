graficos = {

    checkFullPageBackgroundImage: function() {
        $page = $('.full-page');
        image_src = $page.data('image');

        if (image_src !== undefined) {
            image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
            $page.append(image_container);
        }
    },

    initChartsPages: function() {
        getDataPie();
    }

};

function getDataPie() {

    $.ajax({
        url: '/data-graficos/1',
        success: function(data) {
            showPie(data)

        }
    });
}

function showPie(dataPie) {

    ctx = document.getElementById('chartEmail').getContext("2d");

    myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Por Iniciar', 'Iniciada', 'Nivel 1', 'Nivel 2', 'Finalizada'],
            datasets: [{
                label: "Evaluaciones",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: [
                    '#ef8157',
                    '#6bd098',
                    '#fbc658',
                    '#51cbce',
                    '#6c757d'
                ],
                borderWidth: 0,
                data: dataPie
            }]
        },

        options: {
            legend: {
                display: false
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
            },
            tooltips: {
                enabled: true
            },

        }
    });
}