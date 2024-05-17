<div class="first-child-1" style="min-width:300px;">
    <div id="aboutProjectContainer">
    </div>
    <div class="modal-div">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            More
        </button>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-label p-4ledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-2" style="min-width:600px; max-height:500px; overflow-y:auto;  
                            overflow-x:auto;">

                    <div class="mb-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    <div class=" modal-body" id="project-details-modal-body-data" style="min-width:100%;">

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<style>
    .modal-div {
        padding: 20px;
    }

    .project-details {
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    .project-details h2 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .project-details ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .project-details li {
        margin-bottom: 5px;
    }

    .project-details li b {
        font-weight: bold;
        margin-right: 5px;
    }
</style>



<script type="text/javascript">
    $(function() {
        getInfoOfIndividualProjects(localStorage.getItem('itplappprojectid'));

    });

    $(document).on('click', '.projectDetails-btn-edit', function() {
        const field = $(this).closest('.mb-4').find('.label').text().trim().replace(':', '').replace(/\s+/g, '');
        const currentValue = $(this).closest('.mb-4').find('.data').text().trim();
        openProjectDetailsEditModal(field, currentValue);
        if (field === "ManagerName") getManagers();
        else if (field === "ProjectCoordinatorName") showProjectCoordinatorName();
    });

    function openProjectDetailsEditModal(field, currentValue) {
        // Create a unique ID for the modal based on the field name
        var modalId = 'editModal' + field.replace(/\s+/g, '');

        // Create modal content dynamically
        var modalContent = `
        <div class="modal fade saveChangesProjectDetails" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="${modalId}Label">Edit ${field}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        ${(field === "ManagerName" || field === "ProjectCoordinatorName") ? `<label for="new${field}" class="form-label">New ${field}</label><select id="new${field
                        ==="ManagerName"?"ManagerName":"ProjectCoordinatorName"}"
    class="form-control"></select>`
: `<label for="new${field}" class="form-label">New ${field}</label><input type="text" class="form-control"
    id="new${field}" value="${currentValue}" onchange = "validateProjectDetailsData(${field})"/>`}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="(function(){updateProjectField('${field}');})()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    `;

        // Append modal to body
        $('body').append(modalContent);

        // Show modal
        $('#' + modalId).modal('show');
    }


    function updateProjectField(field) {
        const obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "updateProjectField";
        const json = new Object();
        json.ProjectID = localStorage.getItem('itplappprojectid');
        json.newValue = $("#new" + field).val();
        json.field = field;
        debugger;
        if (validateEditedProjectDetails(field, json.newValue)) {
            obj.JSON = json;
            SilentTransportCall(obj, onProjectTitleSuccess);
        } else {
            alert("Details not entered correctly");
        }

    }

    function getManagers() {
        const obj = {};
        obj.Module = "Project";
        obj.Page_key = "getManagers";
        const json = {};
        obj.JSON = json;
        SilentTransportCall(obj, onProjectTitleSuccess);
    }

    function getInfoOfIndividualProjects(projectId) {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "getInfoOfIndividualProjects";
        var json = new Object();
        json.ProjectID = projectId;
        obj.JSON = json;
        SilentTransportCall(obj, onProjectTitleSuccess);
    }

    function showProjectCoordinatorName() {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "showProjectCoordinatorName";
        var json = new Object();
        obj.JSON = json;
        SilentTransportCall(obj, onProjectTitleSuccess);
    }


    function onProjectTitleSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getInfoOfIndividualProjects":
                    loaddata(rc.return_data);
                    populateModalBody(rc.return_data);
                    break;
                case "updateProjectField":
                    getInfoOfIndividualProjects(localStorage.getItem('itplappprojectid'));
                    $("#exampleModalCenter").modal("hide");
                    $(".saveChangesProjectDetails").modal("hide");
                    break;
                case "getManagers":
                    debugger;
                    loadSelect("#newManagerName", rc.return_data);
                    break;
                case "showProjectCoordinatorName":
                    loadSelect("#newProjectCoordinatorName", rc.return_data);
                    break;
                default:
                    notify("error", rc.Page_key);
            }
        } else {
            notify("error", rc.return_data);
        }
    }


    function loaddata(data) {
        let content = "";
        let div = $("#aboutProjectContainer");
        content += `
    <div class = "border-bottom border-light mb-1" style = "display:grid; grid-template-columns:1fr 1fr; gap:10px;">
        <div class="label p-1">Manager Name:</div>
        <div class="data"><b>${data.ManagerName}</b></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Client Coordinator Name:</div>
        <div class="data"><b>${data.ClientCoordinatorName}</b></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Client Coordinator Phone:</div>
        <div class="data"><b>${data.ClientCoordinatorPhone}</b></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Project Coordinator Name:</div>
        <div class="data"><b>${data.ProjectCoordinatorName}</b></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Workorder File:</div>
        <div class="data"><a href = 'file?type=letters&name=${data.DocumentPath}'><i class="fa fa-file-pdf" style="font-size: 24px;"></i>
</a></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Workorder Number:</div>
        <div class="data"><b>${data.WorkorderNumber}</b></div>
    </div>
    <div class = "border-bottom border-light mb-1"  style = "display:grid; grid-template-columns:1fr 1fr;">
        <div class="label p-1">Workorder Date:</div>
        <div class="data"><b>${data.WorkorderDate}</b></div>
    </div>
`;

        div.html("");
        div.append(content);
    }

    function populateModalBody(data) {
        let content = "";
        content =
            `<div class="mb-4 border-bottom border-dark"  style = "display:grid; grid-template-columns: 0.5fr 2fr 0.2fr;">
        <div class="label p-2">Project Title:</div>
        <label class="data p-2">${data.ProjectTitle}</label>
        <div> <button class="btn btn-primary projectDetails-btn-edit" type ="button" 
        >edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark"  style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr; gap:10px;">
        <div class="label p-2">Project Description:</div>
        <label class="data p-2">${data.ProjectDescription}</label>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark"  style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr; gap:10px;">
        <div class="label p-2">Manager Name:</div>
        <div class="data p-2"><b>${data.ManagerName}</b></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Client Coordinator Name:</div>
        <div class="data p-2"><b>${data.ClientCoordinatorName}</b></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Client Coordinator Contact No:</div>
        <div class="data p-2"><b>${data.ClientCoordinatorPhone}</b></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Project Coordinator Name:</div>
        <div class="data p-2"><b>${data.ProjectCoordinatorName}</b></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Workorder File Name:</div>
        <div class="data p-2"><a href = 'file?type=letters&name=${data.DocumentPath}'><i class="fa fa-file-pdf" style="font-size: 24px;"></i>
</a></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Workorder Number:</div>
        <div class="data p-2"><b>${data.WorkorderNumber}</b></div>
        <div> <button class = "btn btn-primary projectDetails-btn-edit" type = "button" data-target="#editOneFieldModal">edit</button></div>
    </div>
    <div class="mb-4 border-bottom border-dark" style = "display:grid; grid-template-columns:0.5fr 2fr 0.2fr;">
        <div class="label p-2">Workorder Date:</div>
        <div class="data p-2"><b>${data.WorkorderDate}</b></div>
        <div> <button class="btn btn-primary projectDetails-btn-edit" type="button" data-target="#editOneFieldModal">edit</button></div>
    </div>
`;
        $("#project-details-modal-body-data").html(content);
    }

    // Event listener for edit buttons

    function validateEditedProjectDetails(field, value) {
        debugger;
        const temp = "validate" + field;
        switch (temp) {
            case "validateProjectTitle":
                return validateProjectTitle(value);
            case "validateProjectDescription":
                return validateProjectDescription(value);
            case "validateWorkorderNumber":
                return validateWorkorderNumber(value);
            case "validateWorkorderFileName":
                return validateWorkOrderFileName(value);
            case "validateClientCordinatorName":
                return validateClientCordinatorName(value);
            case "validateClientCoordinatorContactNo":
                return validateClientCoordinatorContactNo(value);
            default:
                return true;
        }
    }

    function validateProjectTitle(valueToValidate) {
        const value = valueToValidate.trim();
        if (value.length < 6) {
            alert("Project Title should be at least 6 characters");
            return false;
        }
        return true;
    }

    function validateProjectDescription(valueToValidate) {
        const value = valueToValidate.trim();
        if (value.length < 100) {
            alert('Project Description should be at least 100 characters');

            return false;
        }
        return true;
    }

    function validateManagerName(valueToValidate) {
        if (valueToValidate.trim() === '') {
            alert(valueToValidate, 'Manager name should not be empty');
            return false;
        }
        return true;
    }


    // function validateClientName(valueToValidate) {
    //     const value = valueToValidate.value.trim();
    //     if (value.length < 6) {
    //         alert(valueToValidate, 'Client ID should more than 6 characters');
    //         return false;
    //     }
    //     return true;
    // }

    function validateWorkorderNumber(valueToValidate) {
        const value = valueToValidate.trim();
        const isValidNumber = !isNaN(value) && Number.isInteger(Number(value));
        if (value.length < 2) {
            alert("Work order number must be more than 2 digits");
            return false;
        }
        if (!isValidNumber) {
            alert(valueToValidate, 'Workorder number must be a valid integer');
            return false;
        }
        return true;
    }

    function validateWorkOrderFileName(valueToValidate) {
        const value = valueToValidate.trim();
        if (value.length < 6) {
            alert('Workorder file name should be provided and should be more than 6 characters long');
            return false;
        }
        return true;
    }

    function validateClientCordinatorName(valueToValidate) {
        const value = valueToValidate.trim();
        if (value === '' || value.length < 6) {
            alert(valueToValidate, 'Client coordinator name should be more than 6 characters');
            return false;
        }
        return true;
    }

    function validateClientCoordinatorContactNo(valueToValidate) {
        const value = valueToValidate.trim();
        const regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        if (!regex.test(value)) {
            alert("Phone number should be 10 digits");
            return false;
        }
        return true;
    }

    function validateProjectBudget(valueToValidate) {
        const value = valueToValidate.trim();
        const isValidNumber = !isNaN(Number(value));
        if (!isValidNumber) {
            alert(valueToValidate, "please provided project budget in number");
            return false;
        }
        return true;
    }
</script>