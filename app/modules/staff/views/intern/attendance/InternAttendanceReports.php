

<style>
     /* .content,.card{
        background-color: black;
        color:white;
    } */
        .attendance-summary-float {
                z-index: 9999;
        position: fixed;
        top: 18%;
        right:10px;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        }

        .attendance-summary-float a {
        display: block;  
        padding: 4px;
        color: white;
        text-align: center;
        font-size: 18px;
        transition: all 0.5s ease;
        
        } 
        .attendance-summary-float a:hover {
        background-color: #000;
        }
        .summaryTotal {
            color: #FFF; 
        background: #55ACEE;
        }
        .summaryP {
        color: #FFF;
        background: #28a745;
        }

        .summaryA{
            color: #FFF; 
        background: #dd4b39;
        }

</style>

<!-- summernote -->
<link rel="stylesheet" href="assets/admin/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.css">
<link rel="stylesheet" href="assets/admin/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css">
<link rel="stylesheet" href="assets/admin/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css">

<!-- DataTables -->
<link rel="stylesheet" href="assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">

        <div class="row p-3">
            <!-- Today Report -->
            <div class="col-12 col-sm-6 col-md-3">
              
                    <div class="info-box" title="Today Report">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>

                        <div class="info-box-content TodayReport ">
                            <span class="info-box-text">Today Report</span>
                            <span class="info-box-number" id="TodayReport"></span>
                        </div>
                    </div>
                
            </div>
           
            <!-- Yesterday Report -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="far fa-list"></i></span>
                    <div class="info-box-content YesterdayReport" title="Yesterday Report">
                        <span class="info-box-text">Yesterday Report</span>
                        <span class="info-box-number" id="YesterdayReport"> </span>
                    </div>
                </div>
            </div>
            

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <!-- Staff Attendance -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>

                    <div class="info-box-content AttendanceReport" title="Attendance Report">
                        <span class="info-box-text"> Attendance Report </span>
                        <span class="info-box-number" id="AttendanceReport"></span>
                    </div>
                </div>  
            </div>
            <!-- /.col -->
        </div>

        <!-- staff attendance report div -->
        <div class="row" id="AttendanceReportdiv">
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-sm bg-danger" id="closeStaffAttendance" style="float:right;"> <i class="fa fa-times"></i></button>   
                        <div class="card-title">
                            Staff Attendance
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <label for="searchby">Search by</label>
                                <select name="" id="searchby" class="form-control mb-3">
                                    <option value="">select here</option>
                                    <option value="date">Date</option>
                                    <option value="year">Year</option>
                                    <option value="staff">Staff</option>
                                    <option value="month">Month</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="div1"> <br>
                                <input type="date" class="form-control mt-2 " id="date1" value="<?php  echo date("Y-m-d"); ?>" style="display:none;" max=<?php echo date("Y-m-d"); ?>>
                                <input type="text" id="year" placeholder="Year"  onkeypress="javascript:return isNum(event)" maxlength="4" class="form-control mt-2" style="display:none;">
                                <select name="" id="staff" class="form-control mt-2"  style="display:none;"></select>
                            </div>

                            <div class="col-md-6" id="selectMonthDesignation" style="display:none;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="loadMOnth">Month</label>
                                        <select name="" class="form-control" id="loadMOnth">  </select>
                                    </div> 
                                    <div class="col-md-3"> 
                                        <label for="loadDesignation">Designation</label>
                                        <select name="" class="form-control" id="loadDesignation">  </select>
                                    </div>
                                </div>  
                            </div>

                        </div>


                        


                        <table id="staffReports" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Staff Name </th>
                                    <th scope="col">Mobile Number</th>
                                    <th scope="col">Designation</th>
                                    <!-- <th scope="col">Department</th> -->
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <!-- by year -->
                        <table id="staffReportsbyyear" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Staff Name </th>
                                    <th scope="col">Present</th>
                                    <th scope="col">Absent</th>
                                    <!-- <th scope="col">Department</th> -->
                                    <th scope="col">Onleave</th>
                                    <th scope="col">Over All </th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <!-- by month and designation -->
                        <!-- <table id="staffReportsbyMonthAndDesignation" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Staff Name </th>
                                    <th scope="col">Present</th>
                                    <th scope="col">Absent</th>
                                  
                                    <th scope="col">Onleave</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table> -->

                    </div>
                    <div class="card-footer">
                        <a href="#" class="text-primary">View All</a>
                        
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


             <!--  #####################  TODAY REPORT ############################# -->
            <div class="row" id="todayReportdiv">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                        <button class="btn btn-sm bg-danger" id="closeTodayReport1" style="float:right;"> <i class="fa fa-times"></i></button>   
                            <div class="card-title">
                                Today Report
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="todayReport" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Staff Name </th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Designation</th>
                                        <!-- <th scope="col">Department</th> -->
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="text-primary">View All</a>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <div class="row" id="todayReportdiv1">
                <div class="col-6 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Today Present Report
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="todayPresentReport" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Staff Name </th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Designation</th>
                                        <!-- <th scope="col">Department</th> -->
                                        <th scope="col">Status </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="text-primary">View All</a>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Today Absent Report
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="absentReport" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Staff Name </th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Designation</th>
                                        <!-- <th scope="col">Department</th> -->
                                        <th scope="col">Status  </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="text-primary">View All</a>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            

            <!--  #####################  YESTERDAY REPORT ############################# -->
            <div class="row" id="yesterdayReportDiv">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                        <button class="btn btn-sm bg-danger" id="closeYesterdayReport" style="float:right;"> <i class="fa fa-times"></i></button>   
                     
                            <div class="card-title">
                                Yesterday Report
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="yesterdayReport" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Staff Name </th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="text-primary">View All</a>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Summernote -->
  <script src="assets/admin/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
