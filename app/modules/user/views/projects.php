<style>
#maincontent {
    background: #e8cbc0;
    background: -webkit-linear-gradient(to right, #e8cbc0, #636fa4);
    background: linear-gradient(to right, #e8cbc0, #636fa4);
}

#know-more-btn {
    cursor: pointer;
}
</style>


<div class="content-wrapper py-10" id="maincontent">
    <section class="content p-4">
        <div class="container-fluid" id="ProjectList">

        </div>
    </section>
</div>

<script>
$(function() {
    getProjectListOfStaff();
});

function getProjectListOfStaff() {
    const obj = {
        Module: "User",
        Page_key: "getProjectListOfStaff"
    }
    const json = {
        StaffID: sessionStorage['StaffID']
    }
    obj.JSON = json;
    SilentTransportCall(obj, onUserSuccess)
}

function onUserSuccess(rc) {
    if (rc.return_code) {
        switch (rc.Page_key) {
            case "getProjectListOfStaff":
                loadProjects("#ProjectList", rc.return_data);
                break;

            default:
                notify(rc.return_data);
        }
    }
}

function loadProjects(id, data) {
    let content = '';
    data.map(item => {
        content += `<div class="container">
                <div class="row text-center">
                    <div class="col-xl-3 col-sm-6 mb-5 p-4 bg-white">
                        <div class="shadow-sm p-2">
                            <h5 class="mb-0">${item.ProjectTitle}</h5>
                        </div>
                        <div class="shadow-sm  p-2">
                            <h5 class="mb-0">Client: ${item.ClientName}</h5>
                        </div>
                        <button type ="button" id='know-more-btn' onclick="loadProjectDetails('${item.ProjectID}')" class='mt-5 btn btn-dark '>More</button>
                    </div>
                </div>
            </div>`
    })
    $(id).html(content);
}


function loadProjectDetails(ProjectID) {
    localStorage.setItem("itplappprojectid", ProjectID);
    window.location = 'user-projectDetails';
}
</script>