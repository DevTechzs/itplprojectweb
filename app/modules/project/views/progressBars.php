<div class="first-child-2">
    <div class="progress-bars">
        <div class="graph">
            <div class="outer">
                <div class="inner">
                    <div id="number"></div>
                </div>
            </div>
            <svg id="overall-progress-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px" height="160px">
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
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px" height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="planning-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="design-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px" height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="design-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="development-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px" height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="development-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="testing-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px" height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="testing-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
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
    <div>
        <table>
            <thead>
                <tr>
                    <td class='p-2'>Module</td>
                    <td class='p-2'>Status</td>
                    <td class='p-2'>Planing</td>
                    <td class='p-2'>Design</td>
                    <td class='p-2'>Development</td>
                    <td class='p-2'>Testing</td>
                </tr>
            </thead>
            <tbody id="projectModules"></tbody>
        </table>
    </div>
    <div>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModuleModal">
            Add Module
        </button>

        <button id="getModulesBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#showProjectModules">
            Modules
        </button>


        <!-- Modal -->
        <div class="modal fade" id="addModuleModal" tabindex="-1" role="dialog" aria-labelledby="addModuleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="row-sm"><label class="required">
                                        Module name</label>
                                    <input type="text" id="ModuleName" class="form-control">
                                </div>

                                <div class="row-sm"><label class="required">
                                        Module Description</label>
                                    <textarea type="text" id="ModuleDescription" class="form-control"></textarea>
                                </div>
                                <div class="row-sm">
                                    <label class="required">Module Priority</label>
                                    <select id="ModulePriority" class="form-control">
                                        <option value="" disabled selected>Select priority</option>
                                        <option value="2">High</option>
                                        <option value="1">Medium</option>
                                        <option value="0">Low</option>
                                    </select>
                                </div>
                                <div class="row-sm"><label class="required">
                                        Reporting Manager</label>
                                    <select id="ReportManagerName" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addModuleBtn">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg " id="showProjectModules" tabindex="-1" role="dialog" aria-labelledby="showProjectModulesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class='w-75'>
                        <thead>
                            <tr>
                                <td class='p-2'>Module</td>
                                <td class='p-2'>Status</td>
                                <td class='p-2'>Planing</td>
                                <td class='p-2'>Design</td>
                                <td class='p-2'>Development</td>
                                <td class='p-2'>Testing</td>
                            </tr>
                        </thead>
                        <tbody id="projectModulesList"></tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="openModalToEditModule" tabindex="-1" role="dialog" aria-labelledby="openModalToEditModule" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <input hidden id="ProjectModuleIdHidden" />
                            <div class="row">
                                <div class="col-10">
                                    <label>Module Name</label>
                                    <input class="form-control " id="newModuleName" />
                                </div>
                                <div class="col-2 text-right">
                                    <button class="btn btn-primary mt-4  module-save-btn" data-field="ModuleName">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <label>Module Description</label>
                                    <textarea class="form-control" id="newModuleDescription"></textarea>
                                </div>
                                <div class="col-2 text-right">
                                    <button class="btn btn-primary mt-4  module-save-btn" data-field="ModuleDescription">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <label>Module Priority</label>
                                    <select class="form-control" id="newModulePriority">
                                        <option selected id="previousModulePriority"></option>
                                        <option value="2">High</option>
                                        <option value="1">Medium</option>
                                        <option value="0">Low</option>
                                    </select>
                                </div>
                                <div class="col-2 text-right">
                                    <button class="btn btn-primary mt-4  module-save-btn" data-field="ModulePriority">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <label>Report Manager</label>
                                    <select class="form-control" id="newReportManagerStaffID">
                                    </select>
                                </div>
                                <div class="col-2 text-right">
                                    <button class="btn btn-primary mt-4  module-save-btn" data-field="ReportManagerStaffID">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5"><label>Completed</label>
                                    <select id="newisCompleted" class="form-control">
                                        <option value=0>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>

                                <div class="col-3 text-right">
                                    <button class="btn btn-primary mt-4 module-save-btn" data-field="isCompleted">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <label>Design</label>
                                    <select id="newDesigning" class="form-control">
                                        <option value=0>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                                <div class="col-3 text-right">
                                    <button class="btn btn-primary mt-4 module-save-btn" data-field="Designing">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <label>Planing</label>
                                    <select id="newPlanning" class="form-control">
                                        <option value=0>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                                <div class="col-3 text-right">
                                    <button class="btn btn-primary mt-4 module-save-btn" data-field="Planning">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <label>Development</label>
                                    <select id="newDevelopment" class="form-control">
                                        <option value=0>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                                <div class="col-3 text-right">
                                    <button class="btn btn-primary mt-4 module-save-btn" data-field="Development">Save</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <label>Testing</label>
                                    <select id="newTesting" class="form-control">
                                        <option value=0>No</option>
                                        <option value=1>Yes</option>
                                    </select>
                                </div>
                                <div class="col-3 text-right">
                                    <button class="btn btn-primary mt-4 module-save-btn" data-field="Testing">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // localStorage.getItem('itplappprojectid')
    $(function() {
        getManagers();
        getTaskForModule();
        getProjectModules();
        calculateProjectProgress();

    })

    function getTaskForModule() {
        const obj = {
            Module: "Project",
            Page_key: "getTaskForModule"
        }
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid'),
        }
        obj.JSON = json;
        SilentTransportCall(obj, onModuleSuccess);
    }

    $(".module-save-btn").click(function() {
        var field = $(this).data('field');
        var value = $("#new" + field).val();

        const obj = {
            Module: "Project",
            Page_key: "editProjectModuleDetails"
        }
        const json = {
            ModuleID: $("#ProjectModuleIdHidden").val(),
            field: field,
            newValue: value,
        }
        obj.JSON = json;
        // console.log(JSON.stringify(obj));
        SilentTransportCall(obj, onModuleSuccess);
    })
    $(document).ready(() => {
        $("#addModuleBtn").click(() => {
            const moduleName = $('#ModuleName').val();
            const moduleDescription = $('#ModuleDescription').val();
            const modulePriority = $('#ModulePriority').val();
            const reportManagerName = $('#ReportManagerName').val();

            if (moduleName.length < 6) {
                alert('Module name should be at least 6 characters');
                return false;
            }

            if (moduleDescription.length < 10) {
                alert('Module description should be at least 10 characters');
                return false;
            }

            if (!modulePriority) {
                alert('Please select a module priority');
                return false;
            }

            if (!reportManagerName) {
                alert('Please select a report manager');
                return false;
            }

            const obj = {
                Module: "Project",
                Page_key: "addModule"
            }
            const json = {
                ProjectID: localStorage.getItem('itplappprojectid'),
                ModuleName: moduleName,
                ModuleDescription: moduleDescription,
                ModulePriority: modulePriority,
                ReportManager: reportManagerName,
            };
            obj.JSON = json;
            SilentTransportCall(obj, onModuleSuccess);
        });
    });


    function getManagers() {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "getManagers";
        var json = new Object();
        obj.JSON = json;
        SilentTransportCall(obj, onModuleSuccess);
    }

    function getProjectModules() {
        const obj = {
            Module: "Project",
            Page_key: "getProjectModules",
        }
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid'),
        }
        obj.JSON = json;
        SilentTransportCall(obj, onModuleSuccess);
    }

    function loadModules(id, data, moduleIds) {
        let content = "";
        debugger;
        data.map(item => {
            const moduleExists = moduleIds.includes(item.ProjectModuleID);
            console.log(moduleExists);
            content +=
                `<tr class="border-bottom">
        <td class="p-2 border-right">${item.ModuleName}</td> 
        <td  class="p-2 border-right">${(moduleExists) ? `<img src="assets/img/greenTick.png"/>` : ''}</td>
        <td class="p-2 border-right">${(item.Planning ===1) ? `<img src="assets/img/greenTick.png"/>`:''}</td>
         <td class="p-2 border-right">${(item.Designing ===1) ? `<img src="assets/img/greenTick.png"/>`:''}</td>
          <td class="p-2 border-right">${(item.Development ===1) ? `<img src="assets/img/greenTick.png"/>`:''}</td>
           <td class="p-2 border-right">${(item.Testing ===1) ? `<img src="assets/img/greenTick.png"/>`:''}</td>
        <td class ="p-2"><button onclick="modalToEditModule(${item.ProjectModuleID},'${item.ModuleName}','${item.ModuleDescription}',${item.ModulePriority})"
         data-toggle='modal' data-target='#openModalToEditModule' class = 'btn btn-success'><i class="fas fa-edit"></i></button></td>
         <td class ="p-2"><button class = "btn btn-danger" onclick ="removeModuleByModuleID(${item.ProjectModuleID},'${item.ModuleName}')"><i class="fas fa-trash"></i></button></td>
    </tr>`
        });


        $(`${id}`).html("");
        $(`${id}`).append(content);
    }
    $("#getModulesBtn").click(() => {
        getProjectModules();
    })

    function removeModuleByModuleID(moduleID, moduleName) {
        let response = confirm("Are you sure you want to remove " + moduleName + " module?");
        if (!response) {
            return;
        } else {
            const obj = {
                Module: "Project",
                Page_key: "removeModuleByModuleID"
            }
            const json = {
                ProjectModuleID: moduleID
            }
            obj.JSON = json;
            SilentTransportCall(obj, onModuleSuccess);
        }
    }


    function modalToEditModule(moduleID, moduleName, moduleDescription, modulePriority) {
        let priorityVal = (modulePriority === 0) ? "Low" : ((modulePriority === 1) ? "Medium" : "High");
        $("#newModuleName").val(moduleName);
        $("#newModuleDescription").val(moduleDescription);
        $("#previousModulePriority").html("Current priority " + priorityVal);
        $("#ProjectModuleIdHidden").val(moduleID);
        getManagers();

    }
    let modulesCompleted;

    function filterProjectModules(modules, moduleIds) {
        // Use the filter method to filter modules whose ProjectModuleID exists in moduleIds
        return modules.filter(module => moduleIds.includes(module.ProjectModuleID));
    }

    function onModuleSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "addModule":
                    notify("success", rc.return_data)
                    $("#addModuleModal").find("input,select,textarea").val('');
                    $("#addModuleModal").modal('hide');
                    getModulesByProjectID(localStorage.getItem('itplappprojectid'));
                    break;
                case "getManagers":
                    loadSelect("#ReportManagerName", rc.return_data);
                    loadSelect("#newReportManagerStaffID", rc.return_data);
                    break;
                case "getProjectModules":
                    loadModules("#projectModulesList", rc.return_data, modulesCompleted);
                    // loadModules("#projectModules", rc.return_data);
                    break;
                case "removeModuleByModuleID":
                    notify("success", rc.return_data);
                    loadModules("#projectModulesList", rc.return_data);
                    break;
                    debugger;
                case "editProjectModuleDetails":
                    notify("success", rc.return_data);
                    $("#openModalToEditModule").modal('hide');
                    getProjectModules();
                    calculateProjectProgress();
                    break;
                case "calculateProjectProgress":
                    progressData(rc.return_data);
                    break;
                case "getTaskForModule":
                    modulesCompleted = rc.return_data;
                    break;
                default:
                    notify("error", rc.Page_key);
            }
        } else {
            notify("error", rc.return_data);
        }
    }
    //get the number inside the overall progress bar
    // const progressBars = [{
    //         element: $("#number"),
    //         maxPercentage: 30,
    //         interval: 60
    //     },
    //     {
    //         element: $("#planning-bar-number"),
    //         maxPercentage: 87,
    //         interval: 20
    //     },
    //     {
    //         element: $("#design-bar-number"),
    //         maxPercentage: 70,
    //         interval: 25
    //     },
    //     {
    //         element: $("#development-bar-number"),
    //         maxPercentage: 40,
    //         interval: 40
    //     },
    //     {
    //         element: $("#testing-bar-number"),
    //         maxPercentage: 10,
    //         interval: 80
    //     }
    // ];

    // const updateProgress = (bar) => {
    //     let counter = 0;
    //     let time_interval;
    //     const intervalId = setInterval(() => {
    //         if (counter >= bar.maxPercentage) {
    //             clearInterval(intervalId);
    //         } else {
    //             counter++;
    //             bar.element.html(counter + "%");
    //         }
    //     }, bar.interval);
    //     bar.intervalId = intervalId;
    // };

    // progressBars.forEach(updateProgress);

    function calculateProjectProgress() {
        const obj = {
            Module: "Project",
            Page_key: "calculateProjectProgress"
        }
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid')
        }
        obj.JSON = json;
        TransportCall(obj, onModuleSuccess);
    }

    function progressData(data) {
        const total_modules = data.length;
        const totalProgress = data.reduce((acc, module) => {
            acc.Planning += module.Planning;
            acc.Designing += module.Designing;
            acc.Development += module.Development;
            acc.Testing += module.Testing;
            return acc;
        }, {
            Planning: 0,
            Designing: 0,
            Development: 0,
            Testing: 0
        });
        debugger;
        const progressBars = [{
            element: $("#number"),
            maxPercentage: ((totalProgress.Planning + totalProgress.Designing + totalProgress.Development +
                totalProgress.Testing) / (total_modules * 4)) * 100,
            interval: 40
        }, {
            element: $("#planning-bar-number"),
            maxPercentage: totalProgress.Planning / total_modules * 100,
            interval: 10
        }, {
            element: $("#design-bar-number"),
            maxPercentage: totalProgress.Designing / total_modules * 100,
            interval: 10
        }, {
            element: $("#development-bar-number"),
            maxPercentage: totalProgress.Development / total_modules * 100,
            interval: 10
        }, {
            element: $("#testing-bar-number"),
            maxPercentage: totalProgress.Testing / total_modules * 100,
            interval: 10
        }];

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
        const overallProgress = (560 - progressBars[0].maxPercentage / 100 * 560);

        $(":root").css("--max-planning", progressBars[1].maxPercentage);
        $(":root").css("--max-design",
            progressBars[2].maxPercentage);
        $(":root").css("--max-development", progressBars[3].maxPercentage);
        $(":root").css("--max-testing", progressBars[4].maxPercentage);
        $(':root').css('--overall-progress', overallProgress);

    }
</script>