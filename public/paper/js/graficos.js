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
        boostrapChart();
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
    let nombres = $("#comercialChart").data('nombres');
    let clientes = $("#comercialChart").data('cliente');
    let prospectos = $("#comercialChart").data('prospecto');
    var barChartData = {
        labels: nombres,
        datasets: [{
            label: 'Prospectos',
            backgroundColor: 'rgb(201, 203, 207)',
            data: prospectos
        }, {
            label: 'Clientes',
            backgroundColor: 'rgb(75, 192, 192)',
            data: clientes
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


function boostrapChart() {
    var colors = ['#28a745', '#dc3545'];
    let activos = $("#chDonut1").data('activos');
    let inactivos = $("#chDonut1").data('inactivos');

    /* 3 donut charts */
    var donutOptions = {
        cutoutPercentage: 85,
        legend: { position: 'bottom', padding: 5, labels: { pointStyle: 'circle', usePointStyle: true } }
    };


    // donut 1
    var chDonutData1 = {
        labels: ['Activos ' + activos, 'Inactivos ' + inactivos],
        datasets: [{
            backgroundColor: colors.slice(0, 3),
            borderWidth: 0,
            data: [activos, inactivos]
        }]
    };

    var chDonut1 = document.getElementById("chDonut1");
    if (chDonut1) {
        new Chart(chDonut1, {
            type: 'pie',
            data: chDonutData1,
            options: donutOptions
        });
    }
}

// red: 'rgb(255, 99, 132)',
// orange: 'rgb(255, 159, 64)',
// yellow: 'rgb(255, 205, 86)',
// green: 'rgb(75, 192, 192)',
// blue: 'rgb(54, 162, 235)',
// purple: 'rgb(153, 102, 255)',
// grey: 'rgb(201, 203, 207)'