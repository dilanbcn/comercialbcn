$(function() {

    let nuevo = document.querySelectorAll('.pieChart');
    nuevo.forEach(element => {
        let ctxP = element.getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'doughnut',
            data: {
                labels: ["Activos", "Inactivos"],
                datasets: [{
                    data: [element.dataset.act, element.dataset.inact],
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