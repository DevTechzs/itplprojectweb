<link href="assets/css/projectList.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">


<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="addProject-container">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#addProject">
                    Add Project
                </button>
                <!-- Modal -->
                <div class="modal fade" id="addProject" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width:75%">
                        <div class="modal-content">

                            <div class="modal-body">
                                <h6>Project Details</h6>
                                <p id="error"></p>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="row mb-3">
                                            <label for="project-title">
                                                Title <span style="color:red">*</span></label>
                                            <input type="text" id="project-title" class="form-control"
                                                placeholder="Enter project title"
                                                onchange="validateField('#project-title', 'Project Title should be at least 6 characters')">
                                        </div>
                                        <div class="row mb-3">
                                            <label for="project-description">
                                                Description <span style="color:red">*</span></label>

                                            <textarea id="project-description" class="form-control"
                                                placeholder="Enter project description"
                                                onchange="validateField('#project-description','Project Description should be atleast 6 chars')"></textarea>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="project-manager">
                                                Manager <span style="color:red">*</span></label>

                                            <select id="project-manager" class="form-control"></select>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="client-id">Client*</label>

                                            <select type="text" id="client-id" class="form-control"
                                                placeholder="Enter Client ID"></select>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="workorder-number">Workorder
                                                Number *</label>

                                            <input type="text" id="workorder-number" name="workorder-number"
                                                class="form-control" placeholder="Enter Workorder Number">

                                        </div>
                                        <div class="row mb-3">
                                            <label for="workorder-date">Workorder
                                                Date</label>

                                            <input type="date" id="workorder-date" name="workorder-date"
                                                class="form-control">

                                        </div>
                                        <div class="row mb-3">
                                            <label for="workorder-filename">Workorder
                                                File <i>(Optional)</i></label>

                                            <input type="file" id="workorder-filename" name="workorder-filename"
                                                class="form-control" placeholder="Enter Workorder Filename">

                                        </div>
                                    </div>
                                    <div class="col-sm ml-3">

                                        <div class="row mb-3">
                                            <label for="project-coordinator">Project
                                                Coordinator <span style="color:red">*</span></label>

                                            <select id="project-coordinator" name="project-coordinator"
                                                class="form-control"></select>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="client-coordinator-name">Client
                                                Coordinator<span style="color:red">*</span></label>

                                            <input type="text" id="client-coordinator-name"
                                                name="client-coordinator-name" class="form-control"
                                                placeholder="Enter Client Coordinator Name">

                                        </div>
                                        <div class="row mb-3">
                                            <label for="client-coordinator-contact-no">Client Coordinator Contact
                                            </label>

                                            <input type="tel" id="client-coordinator-contact-no" class="form-control"
                                                placeholder="Enter Contact Number">

                                        </div>
                                        <div class="row mb-3">
                                            <label for="project-budget">Project
                                                Budget(INR)</label>

                                            <input type="number" id="project-budget" name="project-budget"
                                                class="form-control" placeholder="Enter Project Budget">

                                        </div>
                                        <!-- <div class="row mb-3">
                                            <label for="start-date">Start
                                                Date</label>

                                            <input type="date" id="projectStartDate" name="project-start-date"
                                                class="form-control">

                                        </div> -->
                                        <div class="row mb-3">
                                            <label for="due-date">Due Date</label>

                                            <input type="date" id="project-due-date" name="project-due-date"
                                                class="form-control">

                                        </div>
                                        <div class="row mb-3">
                                            <label for="attachments">Project Attachments <i>(Optional)</i></label>

                                            <input type="file" id="attachments" class="form-control" multiple>

                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <div class="row justify-content-end">
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary me-sm-2 me-1"
                                                id="addBtn">Create Project</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- the below div will be used to show all the projects in the front end -->
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <div class="row" id="list-of-projects"></div>
    </section>
    <!-- /.content -->
</div>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<!-- <script src="assets/js/md5.js"></script> -->

