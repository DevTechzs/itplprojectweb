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
                                Applicants List
                            </div>

                            <span class="float-right">
                                <!-- <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg"> <i class="fa fa-circle-thin"> <i class="fa fa-plus"></i> </i>Add Client(s)</button> -->
                            </span>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Job Description</th>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Contact</th>  <!-- email,contct -->
                                    <th scope="col">Address</th> <!-- Address,city,zipcode -->
                                    <!-- <th scope="col">Designation</th> -->
                                    <th scope="col">CV</th>
                                    <th scope="col">Apply on </th>
                                    <th scope="col">Apply for</th>
                                    <th>-</th>
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
        getallApplicants();
    });

    function getallApplicants()
    {

        var obj=new Object();
        obj.Module = "Careers";
        obj.Page_key = "getallApplicantsList";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }


    function onSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getallApplicantsList":
                loaddata(rc.return_data);
                break;

            default:
                notify('warning',rc.Page_key);
                
        }
    } else {
        notify('warning',rc.return_data);
        
    }
   
    }
    
    function loaddata(data) 
    {
        console.log(data)
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
                if(data[i].isActiveJob==1)
                {
                    isActive='<span class="badge badge-success">Active</span>';
                }
                else{
                    isActive='<span class="badge badge-danger">Not Active</span>';
                }
                text += '<td> ' + data[i].Role + ' - '+data[i].RoleType+'<br>';
                text +=  data[i].WorkLocation +'<br>'+ isActive +' </td>';
                text += '<td> ' + data[i].Name + '</td>';
                text += '<td> ' + data[i].Email + ' <br> '+data[i].Contact+'</td>';
                text += '<td> ' + data[i].Address + '</td>';

                // still error with viewing the file 
                // http://localhost/prayagedu-website/app/data/cv/DOC_651f8e79df6a0.pdf

                text += '<td>  <a href="localhost/prayagedu-website/app/data/cv/'+data[i].Documents+'"> <span class="badge badge-info">View </span> </a> </td>';
                text += '<td> ' + data[i].CreatedDateTime + '</td>';
                text += '<td> ' + data[i].Role + '</td>';
                text += '<td>   </td>';
                text += '</tr>';
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


