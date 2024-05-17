<?php require_once(VIEWPATH . "/basic/header.php"); ?>
<?php require_once(VIEWPATH . "/basic/sidebar.php"); ?>
<link href="assets/css/project.css" rel="stylesheet" />

<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="main-container">
                    <?php include 'projectTitle.php'; ?>
                    <?php include 'progressBars.php'; ?>
                    <?php //include 'ProjectBudget.php'; 
                    ?>
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
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

<!-- Include jQuery Knob plugin -->
<!-- <script src="https://cdn.jsdelivr.net/jquery.knob/1.2.13/jquery.knob.min.js"></script> -->