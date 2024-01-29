<!-- summernote -->
<link rel="stylesheet" href="assets/admin/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> -->
<link rel="stylesheet" href="assets/admin/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css">
<style>
    .ui-datepicker {
        width: 210px;
        height: auto;
        margin: 5px auto 0;
        font: 9pt Arial, sans-serif;
        -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);
        -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);
    }

    .ui-datepicker table {
        width: 100%;
        background: #FFFBF5;
    }

    .ui-datepicker a {
        text-decoration: none;
    }

    .ui-datepicker-header {
        /* background: url('../img/dark_leather.png') repeat 0 0 #000; */
        background: #FFFBF5;
        color: #0F0F0F;
        font-weight: bold;
        -webkit-box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, 2);
        -moz-box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, .2);
        box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, .2);
        text-shadow: 1px -1px 0px #000;
        filter: dropshadow(color=#000, offx=1, offy=-1);
        line-height: 30px;
        border-width: 1px 0 0 0;
        border-style: solid;
        border-color: #111;
    }

    #logo {
        width: 80px;
        height: 60px;
        border-radius: 10px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Client Subscription
                            </div>

                            <span class="float-right">
                                <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg"> <i class="fa fa-circle-thin"> <i class="fa fa-plus"></i> </i>Subscription(s)</button>
                            </span>


                            <!-- modal-unsubcribe-->
                            <!-- ########################################################################### form to UNsubscribe ################################################## -->
                            <div class="modal fade" id="modal-unsubscribe">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Unsubscribe </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body text-center">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="unsubscribereason">Why do You want to unsubscribe?</label>
                                                            <textarea name="" id="unsubscribereason" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="btnUnsubscribe">Save </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            <!-- modal-domain-call--->
                            <div class="modal fade" id="modal-domaincall">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Domain </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12 mt-3">

                                                            <div class="card-header">

                                                            </div>
                                                            <div class="card">
                                                                <div class="formbold-main-wrapper">
                                                                    <div class="formbold-form-wrapper">
                                                                        <form method="POST" action="">
                                                                            <div class="formbold-steps">
                                                                                <ul>
                                                                                    <li class="formbold-step-menu1 active">
                                                                                        <span>1</span>
                                                                                        Server
                                                                                    </li>
                                                                                    <li class="formbold-step-menu2">
                                                                                        <span>2</span>
                                                                                        Domain
                                                                                    </li>
                                                                                    <li class="formbold-step-menu3">
                                                                                        <span>3</span>
                                                                                        Start Up
                                                                                    </li>

                                                                                </ul>
                                                                            </div>

                                                                            <div class="formbold-form-step-1 active">
                                                                                <div class="card-body">
                                                                                    <p>Select Server For The Domain</p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="form-group">
                                                                                        <label for="server_name">Server Name </label>
                                                                                        <select class="form-control" name=" " id="server_name">
                                                                                        </select>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="formbold-form-step-2">
                                                                                <div class="card-body">
                                                                                    <p>Set Up Domain For First Time Use</p>
                                                                                </div>
                                                                                <div>
                                                                                    <label for="address" class="formbold-form-label"> Domain Name : </label>
                                                                                    <input type="text" id="domain_name" class="form-control" class="formbold-form-input" readonly>
                                                                                </div>

                                                                                <!-- <div>
                                                                                    <label for="address" class="formbold-form-label"> DD Source : </label>
                                                                                    <input type="text" id="db_source" class="form-control"  class="formbold-form-input" readonly>
                                                                                </div> -->
                                                                            </div>

                                                                            <div class="formbold-form-step-3">
                                                                                <div class="card-body">
                                                                                    <i class="icon fas fa-cog  fa-4x"></i>
                                                                                    <br>
                                                                                    <br>
                                                                                    <p>Set Up For First Time Use</p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="formbold-form-btn-wrapper">
                                                                                <button class="formbold-back-btn">
                                                                                    Back
                                                                                </button>

                                                                                <button  class="formbold-btn" id="createDomain">
                                                                                    Proceed
                                                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                        <g clip-path="url(#clip0_1675_1807)">
                                                                                            <path d="M10.7814 7.33312L7.20541 3.75712L8.14808 2.81445L13.3334 7.99979L8.14808 13.1851L7.20541 12.2425L10.7814 8.66645H2.66675V7.33312H10.7814Z" fill="white" />
                                                                                        </g>
                                                                                        <defs>
                                                                                            <clipPath id="clip0_1675_1807">
                                                                                                <rect width="16" height="16" fill="white" />
                                                                                            </clipPath>
                                                                                        </defs>
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.container-fluid -->
                                            </section>

                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            <!-- ########################################################################### form to subscribe ################################################## -->

                            <div class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Client Subscription </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body text-center">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ClientId">Client</label>
                                                            <select class="form-control" name="" id="ClientId">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="productID">Product</label>
                                                            <select class="form-control" name="" id="productID">
                                                            </select>
                                                            <!-- <input type="text" id="productID" class="form-control" placeholder="start Date"  autocomplete="off">   -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="subscriptionId">Product Subscription</label>
                                                            <select class="form-control" name="" id="subscriptionId">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="startDate">Start Date</label>
                                                            <input type="text" id="startDate" class="form-control" placeholder="Start Date" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="text" name="" class="form-control" maxlength="6" style="display:none" id="productamount">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="endDate">End date</label>
                                                            <input type="text" id="endDate" class="form-control" placeholder="End Date" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="maxUser">Max User</label>
                                                            <input type="number" name="" class="form-control" placeholder="Max User" maxlength="4" id="maxUser">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input type="number" name="" class="form-control" Placeholder="Amount" maxlength="6" id="amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="remark">Rate</label>
                                                            <input type="number" id="rate" class="form-control" placeholder="Rate" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="installment">Installment</label>
                                                            <input type="number" name="" class="form-control" Placeholder="InstallMent" id="installment">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="nextDueDate"> Next Due Date</label>
                                                            <input type="text" name="" class="form-control" placeholder="Next Due date" id="nextDueDate">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="nextDueAmount">Next Due Amount </label>
                                                            <input type="text" name="" class="form-control" placeholder="Next Due Amount" id="nextDueAmount">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="remark">Remarks</label>
                                                            <input type="text" id="remark" class="form-control" placeholder="Remarks" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="terms"> Terms</label>
                                                            <input type="file" id="terms" class="form-control" accept="image/x-png,image/jpeg,image/jpg" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="max-width: 50px; max-height: 50px;">

                                                                </div>
                                                                <!-- <div class="fileinput-preview fileinput-exists thumbnail " style="max-width:50px; max-height: 50px;">
                                                                    <img src="assets/img/image_placeholder.jpg" alt="..." style="max-width: 100px; max-height: 100px;">
                                                                </div> -->
                                                                <div>
                                                                    <span class="btn btn-round btn-file mt-3">
                                                                        <span class="">Add logo</span>
                                                                        <input type="file" name="PassportPhoto" accept="image/x-png,image/jpeg,image/jpg" onchange="previewImage(event)">
                                                                        <img id="logo" src="assets/img/image_placeholder.jpg"> <!-- added by dev on 03/11/2023 -->
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="api">API</label>
                                                            <input type="text" id="api" class="form-control" placeholder="https://test.com/index.php" autocomplete="off">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="btnSave">Save </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Product Name </th>
                                        <th scope="col">Subscription ID</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Max User</th>
                                        <th scope="col">Transaction Id</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">InstallMent</th>
                                        <th scope="col">Next Due Date</th>
                                        <th scope="col">Next Due Amount</th>
                                        <th scope="col">API</th>
                                        <th scope="col">Product Logo</th>
                                        <th scope="col">Terms</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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

