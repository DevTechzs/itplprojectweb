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
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>

                            </div>
                            <div class="modal-body">
                                <form class="addProject-form">
                                    <h6>Project Details</h6>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="project-title">Project Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="project-title" name="project-title"
                                                class="form-control" placeholder="Enter project title">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="project-description">Project
                                            Description</label>
                                        <div class="col-sm-9">
                                            <textarea id="project-description" name="project-description"
                                                class="form-control" placeholder="Enter project description"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="project-manager">Project
                                            Manager</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="project-manager" name=" project-manager"
                                                class="form-control" placeholder="Enter Manager ID">
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
                                        <label class="col-sm-3 col-form-label"
                                            for="project-department">Department</label>
                                        <div class="col-md">
                                            <select id="project-department" name="project-department"
                                                class="form-select">
                                                <option value="" disabled selected>Select department</option>
                                                <option value="department-1">Department 1</option>
                                                <option value="department-2">Department 2</option>
                                                <option value="department-3">Department 3</option>
                                                <!-- Add more departments as needed -->
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
                                            <input type="file" id="attachments" name="attachments[]"
                                                class="form-control" multiple>
                                        </div>
                                    </div>
                                    <div class="pt-4">
                                        <div class="row justify-content-end">
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary me-sm-2 me-1"
                                                    id="submitProject">Create Project</button>
                                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width:18rem;">
                        <div class="card-body">
                            <div class="about-the-projects">
                                <h5 class="card-title"><b>Project Management</b></h5>
                                <p class="card-text">Project management refers to the process of planning, organizing,
                                    and
                                    overseeing the resources needed to achieve specific goals within a defined time
                                    frame.
                                </p>
                            </div>

                            <div class="progress-container">
                                <div class="progress" onmousemove="showPercentage(event)">
                                    <div class="progress-bar bg-danger" style="width: 32%"></div>
                                    <div class="percentage-tooltip" id="percentageTooltip" style="color:black">32%</div>
                                </div>
                            </div>
                            <div id="team-icons">

                                <div title="Baby Yoda" class="rounded-circle default-avatar member-overlap-item" style="background: url(assets/img/projectImg/boy.png) 0 0 no-repeat; background-size:
                                cover;">
                                </div>
                                <div title="R2D2" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg//boy-1.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Jabba the Hut" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/girl.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Chewbacca" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="C-3PO" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/bussiness-man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                            </div>
                            <div class="know-more-link-div"><a id="know-more-btn" href="project-showProject"
                                    class="btn btn-default">know more</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="width:18rem;">
                        <div class="card-body">
                            <div class="about-the-projects">
                                <h5 class="card-title"><b>Project Management</b></h5>
                                <p class="card-text">Project management refers to the process of planning, organizing,
                                    and
                                    overseeing the resources needed to achieve specific goals within a defined time
                                    frame.
                                </p>
                            </div>

                            <div class="progress-container">
                                <div class="progress" onmousemove="showPercentage(event)">
                                    <div class="progress-bar bg-danger" style="width: 32%"></div>
                                    <div class="percentage-tooltip" id="percentageTooltip" style="color:black">32%</div>
                                </div>
                            </div>
                            <div id="team-icons">

                                <div title="Baby Yoda" class="rounded-circle default-avatar member-overlap-item" style="background: url(assets/img/projectImg/boy.png) 0 0 no-repeat; background-size:
                                cover;">
                                </div>
                                <div title="R2D2" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg//boy-1.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Jabba the Hut" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/girl.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Chewbacca" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="C-3PO" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/bussiness-man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                            </div>
                            <div class="know-more-link-div"><a id="know-more-btn" href="project-showProject"
                                    class="btn btn-default">know more</a>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="width:18rem;">
                        <div class="card-body">
                            <div class="about-the-projects">
                                <h5 class="card-title"><b>PrayagEdu</b></h5>
                                <p class="card-text">Prayagedu is a comprehensive school ERP system designed to simplify
                                    administrative tasks and enhance communication between teachers, students, and
                                    parents.

                                </p>
                            </div>

                            <div class="progress-container">
                                <div class="progress" onmousemove="showPercentage(event)">
                                    <div class="progress-bar bg-danger" style="width: 92%"></div>
                                    <div class="percentage-tooltip" id="percentageTooltip" style="color:black">92%</div>
                                </div>
                            </div>
                            <div id="team-icons">

                                <div title="Baby Yoda" class="rounded-circle default-avatar member-overlap-item" style="background: url(assets/img/projectImg/boy.png) 0 0 no-repeat; background-size:
                                cover;">
                                </div>
                                <div title="R2D2" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg//boy-1.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Jabba the Hut" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/girl.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="Chewbacca" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                                <div title="C-3PO" class="rounded-circle default-avatar member-overlap-item"
                                    style="background: url(assets/img/projectImg/bussiness-man.png) 0 0 no-repeat; background-size: cover;">
                                </div>
                            </div>
                            <div class="know-more-link-div"><a id="know-more-btn" href="project-showProject"
                                    class="btn btn-default">know more</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>

<script>
new MultiSelectTag('assigned');
</script>



<script>
$(document).ready(function() {
    $('#submitProject').click(function(event) {
        // Fetching form elements
        var titleInput = $('#project-title');
        var descriptionTextarea = $('#project-description');
        var assignedSelect = $('#assigned');
        var departmentSelect = $('#project-department');
        var dueDateInput = $('#due-date');

        // Basic validation for required fields
        if (titleInput.val().trim() === '') {
            alert('Please enter a project title.');
            return;
        }

        if (descriptionTextarea.val().trim() === '') {
            alert('Please enter a project description.');
            return;
        }

        if (assignedSelect.find(':selected').length === 0) {
            alert('Please select at least one assigned employee.');
            return;
        }

        if (departmentSelect.val() === '') {
            alert('Please select a department.');
            return;
        }

        if (dueDateInput.val() === '') {
            alert('Please select a due date.');
            return;
        }

        // Additional validation can be added based on your requirements

        // If all validations pass, you can proceed with creating the project
        // or submitting the form as needed
    });
});
</script>