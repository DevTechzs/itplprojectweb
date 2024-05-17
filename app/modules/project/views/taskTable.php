<div class="second-child-2">
    <div class="team-member-head-div">
        <div class="team-member-text"><b>Task</b></div>
        <div class="see-all-btn-div">
            <!-- <button type="button" class="see-all-btn" onclick="openAllTask()">
                See All Task
            </button> -->
        </div>

        <!-- add task modal below -->
        <div class="see-all-btn-div">
            <button type="button" class=" btn btn-default" onclick="openAddTask()">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- Modal -->
        <div id="addTask" class="team-members-modal ">
            <div class="modals-content" id="addTaskModal" style="overflow-y:scroll;">
                <div class="card mb-4 p-2">
                    <div class="row mb-3 ">
                        <label class="required">Task
                            Title</label>
                        <input type="text" id="TaskTitle" class="form-control" placeholder="Enter task title">
                    </div>
                    <div class="row mb-3">
                        <label class="required">Task
                            Description</label>
                        <textarea id="TaskDescription" class="form-control"
                            placeholder="Enter task description"></textarea>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label required" for="slTeamMembers">Assigned
                            To</label>
                        <div class="col-sm-9">
                            <select id="slTeamMembers" class="select2" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label required">
                            Module</label>
                        <div class="col-sm-9">
                            <select id="ProjectModuleSelect" class="select2">
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label required" for="priority">Priority</label>
                        <div class="col-md">
                            <select id="priority" name="priority" class="form-select">
                                <option value="" disabled selected>Select priority</option>
                                <option value="2">High</option>
                                <option value="1">Medium</option>
                                <option value="0">Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label required" for="DueDate">Start Date</label>
                        <div class="col-sm-9">
                            <input type="date" id="StartDate" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label required">Due Date</label>
                        <div class="col-sm-9">
                            <input type="date" id="DueDate" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="attachments">Attachments <i>(Optional)</i></label>
                        <div class="col-sm-9">
                            <input type="file" id="taskAttachments" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="pt-4">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary me-sm-2 me-1" id="submitTask">Create
                                </button>
                                <button type="button" class="btn btn-default" onclick="closeAddTask()">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <div class="table-container" style="max-height:400px;overflow-y: auto; ">
        <table class="table table-bordered" id="table">
            <thead style="top:0; background-color:aliceblue; color:black;">
                <tr>
                    <th style="width: 10px;">#</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th style="width: 40px">Employees</th>
                    <th>DueDate</th>
                    <th>Docs</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:600px;">
                <div class="modal-body">
                    <input id="taskIdInputHidden" hidden>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label ">Task Title
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="newTaskTitle">
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newTaskTitle">Save</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label">Task Description
                        </label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="newTaskDescription"></textarea>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newTaskDescription">Save</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Add Staff
                        </label>
                        <div class="col-sm-6">
                            <select name="staff-select" id="newAssignedToStaffIDs" class="form-control"
                                onchange=""></select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newAssignedToStaffIDs">Save</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Update Status
                        </label>
                        <div class="col-sm-6">
                            <select class="form-control" id="newTaskStatus">
                                <option value="1">Done</option>
                                <option value="0">Not done</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newTaskStatus">Save</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Priority
                        </label>
                        <div class="col-sm-6">
                            <select id="newPriority" class="form-control">
                                <option value="2">High</option>
                                <option value="1">Medium</option>
                                <option value="0">Low</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newPriority">Save</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Due Date
                        </label>
                        <div class="col-sm-6">
                            <input type="date" class=" form-control" id="newDueDate">
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="newDueDate">Save</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="TaskDescription">Remove staff
                        </label>
                        <div class="col-sm-6">
                            <select id="staffsToRemoveFromTask" class="form-control"></select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary task-btn-save"
                                data-field="staffsToRemoveFromTask">Remove</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Upload Docs
                        </label>
                        <div class="col-sm-6">
                            <input type="file" id="newTaskDocument" class="form-control" />
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary" id=newTaskDocumentBtn
                                data-field="newTaskDocument">Upload</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
function onTaskSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getModulesByProjectID":
                loadSelect("#ProjectModuleSelect", rc.return_data);
                loadSelect("#ModulesToAdd", rc.return_data);
                loadSelect("#modulesList", rc.return_data); //this for the edit portion of teamMembers component
                break;
            case "getTeamMembers":
                loadSelect("#slTeamMembers", rc.return_data);
                loadSelect("#add-staff-to-task", rc.return_data);
                loadSelect("#meetingsAttendeeStaffIDs", rc.return_data); //for meetings adding
                break;
            case "addTask":
                notify("success", rc.return_data);
                closeAddTask();
                seeAllProjectTaskByProjectID(localStorage.getItem('itplappprojectid')); //call this func to 
                break;
            case "seeAllProjectTaskByProjectID":
                // loadTask(rc.return_data, (rc.return_data ? 4 : rc.return_data.length), "#table");
                loadTask(rc.return_data, rc.return_data.length, "#table");
                break;
            case "StaffWithoutTaskByTaskID":
                loadSelect("#newAssignedToStaffIDs", rc.return_data);
                break;
            case "UpdateTask":
                notify("success", rc.return_data);
                $("#editTaskModal").modal('hide');
                seeAllProjectTaskByProjectID(localStorage.getItem('itplappprojectid'));
                break;
            case "getStaffWithTaskID":
                loadSelect("#StaffsInTask", rc.return_data);
                loadSelect("#staffsToRemoveFromTask", rc.return_data);
                break;
            case "uploadTaskDocument":
                $("#editTaskModal").find('input,select').val('');
                $("#editTaskModal").modal('hide');
                seeAllProjectTaskByProjectID(localStorage.getItem('itplappprojectid'));
                break;
            default:
                notify("error", rc.Page_key);
        }
    } else {
        notify("error", rc.return_data);
    }
}

$("#newTaskDocumentBtn").click(async () => {
    debugger;
    taskFile = $("#newTaskDocument")[0].files;
    taskFileData = {};
    if (taskFile.length > 0) {
        base64 = await getBase64(taskFile[0]);
        taskFileData = {
            filedata: base64,
            filename: taskFile[0].name
        }
        const obj = {
            Module: "Project",
            Page_key: "uploadTaskDocument"
        }
        const json = {
            DocumentDetails: taskFileData,
            TaskID: Number($("#taskIdInputHidden").val())
        }
        obj.JSON = json;
        SilentTransportCall(obj, onTaskSuccess);
    }
})

$(function() {
    getModulesByProjectID(localStorage.getItem('itplappprojectid'));
    getProjectTeamMembers(localStorage.getItem('itplappprojectid'));
    seeAllProjectTaskByProjectID(localStorage.getItem('itplappprojectid'));
});

let isValidToSubmitTask = {
    TaskTitle: false,
    TaskDescription: false,
    slTeamMembers: false,
    ProjectModuleSelect: false,
    priority: false,
    StartDate: false,
    DueDate: false
};

let isValidToSubmitEditedTask = false;



$(document).ready(function() {

    $('#newTaskTitle').change(function() {
        var value = $(this).val();
        isValidToSubmitEditedTask = validateTaskTitle(value);

    });

    $('#newTaskDescription').change(function() {
        var value = $(this).val();
        isValidToSubmitEditedTask = validateTaskDescription(value);
    });

    $('#TaskTitle').change(function() {
        var value = $(this).val();
        isValidToSubmitTask.TaskTitle = validateTaskTitle(value);
    });

    $('#TaskDescription').change(function() {
        var value = $(this).val();
        isValidToSubmitTask.TaskDescription = validateTaskDescription(value);
    });

    $('#slTeamMembers').change(function() {
        var value = $(this).val();
        isValidToSubmitTask.slTeamMembers = validatenewAssignedToStaffIDs(value);
    });

    $('#ProjectModuleSelect').change(function() {
        var value = $(this).val();
        isValidToSubmitTask.ProjectModuleSelect = validateProjectModuleSelect(value);
    });

    $('#priority').change(function() {
        var value = $(this).val();
        isValidToSubmitTask.priority = validatepriority(value);
    });

    $('#StartDate').change(function() {
        var value = new Date($(this).val());
        isValidToSubmitTask.StartDate = validateStartDate(value);
    });

    $('#DueDate').change(function() {
        var dueDate = new Date($(this).val());
        var startDate = new Date($('#StartDate').val());
        isValidToSubmitTask.DueDate = validateDueDate(dueDate, startDate);
    });
});



function validateTaskTitle(value) {
    let val = value.trim()
    if (val.length < 5) {
        alert('Please Enter the task title and it should be at least 5 characters')
        return false;
    }
    return true;
}

