<style>
    .attendance-summary-float {
        z-index: 9999;
        position: fixed;
        top: 18%;
        right: 10px;
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

    .summaryA {
        color: #FFF;
        background: #dd4b39;
    }

    .hide_me {
        display: none;
    }


    li[data-dtr-index="4"] {
        display: none;
    }

    li[data-dtr-index="5"] {
        display: none;
    }

    /* .form-check-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .form-check-label {
        cursor: pointer;
    } */
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

<!-- Attendance Summary -->
<div class="attendance-summary-float" id="summary">
    <a href="#" class="summaryP"><i class="fa-solid fa-p text-sm"></i> <span id="countP">P:0</span></a>
    <a href="#" class="summaryA"><i class="fa-solid fa-a text-sm"></i> <span id="countA">A:0</span></a>
    <a href="#" class="summaryTotal"><i class="fa-solid fa-t text-sm"></i> <span id="countTotal">T:0</span></a>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Intern Attendance
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-lg">
                                        <select class="form-control" id="InternCategories"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-lg">
                                        <input type="date" class="form-control form-control-lg" id="AttendanceDate" value="<?php echo date("Y-m-d"); ?>" max=<?php echo date("Y-m-d"); ?>>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-primary" id="onGetAttendance">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm" onclick="Refresh()">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="hide_me" style="display:none;">StaffID</th>
                                                <th scope="col" class="hide_me" style="display:none;">AttendanceID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Present/Absent</th>
                                                <th scope="col">Break In</th>
                                                <th scope="col">Check Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align: right">
                                                    <button class="btn  bg-gradient-success btn-xs" id="SaveAttendance">Save</button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
<!-- load BreakOption Data -->
<!-- modal for break -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Select break options:</p>
                <div class="row" id="breakData">

                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn  bg-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn  bg-info btn-sm" id="btnAddBreak"><i class="fas fa-arrow-circle-right"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- end modal -->
<!-- /.content-wrapper -->


<!-- Summernote -->
<script src="assets/admin/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
<script src="assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<!--<script src="assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>-->
<!--<script src="assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>-->
<!--<script src="assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>-->
<script>
    $(function() {
        getInternCategories();
        $('#SaveAttendance').hide();
        //$('#staffid').hide(); 
        getAllBreakOption();

    });



    $("#teaBreak").click(function() {
        alert("Tea Break");
    });


    function getInternCategories() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getInternCategories";
        obj.JSON = {};
        TransportCall(obj);
    }

    function getAllBreakOption() {
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getAllBreakOption";
        obj.JSON = {};
        TransportCall(obj);
    }




    //get the Intern data based on Categories and  attendance date
    function getInterns(InternCategoriesID, AttendanceDate) {
        debugger;
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "getInternForAttendance"; //getInternForAttendance
        let json = {};
        json.InternCategoriesID = InternCategoriesID;
        json.AttendanceDate = AttendanceDate;
        obj.JSON = json;
        TransportCall(obj);
        //console.log(obj);
    }

    function onSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getInternCategories":
                    loadSelect("#InternCategories", rc.return_data);
                    break;

                case "getInternForAttendance":
                    debugger;
                    loaddata(rc.return_data);
                    break;

                case "getAllBreakOption":
                    loadBreakOption(rc.return_data);
                    console.log(rc.return_data);
                    break;

                case "giveInternManualAttendance":
                    notify("success", rc.return_data);
                    location.reload();
                    $('#SaveAttendance').hide();
                    break;

                case "updateInternIndividualAttendance":
                    notify("success", rc.return_data);
                    recalculateattendance();
                    break;

                case"InternBreakInOut":
                    notify("success",rc.return_data);
                    location.reload();
                    break;

                default:
                    notify("error", rc.Page_key);
            }
        } else {
            notify("error", rc.return_data);
            //clear table
            var table = $("#table");
            try {
                if ($.fn.DataTable.isDataTable($(table))) {
                    $(table).DataTable().destroy();
                }
            } catch (ex) {}
            $("#table tbody").html("");
            $('#SaveAttendance').hide();
        }
    }

    //to load BreakOptions from DB
    var BreakOptionLength = null;

    function loadBreakOption(data) {
        var table = $("#breakData");
        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length === 0) {
            text += "No Data Found";
        } else {
            BreakOptionLength = data.length;
            for (let i = 0; i < data.length; i++) {
                text += '<div class="col-md-3 mb-2">';
                text += ' <div class="form-check">';
                text += ' <input type="checkbox" class="form-check-input breakOption"  value="' + data[i].BreakOptionID + '" id="breakOption' + i + '">';
                text += '<label class="form-check-label" for="breakOption">';
                text += '<i class="' + data[i].BreakIcon + '"></i>';
                text += '</label>';
                text += '</div>';
                text += '</div>';
            }
        }
        $("#breakData").html("");
        $("#breakData").append(text);
    }


    var StaffInternID;
    var InternAttendanceID;

    function takeaBreak(data) {
        data = JSON.parse(unescape(data));
        StaffInternID = data.StaffInternID;
        InternAttendanceID = data.InternAttendanceID;
        $("#modal-lg").modal('show');
    }


    $("#btnAddBreak").click(function() {
        debugger;
        for (var i = 0; i <= BreakOptionLength; i++) {
            if ($('#breakOption' + i).prop('checked') == true) {
                //take a break in 
                let obj = {};
                debugger;
                obj.Module = "Staff";
                obj.Page_key = "InternBreakInOut";
                let json = {};
                json.BreakOption = $("#breakOption" + i).val();
                json.InternAttendanceID = InternAttendanceID;
                json.StaffInternID = StaffInternID;
                obj.JSON = json;
                TransportCall(obj);
            }

        }
    });

    
    function EndBreak(data)
    {
        debugger;
        data = JSON.parse(unescape(data));
        let obj = {};
        obj.Module = "Staff";
        obj.Page_key = "InternBreakInOut";
        let json = {};
        json.InternAttendanceID = data.InternAttendanceID;
        json.StaffInternID = data.StaffInternID;
        json.BreakInOut = data.BreakInOut;
        obj.JSON = json;
        console.log(obj); 
        TransportCall(obj);
    }


    //on change of input designation and date  get staff info
    // $('#Designation,#AttendanceDate').change(function (){
    //   getInterns($('#Designation').val(),$('#AttendanceDate').val()); 
    // });

    //on click of load button get the staff detail
    $('#onGetAttendance').click(function() {
        getInterns($('#InternCategories').val(), $('#AttendanceDate').val());
    });

    // on click of savaAttendance button
    $("#SaveAttendance").click(function() {
        var AttendanceData = [];
        $("#table tbody tr").each(function() {
            AttendanceData.push({
                InternID: $(this).find("td:nth-child(1)").text(),
                Status: $(this).find("td:nth-child(4)").find("input[type='checkbox']").bootstrapSwitch('state')
            });
        });

        if ($("#AttendanceDate").val() == "") {
            notify("warning", "Please Select date!");
            return;
        }
        var data = {
            Module: "Staff",
            Page_key: "giveInternManualAttendance",
            JSON: {
                AttendanceData: AttendanceData,
                InternCategoriesID: $("#InternCategories").val(),
                AttendanceDate: $("#AttendanceDate").val()
            }
        }
        TransportCall(data);
    });

    /*  Info:
        Description: for upadting the status of the attendance
            24-01-2024 (Angelbert) : Adding the function     
    */
    function onStatusChange(Attendanceid, internId) {
        if (updateOnChange) {
            var id = "#s" + internId + "-" + Attendanceid;
            var status = 0;
            if ($(id).bootstrapSwitch('state') == true)
                status = 1;
            var data = {
                Module: "Staff",
                Page_key: "updateInternIndividualAttendance",
                JSON: {
                    AttendanceID: Attendanceid,
                    internId: internId,
                    Status: status,
                    AttendanceDate: $("#AttendanceDate").val()
                }
            }
            TransportCall(data);
        }
        recalculateattendance();
    }

    /*  Info:
        Description: for showing the data  we get  from the server for attendance marking and update
            14-01-2024 (Angelbert) : Adding the function 
    */
    var updateOnChange = false;

    function loaddata(data) {
        updateOnChange = false;
        var table = $("#table");
        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length === 0) {
            text += "No Data Found";
        } else {

            $('#SaveAttendance').show();
            updateOnChange = false;
            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td    class="hide_me">' + data[i].StaffInternID + '</td>';
                text += '<td   class="hide_me">' + data[i].InternAttendanceID + '</td>';
                text += '<td>' + data[i].StaffInternName + '</td>';
                if (data[i].InternAttendanceID != -1) {
                    $('#SaveAttendance').hide();
                    updateOnChange = true;
                    if (data[i].Status == 0) {
                        text += '<td><input class="isPresent" ' + ((data[i].AttendanceModeId == 2) ? " disabled " : " ") + ' type="checkbox" onchange="onStatusChange(' + data[i].InternAttendanceID + ', ' + data[i].StaffInternID + ');" id="s' + data[i].StaffInternID + '-' + data[i].InternAttendanceID + '" style="width: 100%"  data-bootstrap-switch data-on-text="Present" data-off-text="Absent" data-off-color="danger" data-on-color="success"   ></td>';
                    } else if (data[i].Status == 1) {
                        text += '<td><input class="isPresent" type="checkbox" ' + ((data[i].AttendanceModeId == 2) ? " disabled " : " ") + ' onchange="onStatusChange(' + data[i].InternAttendanceID + ', ' + data[i].StaffInternID + ');" id="s' + data[i].StaffInternID + '-' + data[i].InternAttendanceID + '" style="width: 100%"  data-bootstrap-switch data-on-text="Present" checked data-off-text="Absent" data-off-color="danger" data-on-color="success"  ></td>';
                    } else if (data[i].Status == 2) {
                        text += '<td> On Leave</td>';
                    }
                } else
                    text += '<td><input class="isPresent" type="checkbox" id="' + data[i].StaffInternID + '::' + data[i].InternAttendanceID + '" style="width: 100%" checked data-bootstrap-switch data-on-text="Present" data-off-text="Absent" data-off-color="danger" data-on-color="success"   onchange="onStatusChange(' + data[i].InternAttendanceID + ', ' + data[i].StaffInternID + ');";">  <i style="color:red;" class="fa fa-exclamation-circle" aria-hidden="true"></i></td>';

                if (data[i].BreakInOut == 1) { //Check if the partucluar staff is absent then disable the BreakIn Button
                   // text += '<td> <button class="btn bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onClick="takeaBreak()" disabled>' + " Break In" + '</button></td>';
                    text += '<td>&nbsp; <a class="badge badge-danger" onclick="EndBreak(\'' + escape(JSON.stringify(data[i])) + '\')">On Break</a></td>';
                } else {

                    text += '<td> <button class="btn  bg-gradient-info btn-xs"  data-toggle="modal" data-target="#modal-lg" onClick="takeaBreak(\'' + escape(JSON.stringify(data[i])) + '\')" >' + " Break In" + '</button></td>';

                }
                text += '<td><button class="btn  bg-gradient-warning btn-xs">' + " Check Out" + '</button></td>';
                text += '</tr >';
            }
        }

        $("#table tbody").html("");
        $("#table tbody").append(text);
        $(".isPresent").bootstrapSwitch({
            size: "small",
            onColor: "success",
            offColor: "danger",
        });
        recalculateattendance();
        $(table).DataTable({

            aoColumnDefs: [{
                "sClass": "hide_me",
                "aTargets": [1, 2]
            }],

            responsive: true,
            "order": [],
            dom: 'Bfrtip',
            "bInfo": true,
            exportOptions: {
                columns: ':not(.hidden-col)'
            },
            columnDefs: [{
                    target: 1,
                    visible: false,
                    searchable: false,
                },
                {
                    target: 2,
                    visible: false,
                    searchable: false,
                }
            ],
            "deferRender": true,
            "pageLength": 70,
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


    var totalP, totalA, totalcount;

    function recalculateattendance() {
        totalA = 0;
        totalP = 0;
        $("#table tbody tr").each(function() {
            var status = $(this).find("td:nth-child(4)").find("input[type='checkbox']").bootstrapSwitch('state');
            if (status == true) {
                totalP = totalP + 1;
            } else {
                totalA = totalA + 1;
            }
        });

        totalcount = totalA + totalP;
        $('#countP').text("P:" + totalP);
        $('#countA').text("A:" + totalA);
        $('#countTotal').text("T:" + totalcount);
    }

    $('#table_filter').find('input[type="search"]').on('change', function() {
        // alert(); 
    });


    function Refresh() {
        location.reload();
    }
</script>