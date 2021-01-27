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
        // clienteChart();
        comercialCahrt();
    }
};

function clienteChart() {
    var ctx = document.getElementById('clienteChart');
    let data = $("#clienteChart").data('arrdata');

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: data,
                backgroundColor: [
                    "#6bd098",
                    "#6c757d"
                ],
            }],
            labels: [
                'Clientes',
                'Prospectos'
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: false,
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }

    };

    var ctx = document.getElementById('clienteChart').getContext('2d');
    window.myDoughnut = new Chart(ctx, config);
}

function comercialCahrt() {

    var barChartData = {
        labels: ['Dilan', 'Rafael', 'Gonzalez', 'Pino', 'Vega', 'Gonzalez', 'Pino', 'Vega'],
        datasets: [{
            label: 'Clientes',
            backgroundColor: 'rgb(75, 192, 192)',
            data: [
                15,
                15,
                15,
                15,
                15,
                15,
                15
            ]
        }, {
            label: 'Prospectos',
            backgroundColor: 'rgb(201, 203, 207)',
            data: [
                20,
                20,
                20,
                20,
                20,
                20,
                20
            ]
        }]

    };

    var config = {
        type: 'bar',
        data: barChartData,
        options: {
            title: {
                display: false,
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    }


    var ctx = document.getElementById('comercialChart').getContext('2d');
    window.myDoughnut = new Chart(ctx, config);



}

// red: 'rgb(255, 99, 132)',
// orange: 'rgb(255, 159, 64)',
// yellow: 'rgb(255, 205, 86)',
// green: 'rgb(75, 192, 192)',
// blue: 'rgb(54, 162, 235)',
// purple: 'rgb(153, 102, 255)',
// grey: 'rgb(201, 203, 207)'