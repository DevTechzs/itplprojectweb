<link href="assets/css/performance.css" rel="stylesheet" />

<link href="assets/css/performance.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="performance-container individual-performance-container">
                <div class="performance-progress-bars">
                    <div class="performance-progress-bar-container" id="productivity">
                        Productivity
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 90%;" id="productivityProgress">90%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value="90">
                        </div>
                    </div>

                    <div class="performance-progress-bar-container" id="problemSolvingSkill">
                        Problem Solving Skill
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 88%;" id="problemSolvingSkillProgress">88%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value="88">
                        </div>
                    </div>


                    <div class="performance-progress-bar-container" id="knowledge">
                        Knowledge
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 92%;" id="knowledgeProgress">92%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value="92">
                        </div>
                    </div>
                    <div class="performance-progress-bar-container" id="attendance">
                        Attendance
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 95%;" id="attendanceProgress">95%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value="95">
                        </div>
                    </div>
                    <div class="performance-progress-bar-container" id="relationWithOthers">
                        Relation with others
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 90%;" id="relationProgress">90%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value="90">
                        </div>
                    </div>
                    <div class="performance-progress-bar-container">
                        Leadership Quality
                        <div class="progress-bar-container" id="leadershipQuality">
                            <div class="progress-bar" style="width: 87%;" id="leaderShipProgress">87%</div>
                        </div>
                        <div> <input type="number" class="progress-input" min="0" max="100" value='87'>
                        </div>
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
let overallMean = 94;
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
<script>
$(document).ready(function() {
    $(".progress-input").on("input", function() {
        var identifier = $(this).closest(".performance-progress-bar-container").attr("id");
        var inputValue = $(this).val();
        $("#" + identifier + "Progress").css("width", inputValue + "%").text(inputValue + "%");
    });
});
</script>