function validateTaskDescription(value) {
    if (value.trim().length < 10) {
        alert('Please Enter the task description and it should be at least 10 characters');
        return false;
    }
    return true;
}

function validatenewAssignedToStaffIDs(value) {
    if (value.length < 1) {
        alert("Please select atleast one staff")
        return false;
    }
    return true;
}

function validateProjectModuleSelect(value) {
    if (value.length < 0) {
        alert('Please select one module');
        return false;
    }
    return true;
}

function validatepriority(value) {
    if (value.length < 0) {
        alert('Please select priority');
        return false;
    }
    return true;
}

function validateStartDate(value) {
    var today = new Date();
    today.setHours(0, 0, 0, 0); // Set time to 00:00:00.000

    if (isNaN(value.getTime())) {
        alert("Please select a date.");
        return false;
    } else if (value < today) {
        alert("The selected date cannot be before or on start date.");
        return false;
    }
    return true;
}

function validateDueDate(dueDate, startDate) {
    if (isNaN(dueDate.getTime())) {
        alert("Please select a due date");
        return false;
    } else if (dueDate <= startDate) {
        alert("Due date cannot be on startdate or before startdate")
    }
    return true;
}

function staffsToRemoveFromTask(TaskID) {
    const obj = {
        Module: "Project",
        Page_key: "staffsToRemoveFromTask"
    }
    const json = {
        ProjectID: localStorage.getItem('itplappprojectid'),
        TaskID: TaskID
    }
}

function getProjectTeamMembers(projectId) {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "getTeamMembers";
    var json = new Object();
    json.ProjectID = projectId;
    obj.JSON = json;
    SilentTransportCall(obj, onTaskSuccess);
}

function getModulesByProjectID(projectId) {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "getModulesByProjectID";
    var json = new Object();
    json.ProjectID = projectId;
    obj.JSON = json;
    SilentTransportCall(obj, onTaskSuccess);
}



function addTask(projectId) {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "addTask";
    var json = new Object();
    json.ProjectID = projectId;
    obj.JSON = json;
    TransportCall(obj, onTaskSuccess);
}

function seeAllProjectTaskByProjectID(projectId) {
    var obj = new Object();
    obj.Module = "Project";
    obj.Page_key = "seeAllProjectTaskByProjectID";
    var json = new Object();
    json.ProjectID = projectId;
    obj.JSON = json;
    SilentTransportCall(obj, onTaskSuccess);
}

$("#submitTask").click(async () => {
    var obj = {};
    obj.Module = "Project";
    obj.Page_key = "addTask";

    let taskFileData = {};

    const taskFile = $("#taskAttachments")[0].files;
    if (taskFile.length > 0) {
        base64 = await getBase64(taskFile[0]);
        taskFileData = {
            filedata: base64,
            filename: taskFile[0].name
        }
    }
    var json = {
        projectModuleID: $("#ProjectModuleSelect").val(),
        taskTitle: $("#TaskTitle").val(),
        taskDescription: $("#TaskDescription").val(),
        assignedToStaffIDs: $("#slTeamMembers").val(),
        startDate: $("#StartDate").val(),
        dueDate: $("#DueDate").val(),
        priority: $('#priority').val(),
        taskFile: taskFileData
    };
    obj.JSON = json;
    // console.log(JSON.stringify(obj));
    if (Object.values(isValidToSubmitTask).every(Boolean)) {
        TransportCall(obj, onTaskSuccess);
    } else {
        alert("Task fields are not properly entered");
    }
});



function loadTask(data, dataLength, tableId) {
    let content = "";
    for (let i = 0; i < dataLength; i++) {
        content += `<tr> 
                <td>${i+1}</td>
                <td>${data[i].TaskTitle}</td>
                <td>
                    
                        <div>${(data[i].TaskStatus == 1) ? '<img src="assets/img/greenTick.png"/>':'<img src="assets/img/redcross.png"/>'}</div>
                    
                </td>
                <td>${data[i].AssignedToStaffNames}</td>
                <td>${data[i].DueDate}</td>
                <td>${data[i].DocumentPath?`<a href =file?type=letters&name=${data[i].DocumentPath}><i class='fa fa-file-pdf' style='font-size: 30px;'></i></a>`:'no files' }</td>
                <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#editTaskModal"
                onclick = "openEditModal(${data[i].TaskID}, '${data[i].TaskTitle}','${data[i].TaskDescription}', '${data[i].AssignedToStaffNames}', '${data[i].DueDate}', ${data[i].ProjectModuleID},${data[i].TaskProgress})">
                <i class="fas fa-edit"></i>
</button></td>
            </tr>`;
    }
    $(`${tableId} tbody`).html("");
    $(`${tableId} tbody`).append(content);
}

