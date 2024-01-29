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
                                Job Posted
                            </div>

                            <span class="float-right">
                                <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg"> <i class="fa fa-circle-thin"> <i class="fa fa-plus"></i> </i> Post A Job</button>
                            </span>

                            <div class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                     <form method="post" >
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Post New Job</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">

                                                <div class="row">
                                                   
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="JobRole">Post Name <span class="text-danger">*</span></label>
                                                            <input type="text" id="JobRole" class="form-control" maxlength="30" placeholder="Post Name" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="RoleType">Job Type <span class="text-danger">*</span></label>
                                                            <input type="text" id="RoleType" class="form-control"   placeholder=" eg. Contract" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Location">Location <span class="text-danger">*</span></label>
                                                            <input type="text" id="Location" class="form-control"  placeholder="eg. Shillong"  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Worktype">Prefered WorkType <span class="text-danger">*</span></label>
                                                            <input type="text" id="Worktype" class="form-control"  placeholder="eg. Work From Home"  autocomplete="off">
                                                        </div>
                                                    </div> 
                                                </div>  

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="Duration">Duration <span class="text-danger">*</span></label>
                                                        <input type="text" name="" id="Duration"  placeholder="eg. 6 Month" class="form-control">
                                                    </div>
                                                </div>
                                          
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="overview">Overview <span class="text-danger">*</span></label>
                                                            <textarea  id="overview" class="form-control"></textarea>
                                                            <!-- <input type="text" id="fax" class="form-control" placeholder="Fax" maxlength="15" autocomplete="off"> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="Description"> Description <span class="text-danger">*</span></label>
                                                            <textarea  id="Description" class="form-control"></textarea>
                                                            <!-- <input type="text" id="contact_name" class="form-control" maxlength="30" placeholder="Contact Name"  autocomplete="off"> -->
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="Requirements">Requirements  <span class="text-danger">*</span></label>
                                                            <textarea  id="Requirements" class="form-control"></textarea>
                                                            <!-- <input type="text" id="contact_number" class="form-control" onkeypress="javascript:return isNum(event)" placeholder="Mobile Number" maxlength="10" autocomplete="off"> -->
                                                        </div>
                                                    </div>             
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="btnPostaJob">Save </button>                                          
                                        </div>
                                     </form>
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
                                    <th scope="col"></th>
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



<!-- Summernote -->
<script src="assets/admin/plugins/summernote/summernote-bs4.min.js"></script>

<script src="assets/admin/plugins/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
<script src="assets/admin/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

