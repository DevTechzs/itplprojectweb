<div class="content-wrapper py-10" id="maincontent">
    <section class="content p-4">
        <h1>Task</h1>
        <div class="container-fluid">
            <table class="table table-dark">
                <thead>
                    <th scope="col">Title</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Status</th>
                    <th scope="col">Due Date</th>
                </thead>
                <tbody id="moduleTask">
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="taskStatusModal" tabindex="-1" aria-labelledby="taskStatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskStatusModalLabel">Update Task Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden id="taskID" />
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="taskStatusSwitch">
                                <label class="custom-control-label" for="taskStatusSwitch">Mark as Completed</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateTaskStatus()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(function() {
    getModuleTask();
})

function onModuleTaskSuccess(rc) {
    debugger;
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getModuleTask":
                loadModuleTask("#moduleTask", rc.return_data);
                break;
            case "updateTaskStatus":
                getModuleTask();
                $('#taskStatusModal').modal('hide');
                break;
            default:
                notify(rc.return_data);
        }
    }
}

function getModuleTask() {
    const obj = {
        Module: "User",
        Page_key: "getModuleTask"
    }
    const json = {
        StaffID: sessionStorage['StaffID'],
        ModuleID: localStorage.getItem('ModuleID'),
    }
    obj.JSON = json;
    TransportCall(obj, onModuleTaskSuccess);
}

function loadModuleTask(id, data) {
    let content = "";
    data.map(item => content += `
    <tr>
            <td class="p-4">${item.TaskTitle}</td>
            <td class="p-4">${item.Priority == 0 ? "Low" : (item.Priority == 1 ? "Medium" : "High")}</td>
            <td class="p-4">${item.TaskStatus == 0 ?`
                <a href="javascript:void(0);" onclick="openTaskStatusModal('${item.TaskStatus}',${item.TaskID})" 
            data-target ="#modalTaskUpdate">Pending</a>`:'Completed'}</td>
            <td class="p-4">${item.DueDate}</td>
        </tr>`)
    $(id).html(content);
}

function openTaskStatusModal(currentStatus, taskid) {
    $("#taskID").val(taskid)
    $('#taskStatusModal').modal('show');
}

// Function to handle the save changes button in the modal
function updateTaskStatus() {
    debugger;
    const isCompleted = $('#taskStatusSwitch').prop('checked') == true ? 1 : 0;
    const obj = {
        Module: "User",
        Page_key: "updateTaskStatus",
    }
    const json = {
        TaskID: $("#taskID").val(),
        TaskStatus: isCompleted
    }
    obj.JSON = json;
    SilentTransportCall(obj, onModuleTaskSuccess);
}


function confirmTaskCompletion(checkbox) {
    if (checkbox.checked) {
        const confirmed = confirm('Are you sure you want to mark this task as completed?');
        if (!confirmed) {
            checkbox.checked = false;
        }
    }
}
</script>