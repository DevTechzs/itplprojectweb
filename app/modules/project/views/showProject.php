<?php require_once(VIEWPATH . "/basic/header.php"); ?>
<?php require_once(VIEWPATH . "/basic/sidebar.php"); ?>
<link href="assets/css/project.css" rel="stylesheet" />

<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="main-container">
                    <div class="first-child-1">
                        <div class="title-head">
                            <h1 class="project-title">Project Management</h1>
                        </div>
                        <div class="about">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum
                            rem quidem quaerat. Culpa laboriosam sequi corporis itaque
                            accusamus blanditiis sapiente repudiandae ea necessitatibus? Nemo
                            mollitia exercitationem minus accusantium ullam eligendi.
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModalLong">
                            read more
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                            Modal title
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Voluptatem laboriosam facilis quia. Labore est odit ut.
                                        Reprehenderit excepturi ullam, doloremque voluptatum soluta
                                        nihil modi eos asperiores repudiandae et illo placeat.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="first-child-2">
                        <div class="progress-bars">
                            <div class="graph">
                                <div class="outer">
                                    <div class="inner">
                                        <div id="number"></div>
                                    </div>
                                </div>
                                <svg id="overall-progress-svg" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    width="160px" height="160px">
                                    <defs>
                                        <linearGradient id="GradientColor">
                                            <stop offset="0%" stop-color="#e91e63" />
                                            <stop offset="100%" stop-color="#673ab7" />
                                        </linearGradient>
                                    </defs>
                                    <circle id="circle" cx="100" cy="100" r="90" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="sub-progress-bar">
                                <div class="planning-bar-graph">
                                    <div class="planning-bar-outer">
                                        <div class="planning-bar-inner">
                                            <div id="planning-bar-number"></div>
                                        </div>
                                    </div>
                                    <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        width="100px" height="100px">
                                        <defs>
                                            <linearGradient id="planning-bar-gradient">
                                                <stop offset="0%" stop-color="#e91e63" />
                                                <stop offset="100%" stop-color="#673ab7" />
                                            </linearGradient>
                                        </defs>
                                        <circle class="planning-circle" id="sub-bar-circle" cx="50" cy="50" r="40"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="planning-bar-graph">
                                    <div class="planning-bar-outer">
                                        <div class="planning-bar-inner">
                                            <div id="design-bar-number"></div>
                                        </div>
                                    </div>
                                    <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        width="100px" height="100px">
                                        <defs>
                                            <linearGradient id="planning-bar-gradient">
                                                <stop offset="0%" stop-color="#e91e63" />
                                                <stop offset="100%" stop-color="#673ab7" />
                                            </linearGradient>
                                        </defs>
                                        <circle class="design-circle" id="sub-bar-circle" cx="50" cy="50" r="40"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="planning-bar-graph">
                                    <div class="planning-bar-outer">
                                        <div class="planning-bar-inner">
                                            <div id="development-bar-number"></div>
                                        </div>
                                    </div>
                                    <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        width="100px" height="100px">
                                        <defs>
                                            <linearGradient id="planning-bar-gradient">
                                                <stop offset="0%" stop-color="#e91e63" />
                                                <stop offset="100%" stop-color="#673ab7" />
                                            </linearGradient>
                                        </defs>
                                        <circle class="development-circle" id="sub-bar-circle" cx="50" cy="50" r="40"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="planning-bar-graph">
                                    <div class="planning-bar-outer">
                                        <div class="planning-bar-inner">
                                            <div id="testing-bar-number"></div>
                                        </div>
                                    </div>
                                    <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        width="100px" height="100px">
                                        <defs>
                                            <linearGradient id="planning-bar-gradient">
                                                <stop offset="0%" stop-color="#e91e63" />
                                                <stop offset="100%" stop-color="#673ab7" />
                                            </linearGradient>
                                        </defs>
                                        <circle class="testing-circle" id="sub-bar-circle" cx="50" cy="50" r="40"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="list-of-progress-name">
                                <ul class="dot-list">
                                    <li class="dot-list-item"><span class="dot red"></span>Planning</li>
                                    <li class="dot-list-item"><span class="dot light-blue"></span>Design</li>
                                    <li class="dot-list-item"><span class="dot blue"></span>Development</li>
                                    <li class="dot-list-item"><span class="dot purple"></span>Testing</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="first-child-3">
                        <div class="flag-data">
                            <img src="assets/img/projectImg/chequered-flag.png" alt="" width="100" />
                        </div>
                    </div>
                    <div class="second-child-1">
                        <div class="team-members-div">
                            <div class="team-member-head-div">
                                <div class="team-member-text">Team members</div>
                                <div class="see-all-btn-div">
                                    <button type="button" class="see-all-btn" onclick="openTeamMembersModal()">
                                        See All
                                    </button>
                                </div>
                            </div>
                            <ul class="team-list">
                                <li class="list-item">
                                    <div class="member-img-div">
                                        <img src="assets/img/projectImg//boy (1).png" alt="" />
                                        <div class="member-name-role">
                                            <p class="member-name">Sahil Subba</p>
                                            <p class="member-role">Junior developer</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="member-img-div">
                                        <img src="assets/img/projectImg/boy.png" alt="" />
                                        <div class="member-name-role">
                                            <p class="member-name">Dev Singh</p>
                                            <p class="member-role">Lead Developer</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="member-img-div">
                                        <img src="assets/img/projectImg/girl.png" alt="" />
                                        <div class="member-name-role">
                                            <p class="member-name">Nahat</p>
                                            <p class="member-role">flutter developer</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="member-img-div">
                                        <img src="assets/img/projectImg/man.png" alt="" />
                                        <div class="member-name-role">
                                            <p class="member-name">Om Prakash</p>
                                            <p class="member-role">Manager</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="teamMembersModal" class="team-members-modal">
                            <div class="team-members-modal-content">
                                <div class="team-member-head-div">
                                    <div class="team-member-text">All Team members</div>
                                    <button type="button" class="see-all-btn" onclick="closeTeamMembersModal()">
                                        Close
                                    </button>
                                </div>
                                <ul class="team-list">
                                    <li class="list-item">
                                        <div class="member-img-div">
                                            <img src="assets/img/projectImg/boy (1).png" alt="" />
                                            <div class="member-name-role">
                                                <p class="member-name">Sahil Subba</p>
                                                <p class="member-role">Junior Developer</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-item">
                                        <div class="member-img-div">
                                            <img src="assets/img/projectImg/boy.png" alt="" />
                                            <div class="member-name-role">
                                                <p class="member-name">Dev Singh</p>
                                                <p class="member-role">Lead Developer</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-item">
                                        <div class="member-img-div">
                                            <img src="assets/img/projectImg/girl.png" alt="" />
                                            <div class="member-name-role">
                                                <p class="member-name">Nahat</p>
                                                <p class="member-role">flutter developer</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-item">
                                        <div class="member-img-div">
                                            <img src="assets/img/projectImg/man.png" alt="" />
                                            <div class="member-name-role">
                                                <p class="member-name">Om Prakash</p>
                                                <p class="member-role">Manager</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-item">
                                        <div class="member-img-div">
                                            <img src="assets/img/projectImg/bussiness-man.png" alt="" />
                                            <div class="member-name-role">
                                                <p class="member-name">Gavel</p>
                                                <p class="member-role">flutter developer</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="second-child-2">
                        <div class="team-member-head-div">
                            <div class="team-member-text">Task</div>
                            <div class="see-all-btn-div">
                                <button type="button" class="see-all-btn" onclick="openAllTask()">
                                    See All Task
                                </button>
                            </div>
                            <div class="see-all-btn-div">
                                <button type="button" class="see-all-btn" onclick="">
                                    Add Task
                                </button>
                            </div>
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
                        <div id="taskModal" class="team-members-modal">
                            <div class="team-members-modal-content">
                                <div class="team-member-head-div">
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
                    <div class="second-child-3">
                        <div class="meeting-div">
                            <div class="team-member-head-div">
                                <h3 class="card-title">Project Meetings</h3>
                                <div class="see-all-btn-div">
                                    <button type="button" class="see-all-btn" onclick="openAllMeetings()">
                                        See All Meetings
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Meeting ID</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Report</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>001</td>
                                            <td>Project Kickoff</td>
                                            <td>2024-02-01</td>
                                            <td>
                                                <a href="path/to/meeting_report_001.pdf" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>002</td>
                                            <td>Weekly Status</td>
                                            <td>2024-02-08</td>
                                            <td>
                                                <a href="path/to/meeting_report_002.docx" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>003</td>
                                            <td>Project Planning</td>
                                            <td>2024-02-15</td>
                                            <td>
                                                <a href="path/to/meeting_report_003.pdf" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>004</td>
                                            <td>Design Review</td>
                                            <td>2024-02-22</td>
                                            <td>
                                                <a href="path/to/meeting_report_004.docx" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5.</td>
                                            <td>005</td>
                                            <td>Development Progress</td>
                                            <td>2024-03-01</td>
                                            <td>
                                                <a href="path/to/meeting_report_005.pdf" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6.</td>
                                            <td>006</td>
                                            <td>Testing Phase Kickoff</td>
                                            <td>2024-03-08</td>
                                            <td>
                                                <a href="path/to/meeting_report_006.docx" download>
                                                    <span class="badge bg-success">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7.</td>
                                            <td>007</td>
                                            <td>Final Review and Closure</td>
                                            <td>2024-03-15</td>
                                            <td>
                                                <a href="path/to/meeting_report_007.pdf" download>
                                                    <span class="badge bg-info">Download Report</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
</section>
</div>

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

//get the number inside the overall progress bar
const progressBars = [{
        element: $("#number"),
        maxPercentage: 30,
        interval: 60
    },
    {
        element: $("#planning-bar-number"),
        maxPercentage: 87,
        interval: 20
    },
    {
        element: $("#design-bar-number"),
        maxPercentage: 70,
        interval: 25
    },
    {
        element: $("#development-bar-number"),
        maxPercentage: 40,
        interval: 40
    },
    {
        element: $("#testing-bar-number"),
        maxPercentage: 10,
        interval: 80
    }
];

const updateProgress = (bar) => {
    let counter = 0;
    let time_interval;
    const intervalId = setInterval(() => {
        if (counter >= bar.maxPercentage) {
            clearInterval(intervalId);
        } else {
            counter++;
            bar.element.html(counter + "%");
        }
    }, bar.interval);
    bar.intervalId = intervalId;
};

progressBars.forEach(updateProgress);

//first-child-2 bars
$(document).ready(() => {
    $(".knob").knob();
});
</script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include jQuery Knob plugin -->
<script src="https://cdn.jsdelivr.net/jquery.knob/1.2.13/jquery.knob.min.js"></script>