<script>
$(function() {
    getManagers();
    getClients();
})

function getClients() {
    debugger;
    const obj = {
        Module: "Project",
        Page_key: "getClients",
    }
    const json = {};
    obj.JSON = json;
    SilentTransportCall(obj);
}

function validateField(element, errorMessage) {
    debugger;
    const value = $(element).val().trim();
    if (value === '' || value.length < 6) {
        alert(errorMessage);
        return false;
    }
    return true;
}

function validateNumberField(element, errorMessage) {
    const value = element.val().trim();
    const isValidNumber = !isNaN(value) && Number.isInteger(Number(value));

    if (!isValidNumber) {
        alert(errorMessage);
        return false;
    }
    return true;
}

function validatePhoneField(element, errorMessage) {
    const value = $(element).val().trim();
    const regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if (!regex.test(value)) {
        alert(errorMessage);
        return false;
    }
    return true;
}

$("#addBtn").click(async () => {
    debugger;
    let workOrderfiles = $("#workorder-filename")[0].files;
    let projectAttachmentFiles = $("#attachments")[0].files;
    let workOrderfileData = {};
    let projectAttachmentData = {};
    let base64;
    if (workOrderfiles.length > 0) {
        base64 = await getBase64(workOrderfiles[0]);
        workOrderfileData = {
            filedata: base64,
            filename: workOrderfiles[0].name
        }
    }
    if (projectAttachmentFiles.length > 0) {
        base64 = await getBase64(projectAttachmentFiles[0]);
        projectAttachmentData = {
            filedata: base64,
            filename: projectAttachmentFiles[0].name
        }
    }

    let isValid = true;

    // Proceed with adding the project
    let obj = {};
    obj.Module = "Project";
    obj.Page_key = "addProject";
    let json = {
        projectTitle: $("#project-title").val(),
        projectDescription: $("#project-description").val(),
        managerId: $("#project-manager").val(),
        // assignedTo: $("#assigned").val(),
        clientId: $("#client-id").val(),
        workorderNumber: $("#workorder-number").val(),
        workorderdate: $("#workorder-date").val(),
        workOrderFile: workOrderfileData,
        projectCoordinatorId: $("#project-coordinator").val(),
        clientCoordinatorName: $("#client-coordinator-name").val(),
        clientCoordinatorContactNo: $("#client-coordinator-contact-no").val(),

        projectBudget: $("#project-budget").val(),
        // projectStartDate: $("#projectStartDate").val(),
        projectDueDate: $("#project-due-date").val(),
        ProjectAttachmentsFile: projectAttachmentData
    };
    obj.JSON = json;
    isValid = validateField("#project-title", "Project Title should be filled") && isValid;
    isValid = isValid ? (validateField("#project-description", "Please fill the projectDescription") &&
        isValid) : false;
    isValid = isValid ? (validateSelects("#project-manager",
            "Please select a project manager") && isValid) :
        false;
    isValid = isValid ? (validateSelects("#client-id", "Please select a client") && isValid) :
        false;
    isValid = isValid ? (validateField("#workorder-number", "WorkOrdernumber is not filled") && isValid) :
        false;
    isValid = isValid ? (validateSelects("#project-coordinator", "Please select a project coordinator") &&
        isValid) : false;
    isValid = isValid ? (validateField("#client-coordinator-name",
            "Please fill the client coordinator name") &&
        isValid) : false;
    isValid = isValid ? (validatePhoneField("#client-coordinator-contact-no",
        "Please enter a valid phone number") && isValid) : false;
    if (isValid) TransportCall(obj, onSuccess);
});


function getBase64(file) {
    debugger
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            resolve(reader.result);
        };
        reader.onerror = function(error) {
            reject(error);
        };
    })
}

function validateSelects(element, errorMessage) {
    if ($(element).val() === '-1') {
        alert(errorMessage);
        return false;
    }
    return true;
}
</script>
<script>
$(function() {
    getProjectList();
    showStaffAllToAssignProject();
});

