<div class="second-child-2">
    <div class="team-member-head-div">
        <div class="team-member-text"><b>Task</b></div>
        <div class="see-all-btn-div">
            <button type="button" class="see-all-btn" onclick="openAllTask()">
                See All Task
            </button>
        </div>

        <!-- add task modal below -->
        <div class="see-all-btn-div">
            <button type="button" class="see-all-btn" onclick="openAddTask()">
                Add Task
            </button>
        </div>
        <!-- Modal -->
        <div id="addTask" class="team-members-modal">
            <div class="modals-content" id="addTaskModal">
                <div class=" team-member-head-div modals-head">
                    <div class="team-member-text">Add New Task</div>
                    <button type="button" class="see-all-btn" onclick="closeAddTask()">
                        Close
                    </button>
                </div>
                <div class="card mb-4">
                    <h5 class="card-header">Task Form</h5>
                    <form class="card-body">
                        <h6>Task Details</h6>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="task-title">Task
                                Title</label>
                            <div class="col-sm-9">
                                <input type="text" id="task-title" name="task-title" class="form-control"
                                    placeholder="Enter task title">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="task-description">Task
                                Description</label>
                            <div class="col-sm-9">
                                <textarea id="task-description" name="task-description" class="form-control"
                                    placeholder="Enter task description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="assigned-to">Assigned
                                To</label>
                            <div class="col-sm-9">
                                <select name="assigned-to[]" id="assigned" multiple>
                                    <option value="emp-1">emp-1</option>
                                    <option value="emp-2">emp-2</option>
                                    <option value="emp-3">emp-3</option>
                                    <option value="emp-4">emp-4</option>
                                    <option value="emp-5">emp-5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="priority">Priority</label>
                            <div class="col-md">
                                <select id="priority" name="priority" class="form-select">
                                    <option value="" disabled selected>Select priority</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="due-date">Due Date</label>
                            <div class="col-sm-9">
                                <input type="date" id="due-date" name="due-date" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="attachments">Attachments</label>
                            <div class="col-sm-9">
                                <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
                            </div>
                        </div>
                        <div class="pt-4">
                            <div class="row justify-content-end">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary me-sm-2 me-1" id="submitTask">Create
                                        Task</button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- end of modal -->

    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th>Progress</th>
                <th style="width: 40px">employee</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>Update software</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                </td>
                <td>Sahil</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Clean database</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar bg-warning" style="width: 70%"></div>
                    </div>
                </td>
                <td>Dev</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Fix the nav bar</td>
                <td>
                    <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar bg-primary" style="width: 30%"></div>
                    </div>
                </td>
                <td>Nahat</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Test the form</td>
                <td>
                    <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar bg-success" style="width: 90%"></div>
                    </div>
                </td>
                <td>Bert</td>
            </tr>
        </tbody>
    </table>

    <!-- task modal -->
    <div id="taskModal" class="team-members-modal">
        <div class="team-members-modal-content modals-content">
            <div class="team-member-head-div modals-head-div">
                <div class="team-member-text">All Tasks</div>
                <button type="button" class="see-all-btn" onclick="closeTaskModal()">
                    Close
                </button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Task</th>
                        <th>Progress</th>
                        <th style="width: 40px">Label</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Update software</td>
                        <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%">
                                </div>
                            </div>
                        </td>
                        <td>Sahil</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Clean database</td>
                        <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                            </div>
                        </td>
                        <td>Dev</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Fix the nav bar</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar bg-primary" style="width: 30%"></div>
                            </div>
                        </td>
                        <td>Nahat</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Test the form</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar bg-success" style="width: 90%"></div>
                            </div>
                        </td>
                        <td>Bert</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#submitTask').click(function(event) {
        // Fetching form elements
        var titleInput = $('#task-title');
        var descriptionTextarea = $('#task-description');
        var assignedSelect = $('#assigned');
        var prioritySelect = $('#priority');
        var dueDateInput = $('#due-date');

        // Basic validation for required fields
        if (titleInput.val().trim() === '') {
            alert('Please enter a task title.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (descriptionTextarea.val().trim() === '') {
            alert('Please enter a task description.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (assignedSelect.find(':selected').length === 0) {
            alert('Please select at least one assigned employee.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (prioritySelect.val() === '') {
            alert('Please select a priority.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (dueDateInput.val() === '') {
            alert('Please select a due date.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        let obj = {};
        obj.Module = "Project";
        obj.Page_key = "addTask";
        let json = {};
        json.taskTitle = titleInput.val();
        json.taskDescription = descriptionTextarea.val();
        json.assigned = assignedSelect.val();

        json.priority = prioritySelect.val();
        json.dueDate = dueDateInput.val();
        json.file = $("#attachments").val();

        obj.JSON = json;

        console.log(JSON.stringify(obj));


    });
});
</script>


<!-- <script>
$("#submitTask").click(() => {
    debugger
    // const taskTitle = $("#task-title").val();
    // const taskDescription = $("#task-description").val();
    // const assigned = $("#assigned").val();
    // const priority = $("#priority").val();
    // const dueDate = $("#due-date").val();
    // const file = $("#attachments").val();
    // console.log(taskTitle);

    let obj = {};
    obj.Module = "Project";
    obj.Page_key = "addTask";
    let json = {};
    json.taskTile = $("#task-title").val();
    json.taskDescription = $("#task-description").val()
    json.assigned = $("#assigned").val();
    json.priority = $("#priority").val();
    json.dueDate = $("#due-date").val();
    json.file = $("#attachments").val();

    // if(code !=null){
    //     json.ProductID = code;
    // }

    obj.JSON = json;
    console.log(JSON.stringify(obj));
    // TransportCall(obj);
});
</script> -->