<script>
      $(function() {
        getAllJObPosted();
    });

    function getAllJObPosted()
    {
        var obj=new Object();
        obj.Module = "Careers";
        obj.Page_key = "getAllJObPosted";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    // validation
    let text = new RegExp('^[A-Za-z0-9._ ]*$');
    let numb = new RegExp('^[0-9 ]*$');

    $("#JobRole").change(function(){   
    if(text.test($("#JobRole").val())==false)
      {
          notify("error","Job Role cannot contain any special character");
          $("#JobRole").val('');
          return;
      }
   });
   $("#RoleType").change(function(){   
    if(text.test($("#RoleType").val())==false)
      {
          notify("error","Job Type cannot contain any special character");
          $("#RoleType").val('');
          return;
      }
   });

   $("#Location").change(function(){   
    if(text.test($("#Location").val())==false)
      {
          notify("error","Location cannot contain any special character");
          $("#Location").val('');
          return;
      }
   });
   
 $("#Worktype").change(function(){   
    if(text.test($("#Worktype").val())==false)
      {
          notify("error","WorkType cannot contain any special character");
          $("#Worktype").val('');
          return;
      }
   });

   $("#Duration").change(function(){   
    if(text.test($("#Duration").val())==false)
      {
          notify("error","Duration cannot contain any special character");
          $("#Duration").val('');
          return;
      }
   });
 
    $("#overview").change(function(){   
    if(text.test($("#overview").val())==false)
      {
          notify("error","Overview cannot contain any special character");
          $("#overview").val('');
          return;
      }
   });

   $("#Description").change(function(){   
    if(text.test($("#Description").val())==false)
      {
          notify("error","Description cannot contain any special character");
          $("#Description").val('');
          return;
      }
   });

   $("#Requirements").change(function(){   
    if(text.test($("#Description").val())==false)
      {
          notify("error","Requirements cannot contain any special character");
          $("#Requirements").val('');
          return;
      }
   });

    function onSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getAllJObPosted":
                loaddata(rc.return_data);
                break;

            case "postaJob":
                notify('success',rc.return_data);
                location.reload();
                break;

            case "deletePostedJob":
                notify('success',rc.return_data);
                location.reload();
                break;

            default:
                notify('warning',rc.Page_key);
        }
    } else {
        notify('warning',rc.return_data);
    }
  
    }

    $("#btnPostaJob").click(function(){

        var obj=new Object();
        obj.Module = "Careers";
        obj.Page_key = "postaJob";
        var json = new Object();
        json.CareerID=CareerID;
        json.JobRole=$('#JobRole').val();
        json.RoleType=$('#RoleType').val();
        json.Location=$('#Location').val();
        json.Worktype=$('#Worktype').val();
        json.Duration=$('#Duration').val();
        json.overview=$('#overview').val(); 
        json.Description=$('#Description').val();
        json.Requirements=$('#Requirements').val();
        
        obj.JSON = json;

        if($('#JobRole').val()==''||$('#RoleType').val() =='' || $('#Location').val()==''||  $('#Worktype').val() =='' || $('#Duration').val()=='' || $('#overview').val()=='' || $('#Description').val()=='' || $('#Requirements').val()=='')
        {
                notify('warning',"Important fields cannot be empty");
                return false;
        }
        else{
            TransportCall(obj);
        }

       
    });
    
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
                if(data[i].isActive==0)
                {
                    isActive='<span class="badge badge-danger">Not Active</span>  &nbsp; <span> <b>( '+data[i].CreatedDateTime+')</b></span>';
                }
                else{
                    isActive='<span class="badge badge-success">Active</span>  &nbsp;<span> <b>('+data[i].CreatedDateTime+')</b></span>';
                }

                text += ' <td>'+isActive ;
                text +='<a style="float:right" class="btn btn-info btn-sm text-white" onclick="onEdit(\'' + escape(JSON.stringify(data[i])) + '\')"> <i class="fas fa-pencil-alt"> </i>  &nbsp; </a>  &nbsp;';
               
                text +=' <a style="float:right;" class="btn btn-danger btn-sm text-white" onclick="onDelete(' + data[i].CareersID + ')">  &nbsp;<i class="fas fa-trash"> </i> </a> <br>';
               
                text +=  data[i].Role +'- '+ data[i].RoleType +' <br>';
                text += '<b> Location : </b><br>'+ data[i].WorkLocation +' - '+data[i].PreferredWorkType+'<br>';
                text += '<b> Overview</b><br>'+ data[i].Overview +'<br>';
                text += '<b> Description</b><br>'+ data[i].Description +'<br>';
                text += '<b> Requirements</b><br>'+ data[i].Requirements +'<br>';
                text +='</td>';

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

    var CareerID=null;
    function onEdit(Data)
    {
        careerData = JSON.parse(unescape(Data));
       
        //open modal
        $("#modal-lg").modal('show');

        //load data in form
        CareerID=careerData.CareersID;
        $('#JobRole').val(careerData.Role);
        $('#RoleType').val(careerData.RoleType);
        $('#Location').val(careerData.WorkLocation);
        $('#Worktype').val(careerData.PreferredWorkType);
        $('#Duration').val(careerData.Duration);
        $('#overview').val(careerData.Overview); 
        $('#Description').val(careerData.Description);
        $('#Requirements').val(careerData.Requirements); 
    }

    function onDelete(Data)
    {
        var obj=new Object();
        obj.Module = "Careers";
        obj.Page_key = "deletePostedJob";
        var json = new Object();
        json.JobID=Data;
        obj.JSON = json;
        TransportCall(obj);
    }

</script>