function getProjectList() {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "getProjectList";
    var json = new Object();
    obj.JSON = json;
    TransportCall(obj);
}
</script>


<script>
function onSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case 'addProject':
                debugger;
                notify("success", rc.return_data);
                $("#addProject").find('input', 'select').val('');
                $("#addProject").modal('hide');
                getProjectList();
                // location.reload();
                break;
            case 'getProjectList':
                loaddata(rc.return_data);
                break;
            case "showStaffAllToAssignProject":
                loadSelect("#assigned", rc.return_data);
                loadSelect("#project-coordinator", rc.return_data);
                break;
            case "getManagers":
                loadSelect("#project-manager", rc.return_data);
                break;
            case "getClients":
                loadSelect("#client-id", rc.return_data);
                break;


        }
    }
}


function loaddata(data) {
    var div_data = $("#list-of-projects");
    let content = ""
    for (let i = 0; i < data.length; i++) {
        content += `<div class='card shadow-sm rounded overflow-hidden' style='width:18rem'>
            <div class='card-body d-flex flex-column justify-content-between h-100"'>
                <div class='about-the-projects'>
                    <h5 class ='card-title text-truncate text-primary font-weight-bold mb-2'><b>${data[i].ProjectTitle.toUpperCase()}</b></h5>
                    <p class='card-text'>${data[i].ProjectDescription}</p>
                </div>
                <div class='progress-container'>
                    <div class='progress'>
                        <div class="progress-bar bg-danger" style="width: 32%"></div>
                            <div class="percentage-tooltip" id="percentageTooltip" style="color:black">32%</div>
                    </div>
                </div>
                <div id='team-icons'>
                    <div title='Baby Yoda' class='rounded-circle default-avatar member-overlap-item' style='background: url(assets/img/projectImg/boy.png) 0 0 no-repeat; background-size:cover;'>
                    </div>
                    <div title='R2D2' class='rounded-circle default-avatar member-overlap-item'style='background: url(assets/img/projectImg//boy-1.png) 0 0 no-repeat; background-size: cover;'>
                    </div>
                    <div title='Jabba the Hut' class='rounded-circle default-avatar member-overlap-item'style='background: url(assets/img/projectImg/girl.png) 0 0 no-repeat; background-size: cover;'>
                    </div>
                    <div title='Chewbacca' class='rounded-circle default-avatar member-overlap-item'style='background: url(assets/img/projectImg/man.png) 0 0 no-repeat; background-size: cover;'>
                    </div>
                    <div title='C-3PO' class='rounded-circle default-avatar member-overlap-item' style='background: url(assets/img/projectImg/bussiness-man.png) 0 0 no-repeat; background-size: cover;'>
                    </div>
                </div>
                <div class='know-more-link-div primary' type='button'>
                <div id='know-more-btn' onclick="loadproject('${data[i].ProjectID}')" class='btn btn-default'>Know More</div>

                </div>


            </div>
        </div>`
    }
    //                    <a id='know-more-btn' href='project-showProject?projectId=${data[i].ProjectID}' class='btn btn-default'>Know More</a>

    div_data.html("");
    div_data.append(content);
}

function loadproject(id) {
    localStorage.setItem("itplappprojectid", id);
    window.location = 'project-showProject';
}



function showStaffAllToAssignProject() {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "showStaffAllToAssignProject";
    var json = new Object();
    obj.JSON = json;
    TransportCall(obj);
}

// function showAllStaffsToAdd(data) {
//     let content = "";
//     data.map(item => content += `<option value = "${item.StaffID}">${item.StaffName}</option>`);
//     $("#assigned").html("");
//     $("#assigned").append(content);
// }

function getManagers() {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "getManagers";
    var json = new Object();
    obj.JSON = json;
    SilentTransportCall(obj);
}
</script>