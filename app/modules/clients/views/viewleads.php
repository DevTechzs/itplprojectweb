<!-- summernote -->
<link rel="stylesheet" href="assets/admin/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.css">

<link rel="stylesheet" href="assets/admin/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Prayagedu Leads
                            </div>

                            <span class="float-right">
                                <!-- <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg"> <i class="fa fa-circle-thin"> <i class="fa fa-plus"></i> </i>Add Client(s)</button> -->
                            </span>

                            <!-- <div class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                     <form method="post" >
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Add Clients</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body text-center">

                                                <div class="row">
                                                   
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="client_name">Client Name</label>
                                                            <input type="text" id="client_name" class="form-control" maxlength="30" placeholder="Client Name" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="telephone_number">Telephone Number</label>
                                                            <input type="text" id="telephone_number" class="form-control" onkeypress="javascript:return isNum(event)" maxlength="10" placeholder="Telephone Number" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="mobile_no">Mobile Number</label>
                                                            <input type="text" id="mobile_no" class="form-control" onkeypress="javascript:return isNum(event)" maxlength="10" placeholder="Mobile Number"  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">                                  
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="max-width: 50px; max-height: 50px;">
                                                               
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail " style="max-width:50px; max-height: 50px;">
                                                                <img src="assets/img/image_placeholder.jpg" alt="..." style="max-width: 100px; max-height: 100px;">
                                                            </div>
                                                            <div>
                                                                <span class="btn btn-round btn-file mt-3">
                                                                   
                                                                    <span class="">Add logo</span>
                                                                    <input type="file" id="logo" name="PassportPhoto" accept="image/x-png,image/jpeg,image/jpg" required>
                                                                </span>
                                                               
                                                            </div>
                                                        </div> 
                                                    </div>
                                                   
                                                </div>
                                          
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="fax">Fax</label>
                                                            <input type="text" id="fax" class="form-control" placeholder="Fax" maxlength="15" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="contact_name">Contact Name</label>
                                                            <input type="text" id="contact_name" class="form-control" maxlength="30" placeholder="Contact Name"  autocomplete="off">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="contact_number">Contact Number </label>
                                                            <input type="text" id="contact_number" class="form-control" onkeypress="javascript:return isNum(event)" placeholder="Mobile Number" maxlength="10" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="person_designation">Person Designation</label>
                                                            <input type="text" id="person_designation" class="form-control" maxlength="20" placeholder="Person Designation" autocomplete="off">
                                                        </div>
                                                    </div>            
                                                </div>
                                                                                      
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="state">State</label>
                                                            <select class="form-control" name="" id="state"> 
                                                            </select>
                                                         </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="district">District</label>
                                                            <select class="form-control" name="" id="district">
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="city_name">City Name</label>
                                                            <input type="text" id="city_name" class="form-control" maxlength="15" placeholder="City" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="pincode">Pincode</label>
                                                            <input type="text" id="pincode" class="form-control" onkeypress="javascript:return isNum(event)" maxlength="6" placeholder="Pincode" autocomplete="off">
                                                        </div>
                                                    </div>

                                                </div>
                                                  
                                                <div class="row">
                                                   
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="landmark">Landmark </label>
                                                            <input type="text" id="landmark" class="form-control" placeholder="Landmark" autocomplete="off">
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="maxuser">Max User </label>
                                                            <input type="text" id="maxuser" class="form-control" placeholder="Max User" maxlength="3" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="btnAddClient">Save </button>                                          
                                        </div>
                                     </form>
                                    </div>
                                   
                                </div>
                               
                            </div> -->


                        </div>
                      
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Organisation</th>
                                    <th scope="col">School Name</th>
                                    <th scope="col">isPositive</th>
                                    <th scope="col">isContacted </th>
                                    <th scope="col">AddedOn </th>
                                    <th scope="col">Remarks </th>
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
<!-- validating input -->

<!-- Summernote -->
<script src="assets/admin/plugins/summernote/summernote-bs4.min.js"></script>

<script src="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
<script src="assets/admin/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

<script>
      $(function() {
        getPrayagEduLeads();
      
    });

   function  getPrayagEduLeads()
    {
        var obj=new Object();
        obj.Module = "Client";
        obj.Page_key = "getPrayageduLeads";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    function onSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getPrayageduLeads":
                loaddata(rc.return_data);
                break;

            default:
                alert(rc.Page_key);
        }
    } else {
        alert(rc.return_data);
    }
    // alert(JSON.stringify(args));
    }
    
    function loaddata(data) 
    {
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
                text += '<td> ' + data[i].Name + '</td>';
                text += '<td> ' + data[i].ContactNo + ' <br> '+ (data[i].Email ? data[i].Email : "<span class='badge badge-danger'>NA</span>") +'</td>';
                if(data[i].OrganizationTypeID==1)
                {
                    Organization="Independent";
                }
                else{
                    Organization="Group <br>  <span class='badge badge-info'>"+ data[i].BrandCount + "</span>";
                }
                text += '<td> ' + Organization + '</td>';
                text += '<td> ' + data[i].SchoolGroupName + '</td>';
                text += '<td> ' +  (data[i].isPositive ? "<span  class='badge badge-success'> Yes </span>" :  "<i class='badge badge-danger'> No </i>")  + '</td>';
                text += '<td> ' + (data[i].isContacted  ? "<span class='badge badge-success'> Yes </span>" : "<span class='badge badge-danger'> No </span>")+ '</td>';
                text += '<td> ' + data[i].EntryDateTime + '</td>';
                text += '<td> ' + (data[i].ContactedRemarks ? data[i].ContactedRemarks : "<span class='badge badge-danger'>NA</span>" )+ '</td>';
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

</script>