<script src="assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>


<script>
    function isNum(evt)
    {
        var charCode=(evt.which)?evt.which:event.keyCode
        if(charCode>31 && (charCode<48 || charCode>57)){
            return false;
        }
        else{
            return true;
        }
    }

            // close/open  div
            $("#closeStaffAttendance").click(function(){
                $("#AttendanceReportdiv").hide();
            });

            $(".TodayReport").click(function(){
                $("#todayReportdiv").show();
                $("#todayReportdiv1").show(); 
            });

            $(".AttendanceReport").click(function(){
                $("#AttendanceReportdiv").show();
            });

            $("#closeTodayReport1").click(function(){
                $("#todayReportdiv").hide();
                $("#todayReportdiv1").hide(); 
            });

            $("#YesterdayReport").click(function(){
                $("#yesterdayReportDiv").show();
            }); 
            $("#closeYesterdayReport").click(function(){
                $("#yesterdayReportDiv").hide();
             });
            
</script>
<script>
       $("#searchby").change(function (){
        if($("#searchby option:selected").val()=='date')
        { 
            $('#date1').show(); 
            getreportBydate($("#date1").val(),$("#searchby").val())
            $('#staff').hide(); 
            $('#year').hide();
            $('#div1').show(); 
            $('#selectMonthDesignation').hide(); 
        } 
        else if($("#searchby option:selected").val()=='year')
        {
            $('#year').show(); 
            $('#staffReports').hide(); 
            $('#staffReportsbyyear').show(); 
            $('#date1').hide(); 
            $('#staff').hide();
            $('#div1').show(); 
            $('#selectMonthDesignation').hide(); 
        }
        else if($("#searchby option:selected").val()=='staff')
        {
            $('#staff').show();
            getDesignation();
            $('#year').hide(); 
            $('#date1').hide();  
            $('#div1').show(); 
            $('#selectMonthDesignation').hide(); 
        }
        else if($("#searchby option:selected").val()=='month')//month
        {
            $('#staffReports').hide(); 
            $('#staffReportsbyyear').show(); 
            getMonths();
            $('#div1').hide(); 
            $('#selectMonthDesignation').show(); 
            $('#staffReportsbyyear').show(); 
        }
        else
        {
            notify("warning","You have not selected any option");
        }
       
    });

    $("#date1").change(function (){
        getreportBydate($("#date1").val(),$("#searchby").val())
    });

    $("#loadMOnth").change(function(){
        if($("#loadMOnth").val()==-1)
        {
           notify("warning","Please select an Option");
           return false;
        }
        else
        {
            getDesignation();
        }
    });

    $("#loadDesignation").change(function(){

        // check if both is selected
        if($("#loadMOnth").val()==-1 || $("#loadDesignation").val()==-1)
        {
            notify("warning","All field cannot be empty");
            return false;
        }

        getreportByMonthDesigantion($("#loadMOnth").val(),$("#loadDesignation").val()); //month,designation
        // alert($("#loadDesignation").val());
    });

    

    $("#year").change(function (){
            var re = /^[0-9]+$/;
            if($("#year").val().match(re))
            {
                getreportByYear($("#year").val(),$("#searchby").val())
            }
            else{
                notify("warning","Invalid Year");
            }
    });

    $("#staff").change(function (){
        getreportByDesignation($("#staff").val(),$("#searchby").val())
    });

     $(function() {
        $('#date1').hide(); 
        $('#staff').hide(); 
        $('#year').hide(); 
        $('#staffReportsbyyear').hide(); 
        
        // getStaffListNotMarkedAttendanceByPercent(); // testing
        // getTodayAttendanceReport(); 
        // getYesterdayAttendanceReport(); 
        // getTodayPresentStaff();
        // getTodayAbsentStaff();
        
    });


    //just for testing
    // function getStaffListNotMarkedAttendanceByPercent()
    // {
    //     let obj = {};
    //     obj.Module = "Staff";
    //     obj.Page_key = "getStaffListNotMarkedAttendanceByPercent";
    //     let json = {};
    //     json.Designation=3; 
    //     json.Date='2023-01-14';
    //     obj.JSON = json;
    //     console.log(obj);
    //     TransportCall(obj); 
    // }

    function getreportByMonthDesigantion(month,Designation)
    {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getreportByMonthDesignation";
        let json = {};
        json.Designation=Designation; 
        json.Month=month;
        obj.JSON = json;
        console.log(obj);
        TransportCall(obj); 
    }

    function getMonths(){
        let obj = {};
        obj.Module = "Settings";
        obj.Page_key = "getMonths";
        obj.JSON = {};
        TransportCall(obj);
    }
    
    function getDesignation() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getDesignation";
        obj.JSON = {};
        TransportCall(obj);
    } 

    function getreportByDesignation(designation,searchby) {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getreportByDesignation";
        let json = {};
        json.designation=designation;
        json.Searchby=searchby;
        obj.JSON = json;
        TransportCall(obj); 
    }

    function getreportByYear(year,searchby) {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getreportByYear";
        let json = {};
        json.attendanceYear=year;
        json.Searchby=searchby;
        obj.JSON = json;
        TransportCall(obj); 
    } 

    function getreportBydate(date,searchby) {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getreportBydate";
        let json = {};
        json.attendanceDate=date;
        json.Searchby=searchby;
        obj.JSON = json;
        TransportCall(obj); 
    }

    function getTodayAbsentStaff() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getTodayAbsentStaff";
        obj.JSON = {};
        TransportCall(obj);
    } 
    function getTodayPresentStaff() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getTodayPresentStaff";
        obj.JSON = {};
        TransportCall(obj);
    } 

    function getTodayAttendanceReport() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getTodayAttendanceReport";
        obj.JSON = {};
        TransportCall(obj);
    } 
    function getYesterdayAttendanceReport() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getYesterdayAttendanceReport";
        obj.JSON = {};
        TransportCall(obj);
    } 

    function onSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {

            case "getMonths":
                loadSelect("#loadMOnth", rc.return_data);
                break;

            case "getDesignation":
                loadSelect("#staff", rc.return_data);
                loadSelect("#loadDesignation", rc.return_data); 
                break;

            case "getTodayAttendanceReport":
                loaddata(rc.return_data); 
                break;

            case "getYesterdayAttendanceReport":
                loadYesterdayReport(rc.return_data); 
                break;

            case "getTodayPresentStaff":
                loadTodayPresentReport(rc.return_data); 
                break;
                
            case "getreportBydate":
                loadstaffReport(rc.return_data); 
                break;

            case "getTodayAbsentStaff":
                loadTodayAbsentReport(rc.return_data);
                $("#staffReportsbyyear").hide(); 
                break;

            case "getreportByYear":
                loadstaffbyyear(rc.return_data);
                $("#staffReports").hide();
                break;

            case "getreportByDesignation":
                $("#staffReportsbyyear").hide(); 
                $("#staffReports").show();
                loadstaffReport(rc.return_data); 
                break;

            case "getreportByMonthDesignation":
                loadstaffbyyear(rc.return_data);
                // loadDataMonthDesignation(rc.return_data);
                // console.log(rc.return_data);
                break;
                
                
            default:
                notify("error",rc.Page_key);
        }
    } else {
         notify("error",rc.return_data);
        
    }
    }

    function loaddata(data) 
    {
        var table = $("#todayReport");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].ContactNo + '</td>';
                text += '<td> ' + data[i].DesignationName + '</td>';
                if(data[i].Status=='0')
                {
                    text += '<td> <span class="badge badge-danger"> Absent </span> </td>';
                }
                else{
                    text += '<td > <span class="badge badge-success"> Present </span> </td>';
                }
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

    


        $("#todayReport tbody").html("");
        $("#todayReport tbody").append(text);

        $(table).DataTable({
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }
  
    function loadYesterdayReport(data) 
    {
        var table = $("#yesterdayReport");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].ContactNo + '</td>';
                text += '<td> ' + data[i].DesignationName + '</td>';
                if(data[i].Status=='0')
                {
                    text += '<td > <span class="badge badge-danger">Absent </span></td>';
                }
                else{
                    text += '<td > <span class="badge badge-success"> Present </span> </td>';
                }
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#yesterdayReport tbody").html("");
        $("#yesterdayReport tbody").append(text);

        $(table).DataTable({
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }
    function loadTodayPresentReport(data) 
    {
    
        var table = $("#todayPresentReport");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].ContactNo + '</td>';
                text += '<td> ' + data[i].DesignationName + '</td>';
                // text += '<td> ' + data[i].DepartmentID + '</td>';
                if(data[i].Status =='0')
                {
                    text += '<td> <span class="badge bagde-danger">Absent</span> </td>'; 
                }
                else{
                    text += '<td>  <span class="badge badge-danger">Present </span> </td>'; 
                }
                text += '<td> ' +data[i].Status  + '</td>';
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#todayPresentReport tbody").html("");
        $("#todayPresentReport tbody").append(text);

        $(table).DataTable({
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }
    function loadTodayAbsentReport(data) 
    {
        var table = $("#absentReport");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].ContactNo + '</td>';
                text += '<td> ' + data[i].DesignationName + '</td>';
                if(data[i].Status =='0')
                {
                    text += '<td>  <span class="badge badge-danger">Absent </span> </td>'; 
                }
                else{
                    text += '<td>  <span class="bagde badge-success">Present</span> </td>'; 
                }
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#absentReport tbody").html("");
        $("#absentReport tbody").append(text);

        $(table).DataTable({
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }
    function loadstaffReport(data) 
    {
        var table = $("#staffReports");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].ContactNo + '</td>';
                text += '<td> ' + data[i].DesignationName + '</td>';
                text += '<td> ' + data[i].AttendanceDate + '</td>';
                if(data[i].Status =='0')
                {
                    text += '<td > <span class="badge badge-danger"> Absent </span> </td>';
                }
                else{
                    text += '<td > <span class="badge badge-success"> Present </span> </td>';
                }
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#staffReports tbody").html("");
        $("#staffReports tbody").append(text);

        $(table).DataTable({
            
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }
    

    // function loadDataMonthDesignation(data)
    // {
    //     console.log(data);
    // }

    function loadstaffbyyear(data) //(data) 
    {
        console.log(data);
        var table = $("#staffReportsbyyear");

        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' +data[i].StaffName  + '</td>';
                text += '<td> ' + data[i].Present + '</td>';
                text += '<td> ' + data[i].Absent + '</td>';
                text += '<td> ' + data[i].Onleave + '</td>';
                text += '<td> ' + data[i].All + '</td>';
                text += '<td class="btn-group btn-group-sm">';
                text += '   <a class="btn btn-info btn-sm text-white"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i> </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#staffReportsbyyear tbody").html("");
        $("#staffReportsbyyear tbody").append(text);

        $(table).DataTable({
            
            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            "deferRender": true,
            "pageLength": 10,
            buttons: [{
                exportOptions: {
                    columns: ':not(.hidden-col)'
                },
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    exportOptions: {
                        columns: ':not(.hidden-col)'
                    },
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        });
    }

</script>