<script src="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
<script src="assets/admin/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

<script>
    $("#startDate").datepicker({

        dateFormat: 'yy-mm-dd',
        onSelect: function(selectedDate) {
            if (this.id == 'startDate') {

                var arr = selectedDate.split("-");
                var date = new Date(arr[0] + "-" + arr[1] + "-" + arr[2]);
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var minDate = new Date(y, m, d + 31);
                var nextduedate = new Date(y, m, d + 62);
                //var mdate=;
                //var mdate= minDate;

                $("#endDate").datepicker('setDate', minDate);
                $("#nextDueDate").datepicker('setDate', nextduedate);

            }
        }
    });
    $("#endDate").datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $("#nextDueDate").datepicker({
        dateFormat: 'yy-mm-dd'
    });

    //############################## CHANGE AMOUNT(TO BE GET FROM THE PRODUCT SUBSCRIPTION) BASED ON MAXUSER ################################
    $('#maxUser').change(function() {
        var maxuser = ($('#maxUser').val());
        var productAmount = ($('#productamount').val());
        var totalAmount = maxuser * productAmount;
        $('#amount').val(totalAmount);
        $('#nextDueAmount').val(totalAmount);
    });

    $(function() {
        getClient_subscription();
        getClients();
        getProducts();
        getActiveProductSubscription();
        getAllServer();
    });

    function getClient_subscription() {

        var obj = new Object();
        obj.Module = "Client";
        obj.Page_key = "getClient_subscription";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    function getClients() {
        var obj = new Object();
        obj.Module = "Client";
        obj.Page_key = "getClients";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    //get all active
    function getActiveProductSubscription() {
        var obj = new Object();
        obj.Module = "Products";
        obj.Page_key = "getActiveProductSubscription";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }
    // function getProductsubscription(productID) {  
    //     var obj = new Object();
    //     obj.Module = "Products";
    //     obj.Page_key = "getProductsubscription";
    //     var json = new Object(); 
    //     json.ProductID=productID;          
    //     obj.JSON = json;
    //     TransportCall(obj);
    // }

    function getProducts() {
        var obj = new Object();
        obj.Module = "Products";
        obj.Page_key = "getProducts";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    function getAllServer() {
        var obj = new Object();
        obj.Module = "Settings";
        obj.Page_key = "getAllServer";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }



    function clearform() {
        $('#ClientId').val('');
        $('#productID').val('');
        $('#subscriptionId').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#amount').val('');
        $('#maxUser').val('');
        $('#remark').val('');
        $('#installment').val('');
        $('#nextDueDate').val('');
        $('#nextDueAmount').val('');
        $('#api').val('');
        $('#unsubscribereason').val('');
    }

    let ProductSubscription;

    function onSuccess(rc) {

        if (rc.return_code) {
            switch (rc.Page_key) {

                case "getActiveProductSubscription":
                    ProductSubscription = rc.return_data;
                    loadSelect("#subscriptionId", rc.return_data);
                    break;

                case "Unsubscribe":
                    $("#modal-unsubscribe").modal("hide");
                    getClient_subscription();
                    clearform();
                    break;


                case "addClientSubscription":
                  
                    $("#modal-lg").modal("hide");
                    if (rc.return_data) { // added by dev on 26/10/23
                        getAPIbasedOnID(rc.data);
                        // getURLBasedOnProductID(rc.basedURL);

                    }
                    // getClient_subscription(); 
                    clearform();
                    break;

                case "getClient_subscription":

                    loaddata(rc.return_data);
                    break;

                case "getAllServer":
                    loadSelect("#server_name", rc.return_data);
                    break;

                case "getClients":
                    loadSelect("#ClientId", rc.return_data);
                    break;

                case "getProducts":
                    loadSelect("#productID", rc.return_data);
                    // if (rc.return_data) {  // added by dev on 26/10/23
                    //      getURLBasedOnProductID(rc.data);
                    // }

                    break;

                case "deleteClientSubscription":
                    notify("success", rc.return_data);
                    getClient_subscription();
                    break;

                    ///case "getProductsubscription":
                    //debugger;

                    //ProductSubscription=rc.return_data;
                    //loadSelect("#subscriptionId", rc.return_data); 
                    //break;

                case "getDomainNameById": // added by dev on 26/10/23
                    $("#modal-domaincall").modal("show");
                    $("#domain_name").val(rc.domain);
                    // $("#db_source").val(rc.basedURL);
                    // console.log(rc.domain);
                    break;

                    //   case "getBasedURLByProductId": // 
                    //     $("#db_source").val(rc.basedURL);
                    //     // console.log(rc.return_data['basedURL']);
                    //     break; 

                default:
                    notify("error", rc.Page_key);

            }
        } else {
            notify("error", rc.return_data);
        }

    }

    function getAPIbasedOnID(data) // added by dev on 26/10/23
    {
        let obj = {};
        obj.Module = "Client";
        obj.Page_key = "  ";
        let json = {};
        json.ClientSubscriptionID = data;
        obj.JSON = json;
        console.log(obj);
        TransportCall(obj);
    }


    function loaddata(data) {
        var table = $("#table");

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
                text += '<th> ' + data[i].ClientName + '</th>';
                text += '<td> ' + data[i].Name + '</td>';
                text += '<td> ' + data[i].SubscriptionName + '</td>';
                text += '<td> ' + data[i].StartDate + '</td>';
                text += '<td> ' + data[i].EndDate + '</td>';
                text += '<td> ' + data[i].Amount + '</td>';
                text += '<td> ' + data[i].MaxUsers + '</td>';
                text += '<td> ' + data[i].TransectionID + '</td>';
                text += '<td> ' + data[i].Remarks + '</td>';
                text += '<td> ' + data[i].Installment + '</td>';
                text += '<td> ' + data[i].NextDueDate + '</td>';
                text += '<td> ' + data[i].NextDueAmount + '</td>';
                text += '<td> ' + data[i].API + '</td>';
                text += '<td> ' + data[i].ProductLogoPath + '</td>';
                text += '<td> ' + data[i].TermsPath + '</td>';
                text += '<td class="btn-group btn-group-sm">';
                text += '    <a class="btn btn-info btn-sm text-white" onclick="onUnsubscribe(\'' + escape(JSON.stringify(data[i])) + '\')"> Unsubscribe </a>';
                text += '   <a class="btn btn-info btn-sm text-white" onclick="onEdit(\'' + escape(JSON.stringify(data[i])) + '\')"> <i class="fas fa-pencil-alt"> </i> </a>';
                text += '   <a class="btn btn-danger btn-sm text-white" onclick="onDelete(' + data[i].ClientSubscriptionID + ')"> <i class="fas fa-trash"> </i> </a>';
                text += '   <a class="btn btn-success btn-sm text-white" onclick="createDomain(' + data[i].ProductID + ')">Create Domain </a>';
                text += '</td>';
                text += '</tr >';
            }
        }

        $("#table tbody").html("");
        $("#table tbody").append(text);

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

    $("#btnUnsubscribe").click(function() {
        let obj = {};
        obj.Module = "Client";
        obj.Page_key = "Unsubscribe";
        let json = {};
        json.unsubscribereason = $("#unsubscribereason").val();

        if (code != null) {
            json.ClientSubscriptionID = code;
        }
        obj.JSON = json;
        TransportCall(obj);
    });

    $("#btnSave").click(function() {
        let obj = {};
        obj.Module = "Client";
        obj.Page_key = "addClientSubscription";
        let json = {};
        json.clientId = $("#ClientId").val();
        json.ProductId = $("#productID").val();
        json.SubscriptionId = $("#subscriptionId").val();
        json.StartDate = $("#startDate").val();
        json.Enddate = $("#endDate").val();
        json.Amount = $("#amount").val();
        json.MaxUser = $("#maxUser").val();
        json.TransactionId = $("#transactionId").val();
        json.Remarks = $("#remark").val();
        json.Installment = $("#installment").val();
        json.NextDueDate = $("#nextDueDate").val();
        json.nextDueAmount = $("#nextDueAmount").val();
        json.aPi = $("#api").val();
        json.Terms = $("#terms").val();
        json.Logo = $("#logo").val();
        console.log($("#productID").val());

        if (code != null) {
            json.ClientSubscriptionID = code;
        }

        if ($("#ClientId").val() == -1 || $("#api").val() == '') // added by dev on 26/10/23
        {
            notify("error", "Please fill all the important fields");
            return false;
        }
        obj.JSON = json;
        TransportCall(obj);
    });

    function previewImage(event) { //added by dev on 03/11/2023
        var input = event.target;
        var image = document.getElementById('logo');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#createDomain").click(function() { // added by dev on 25/10/23
        let obj = {};
        obj.Module = "Settings";
        obj.Page_key = "createDomain";
        let data = {};
        data.domain_name = $("#domain_name").val();
        data.server = $("#server_name").val();
        // data.ProductID = $("#ProductID").val();
        obj.JSON = data;
        console.log(JSON.stringify(obj));
        TransportCall(obj);
    });

    

    // function getURLBasedOnProductID(data) // added by dev on 01/11/2
    // {
    //     let obj = {};
    //     obj.Module = "Client";
    //     obj.Page_key = "getBasedURLByProductId";
    //     let json = {};
    //     json.ProductId = $("#productID").val();
    //     obj.JSON = json;
    //     console.log(obj);
    //     TransportCall(obj);
    // }


    var code = null;

    function onEdit(data) {

        data = JSON.parse(unescape(data));
        //ClientID
        $('#ClientId').val(data.ClientID);
        $("#productID").val(data.ProductID).change();
        $("#productamount").val(data.productAmount);
        $("#subscriptionId").val(data.ProductSubscriptionID).change();
        $("#startDate").val(data.StartDate);
        $("#endDate").val(data.EndDate);
        $("#amount").val(data.Amount);
        $("#maxUser").val(data.MaxUsers);
        $("#remark").val(data.Remarks);
        $("#installment").val(data.Installment);
        $("#nextDueDate").val(data.NextDueDate);
        $("#nextDueAmount").val(data.NextDueAmount);
        $("#api").val(data.API);

        mode = 2;
        code = data.ClientSubscriptionID;

        $("#modal-lg").modal("show");
    }


    function onDelete(subscriptionId) {
        if (confirm("Are you sure you want to delete")) {
            let obj = {};
            obj.Module = "Client";
            let json = {};
            obj.Page_key = "deleteClientSubscription";
            json.subscriptionId = subscriptionId;
            obj.JSON = json;
            TransportCall(obj);
        }
    }


    var code = null;

    function onUnsubscribe(data) {
        data = JSON.parse(unescape(data));
        mode = 2;
        code = data.ClientSubscriptionID;
        $("#modal-unsubscribe").modal("show");
    }

    //$("#").val(data.ProductID).change();
    $("#productID").change(function() {
        $("#subscriptionId").html("");
        for (let i = 0; i < ProductSubscription.length; i++) {
            if ($("#productID option:selected").val() === ProductSubscription[i].ProductID) {
                $("#subscriptionId").append('<option value="' + ProductSubscription[i].ProductSubscriptionID + '">' + ProductSubscription[i].SubscriptionName + '</option>');
            }
        }
    });
</script>

<script>
  
  const stepMenuOne = document.querySelector('.formbold-step-menu1')
  const stepMenuTwo = document.querySelector('.formbold-step-menu2')
  const stepMenuThree = document.querySelector('.formbold-step-menu3')

  const stepOne = document.querySelector('.formbold-form-step-1')
  const stepTwo = document.querySelector('.formbold-form-step-2')
  const stepThree = document.querySelector('.formbold-form-step-3')

  const formSubmitBtn = document.querySelector('.formbold-btn')
  const formBackBtn = document.querySelector('.formbold-back-btn')

  formSubmitBtn.addEventListener("click", function(event){
    event.preventDefault()
    if(stepMenuOne.className == 'formbold-step-menu1 active') {
        event.preventDefault()

        stepMenuOne.classList.remove('active')
        stepMenuTwo.classList.add('active')

        stepOne.classList.remove('active')
        stepTwo.classList.add('active')

        formBackBtn.classList.add('active')
        formBackBtn.addEventListener("click", function (event) {
          event.preventDefault()

          stepMenuOne.classList.add('active')
          stepMenuTwo.classList.remove('active')

          stepOne.classList.add('active')
          stepTwo.classList.remove('active')

          formBackBtn.classList.remove('active')
 
        })

      } else if(stepMenuTwo.className == 'formbold-step-menu2 active') {
        event.preventDefault()

        stepMenuTwo.classList.remove('active')
        stepMenuThree.classList.add('active')

        stepTwo.classList.remove('active')
        stepThree.classList.add('active')

        formBackBtn.classList.remove('active')
        formSubmitBtn.textContent = 'Submit'
      } else if(stepMenuThree.className == 'formbold-step-menu3 active') {
        document.querySelector('form').submit()
      }
  })
    

 
  
</script>