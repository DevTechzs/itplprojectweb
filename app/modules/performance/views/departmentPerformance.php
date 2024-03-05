<link href="assets/css/departmentPerformance.css" rel="stylesheet" />


<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card departmentPerformance-div">
                    <div class="card-body">
                        <table class="table ">
                            <thead>
                                <tr>

                                    <th>Department</th>
                                    <th>Performance</th>
                                    <th style="width: 40px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>IT</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" style="width: 55%">55%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="performance-individualPerformance">more</a>
                                    </td>
                                </tr>
                                <tr>

                                    <td>Marketting</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 70%; color:aliceblue;">
                                                70%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="">more</a></td>
                                </tr>
                                <tr>

                                    <td>Finance</td>
                                    <td>
                                        <div class="progress  ">
                                            <div class="progress-bar bg-dark " style="width: 30%">30%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="">more</a></td>
                                </tr>
                                <tr>

                                    <td>Sales</td>
                                    <td>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar bg-success" style="width: 80%">80%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="">more</a></td>
                                </tr>
                                <tr>

                                    <td>Finance</td>
                                    <td>
                                        <div class="progress  progress-striped active">
                                            <div class="progress-bar bg-info" style="width: 70%">70%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="">more</a></td>
                                </tr>
                                <tr>

                                    <td>Customer Support</td>
                                    <td>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar bg-secondary" style="width: 60%">60%</div>
                                        </div>
                                    </td>
                                    <td><a class="bg-danger badge" href="">more</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="overall-performance">
                    <canvas id="overallDonutChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- /.content -->
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
let overallMean = 55;
let totalScore = 100;
let overallDonutChart = new Chart(document.getElementById('overallDonutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Overall'],
        datasets: [{
            data: [overallMean, overallMean - totalScore],
            backgroundColor: ['rgba(153, 255, 204,0.8)', '#eee'],
            borderWidth: 1
        }]
    },
    options: {
        cutoutPercentage: 0,
        legend: {
            display: false
        },
        tooltips: {
            enabled: false
        },


    }
});
</script>