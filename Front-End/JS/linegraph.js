$(document).ready(function() {
    $.ajax({
        url: "http://localhost/mystore/sales_data.php",
        type: "GET",
        success: function(data) {
            console.log(data);
            var date_sold = [];
            var price = [];

            for (var i in data) {
                price.push("$" + data[i].price);
                date_sold.push(formatDate(data[i].date));
            }

            var chartdata = {
                labels: date_sold,
                datasets: [{
                    label: "Sales History",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(59, 89, 152, 0.75)",
                    borderColor: "rgba(59, 89, 152, 1)",
                    pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
                    data: date_sold
                }]
            };
            var ctx = $("#mycanvas");

            var lineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                options: {
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 5, // Increment y-axis by $5
                            }
                        }
                    }
                }
            });
        },
        error: function(data) {

        }
    });
});

function formatDate(dateString) {
    var date = new Date(dateString);
    var options = { month: 'long', day: 'numeric', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}
