$(document).ready(function() {
    $('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
    
if ($("#myChart").is(":visible")) {
    getReports();
}
});
function getReports() {
    var from = $("#from_date").val();
    var to = $("#to_date").val();
    $.ajax({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: baseUrl + "getreports",
        method: "GET",
        data: { from_date: from, to_date: to },
    }).done(function(data) {
        var ctx = document.getElementById("canvas_chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data['labels'],
                datasets: [{
                    label: 'Count(logs)',
                    data: data['datasets'],
                    borderWidth: 1,
                    pointBackgroundColor: "rgba(203,45,62,1)",
                    backgroundColor:'rgba(203,45,62,0.05)',
                    pointBorderColor: "rgba(203,45,62,1)",
                    borderColor: " rgba(203,45,62,0.7)",
                    pointHoverBackgroundColor: "rgba(173, 38, 53,1)", 
                    pointHoverBorderColor: "rgba(173, 38, 53,1)",
                }]
            },
            options: { 
                barValueSpacing: 20, 
                scales: { yAxes: [{ ticks: { min: 0 } }] } 
            }
        });
    });
}
