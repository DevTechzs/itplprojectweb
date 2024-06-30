<div class="content-wrapper py-10" id="maincontent">
    <section class="content p-4">
        <h1>Modules</h1>
        <div class="container-fluid flex" id="moduleList">

        </div>
    </section>
</div>

<script>
    $(function() {
        getModulesOfStaff();
    });

    function getModulesOfStaff() {
        const obj = {
            Module: "User",
            Page_key: "getModulesOfStaff"
        }
        const json = {
            StaffID: sessionStorage['StaffID'],
            ProjectID: localStorage.getItem("itplappprojectid")
        }
        obj.JSON = json;
        TransportCall(obj, onProjectDetailsSucess)
    }

    function onProjectDetailsSucess(rc) {
        debugger;
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getModulesOfStaff":
                    loadModules("#moduleList", rc.return_data);
                    break;
                default:
                    notify(rc.return_data);
            }
        }
    }

    function loadModules(id, data) {
        let content = "";
        data.map(item => {
            content += `<div class="container">
                <div class="row text-center">
                    <div class="col-xl-3 col-sm-6 mb-5 p-4 bg-white">
                        <div class="shadow-sm p-2">
                            <h5 class="mb-0">${item.ModuleName}</h5>
                        </div>
                        <button type ="button" id='know-more-btn' onclick="loadModulesTask('${item.ProjectModuleID}')" class='mt-5 btn btn-dark '>More</button>
                    </div>
                </div>
            </div>`

        })
        $(id).html(content);
    }

    function loadModulesTask(moduleID) {
        localStorage.setItem("ModuleID", moduleID);
        window.location = 'user-moduleTask';
    }
</script>