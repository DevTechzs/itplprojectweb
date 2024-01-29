<!--<link href="assets/admin/plugins/chart.js/chart.js" rel="stylesheet">-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">

    <div class="container-fluid p-3">
        
        <!-- first row -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Teachers</span>
                        <span class="info-box-number" id="NoOfTeachers"> - </span>
                    </div>
                </div>
            </div>
           
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-child"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Student</span>
                        <span class="info-box-number" id="NoOfStudents"> - </span>
                    </div>
                   
                </div>
               
            </div>
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tablet-android-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">App Users</span>
                        <span class="info-box-number" id="NoOfAppUsers">-</span>
                    </div>
                  
                </div>
               
            </div>
          
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard text-white"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Active Notice</span>
                        <span class="info-box-number" id="NoOfNotices">-</span>
                    </div>
                   
                </div>
               
            </div>
          
        </div>

        <!-- 2nd row -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-books"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Courses</span>
                        <span class="info-box-number" id="NoOfCourses"> -
                        </span>
                    </div>
                </div>  
            </div>
          
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fad fa-book-open"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Courses Accessed</span>
                        <span class="info-box-number" id="NoOfCoursesJoined"> - </span>
                    </div>
                </div>
            </div>
           
            <div class="clearfix hidden-md-up"></div>

            <a href="careers-applicantlist" class="col-12 col-sm-6 col-md-3 " style="color:black;">
            <!-- <div class="col-12 col-sm-6 col-md-3"> -->
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-pen-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Applicants</span>
                        <span class="info-box-number" id="TotalNoOfApplicants">-</span>
                    </div>
                </div> 
            <!-- </div> -->
            </a>
            <a href="careers-jobposted"  class="col-12 col-sm-6 col-md-3 " style="color:black;">
            <!-- <div class="col-12 col-sm-6 col-md-3"> -->
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-school text-white"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Active Job</span>
                        <span class="info-box-number" id="NoOfOpenJob">-</span> 
                    </div>
                </div> 
            </a>
            <!-- </div> -->
            

            <a href="settings-todayVisitList"  class="col-12 col-sm-6 col-md-3" style="color:black;">
            <!-- <div class="col-12 col-sm-6 col-md-3"> -->
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-school text-white"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Today Visit</span>
                        <span class="info-box-number" id="VisitInaDay">-</span>
                    </div>
                </div>
            <!-- </div> -->
            </a>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-school text-white"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">OverAll Visit</span>
                        <span class="info-box-number" id="TotalVisit">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Attendance

                    </h3>
                    <span class="float-right">
                        <label class="radio-inline mx-3">
                            <input type="radio" name="optradio" value="1" checked> Yearly
                        </label>
                        <label class="radio-inline mx-3">
                            <input type="radio" name="optradio" value="2"> Monthly
                        </label>
                        <label class="radio-inline mx-3">
                            <input type="radio" name="optradio" value="3"> Class Wise
                        </label>
                    </span>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" style="position: relative; height: 300px;">
                            <canvas id="attendancechart" height="450" style="height: 300px; display: block; width: 157px;" width="235" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>

</div>
<!-- /.content-wrapper -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function() {

        getTotalVisitinaDay();
        // getDashboard();

        // let session = JSON.parse(sessionStorage.getItem("session"));
        // if (session === null || session === undefined || session.length===0)
        //     getSession();
        // else{
        // }
    });

     function getTotalVisitinaDay()
     {
        let obj = {};
        obj.Module = "Settings";
        obj.Page_key = "getAllvisitedUserInaDay";
        obj.JSON = {};
        TransportCall(obj);
     }

    function getSession() {
        let obj = {};
        obj.Module = "Settings";
        obj.Page_key = "getSessions";
        obj.JSON = {};
        TransportCall(obj);
    }

    function getDashboard() {

        let obj = {};
        obj.Module = "Settings";
        obj.Page_key = "getDashboard";
        obj.JSON = {};
        TransportCall(obj);
    }

    var monthlyAttendance=[];
    var dailyAttendance=[];
    var classAttendance=[];

    function onSuccess(rc) {
        debugger;
        if (rc.return_code) { 
            switch (rc.Page_key) {
                case "getSessions":
                    loadSelect("#session",rc.return_data,false);
                    sessionStorage.setItem("session",JSON.stringify(rc.return_data));
                    break;
                case "getDashboard":
                    loaddata(rc.return_data);
                    monthlyAttendance = rc.monthlyAttendance;
                    loadChart(monthlyAttendance);
                    notify('success',"Welcome to PrayagEdu VTA");
                    break;

                case "getAllvisitedUserInaDay":

                    $("#VisitInaDay").text(rc.return_data['TotalVisitInADay']);
                    $("#TotalVisit").text(rc.TotalVisit['TotalVisit']);

                    $("#TotalNoOfApplicants").text(rc.TotalApplicants['totalApplicants']);
                    $("#NoOfOpenJob").text(rc.TotalActiveJob['totalActive']);

                   // ,
                   
                    break;

                default:
                    notify('error',"Unable to process the request");
                    break;
             
            }
        }
        else{
           
            notify('error',rc.return_data);    
        
        }
    }
    function loaddata(data){

        $('#NoOfTeachers').text(data["NoOfTeachers"]);
        $('#NoOfStudents').text(data["NoOfStudents"]);
        $('#NoOfAppUsers').text(data["NoOfAppUsers"]);
        $('#NoOfNotices').text(data["NoOfNotices"]);
        $('#NoOfCourses').text(data["NoOfCourses"]);
        $('#NoOfCoursesJoined').text(data["NoOfCoursesJoined"]);
        $('#NoOfActiveAssessment').text(data["NoOfActiveAssessment"]);
        $('#NoOfClasses').text(data["NoOfClasses"]);
     

    }
    var myChart;
    function loadChart(monthlyAttendance){
        'use strict'

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var $salesChart = $('#attendancechart')
        // eslint-disable-next-line no-unused-vars

        var months=[];
        var presentData=[];
        var absentData=[];
        var leaveData=[];
        for (let i = 0; i < monthlyAttendance.length; i++) {
            months.push(monthlyAttendance[i].Months);
            presentData.push(monthlyAttendance[i].Present);
            absentData.push(monthlyAttendance[i].Absent);
            leaveData.push(monthlyAttendance[i].Leaves);
        }

        myChart = new Chart($salesChart, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Present',
                        backgroundColor: '#01e383',
                        borderColor: '#01e383',
                        data: presentData
                    },
                    {
                        label: 'Absent',
                        backgroundColor: 'rgba(252,33,33,0.91)',
                        borderColor: 'rgba(252,33,33,0.91)',
                        data: absentData
                    },
                    {
                        label: 'Leave',
                        backgroundColor: 'rgb(33,168,252)',
                        borderColor: 'rgb(33,168,252)',
                        data: leaveData
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,

                            // Include a dollar sign in the ticks
                            callback: function (value) {
                                if (value >= 1000) {
                                    value /= 1000
                                    value += 'k'
                                }

                                return '$' + value
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    
    }

    $("input[name=optradio]").change(function (){
        console.log($(this).val());
        myChart.destroy();
        if ($(this).val()==1){
            loadChart(monthlyAttendance);
        }else if ($(this).val()==2){
            loadChart(dailyAttendance);
        }else {
            loadChart(classAttendance);
        }
    });
</script>
 
 