function StaffWithoutTaskByTaskID(TaskID, ProjectModuleID) {
    var obj = {};
    obj.Module = "Project";
    obj.Page_key = "StaffWithoutTaskByTaskID";
    var json = {};
    json.ProjectID = localStorage.getItem('itplappprojectid');
    json.TaskID = TaskID;
    json.ProjectModuleID = ProjectModuleID;
    obj.JSON = json;
    SilentTransportCall(obj, onTaskSuccess);
}


function openEditModal(taskID, taskTitle, taskDescription, assignedToStaffNames, dueDate, projectModuleID,
    taskProgress, ) {
    StaffWithoutTaskByTaskID(taskID, projectModuleID);
    $("#newTaskTitle").val(taskTitle);
    $("#newTaskDescription").val(taskDescription)
    $("#StaffsWithTask").val(assignedToStaffNames);
    $("#newTaskStatus").val(taskProgress);
    $("#newDueDate").val(dueDate);
    $("#taskIdInputHidden").val(taskID);
    getStaffWithTaskID();
}

function validateTaskDetails(id, value) {
    switch (id) {
        case "newTaskTitle":
            return validateTaskTitle(value);
        case "newTaskDescription":
            return validateTaskDescription(value);
        case "newAssignedToStaffIDs":
            return validatenewAssignedToStaffIDs(value)
        case "newDueDate":
            if (value === "") {
                alert("Please select a due date")
                return false;
            } else return true;
        case "staffsToRemoveFromTask":
            return validatenewAssignedToStaffIDs(value);
        case "newTaskStatus":
            if (value >= 0 && value <= 100) return true;
            else return false;
        case "newPriority":
            if (value) return true;
            else return false;
    }
}
$('.task-btn-save').click(function() {
    debugger;
    var field = $(this).data('field');
    var value = $("#" + field).val();
    const proceedOrNot = validateTaskDetails(field, value);


    function inner() {
        const obj = {
            Module: "Project",
            Page_key: "UpdateTask"
        };
        const json = {};
        json.field = field;
        json.newvalue = value;
        json.taskID = $("#taskIdInputHidden").val();
        obj.JSON = json;
        // console.log(JSON.stringify(obj))
        if (proceedOrNot) {
            SilentTransportCall(obj, onTaskSuccess);
        } else {
            alert("Task fields are not properly entered");
        }
    }
    if (field === "staffsToRemoveFromTask" && proceedOrNot) {
        var result = confirm("Are you sure you want to remove the staff from the task?");
        if (result) {
            const obj = {
                Module: "Project",
                Page_key: "UpdateTask"
            };
            const json = {};
            json.field = field;
            json.newvalue = value;
            json.taskID = $("#taskIdInputHidden").val();
            obj.JSON = json;
            // console.log(JSON.stringify(obj))
            SilentTransportCall(obj, onTaskSuccess);
        } else {
            return;
        }
    } else if (field === "newAssignedToStaffIDs" && proceedOrNot) {
        const obj = {
            Module: "Project",
            Page_key: "UpdateTask"
        };
        const json = {};
        json.field = field;
        json.newvalue = value;
        json.taskID = $("#taskIdInputHidden").val();
        obj.JSON = json;
        SilentTransportCall(obj, onTaskSuccess);
        // console.log(JSON.stringify(obj))
    } else if (proceedOrNot) {
        inner();
    }


});

function getStaffWithTaskID() {
    const obj = {};
    obj.Module = "Project";
    obj.Page_key = "getStaffWithTaskID";
    const json = {};
    json.taskID = $("#taskIdInputHidden").val();
    obj.JSON = json;
    SilentTransportCall(obj, onTaskSuccess);

}

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
</script>



<script>
function openAddTask() {
    $("#addTask").css("display", "flex");
}

function closeAddTask() {
    $("#addTask").css("display", "none");
}

function openAllTask() {
    $("#exampleModalLong").css("display", "flex");
}

function closeTaskModal() {
    $("#exampleModalLong").css("display", "none");
}
</script>