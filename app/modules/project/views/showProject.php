<?php require_once(VIEWPATH . "/basic/header.php"); ?>
<?php require_once(VIEWPATH . "/basic/sidebar.php"); ?>
<link href="assets/css/project.css" rel="stylesheet" />

<!-- below is for multiple select tag -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">


<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="main-container">
                    <?php include 'projectTitle.php'; ?>
                    <?php include 'progressBars.php'; ?>
                    <?php include 'thirdChild.php'; ?>
                    <?php include 'teamMembers.php'; ?>';
                    <?php include 'taskTable.php'; ?>
                    <?php include 'meetingsTable.php'; ?>
                </div>
            </div>
        </div>
</div>
</section>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include jQuery Knob plugin -->
<script src="https://cdn.jsdelivr.net/jquery.knob/1.2.13/jquery.knob.min.js"></script>


<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>

<script>
//team member modal
function openTeamMembersModal() {
    $("#teamMembersModal").css("display", "flex");
}

function closeTeamMembersModal() {
    $("#teamMembersModal").css("display", "none");
}

// Task modal
function openAllTask() {
    $("#taskModal").css("display", "flex");
}

function closeTaskModal() {
    $("#taskModal").css("display", "none");
}



//add task modal

function openAddTask() {
    $("#addTask").css("display", "flex");
}

function closeAddTask() {
    $("#addTask").css("display", "none");
}

function openMeetingsModal() {
    $("#meetings-modal").css("display", "flex");
}

function closeMeetingsModal() {
    $("#meetings-modal").css("display", "none");
}

//submitting task jquery
</script>


<!-- multiple select tag -->
<script>
new MultiSelectTag('assigned');
</script>

<script>
function logScreenSize() {
    console.clear(); // Optional: Clear console on each resize
    console.log(`Window Width: ${window.innerWidth}`);
    console.log(`Window Height: ${window.innerHeight}`);
}

// Log initial screen size
logScreenSize();

// Attach the event listener to the window resize event
window.addEventListener('resize', logScreenSize);
</script>