<div class="first-child-3">
    <p><b>Total Budget: 300000 INR </b></p>
    <div class="char-container">
        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
    </div>
    <ul class="dot-list" style="margin:20px;">
        <li class="dot-list-item"><span class="dot red"></span>Total Budget</li>
        <li class="dot-list-item"><span class="dot light-blue"></span>Total Spent</li>
        <li class="dot-list-item"><span class="dot blue"></span>Total Left</li>
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
var xValues = ["Total Budget", "Total Spent", "total left"];
let totalBudget = 300000;
let totalSpent = 150000;
let totalLeft = totalBudget - totalSpent;
var yValues = [totalBudget, totalSpent, totalLeft, 50000];
var barColors = ["#ff3300", "#3399ff", "#cc33ff"];

new Chart("myChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues,
            barPercentage: 0.3,
            categoryPercentage: 0.2
        }]
    },
    options: {
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    suggestedMax: 350000
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0.1)"
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }

});
</script>