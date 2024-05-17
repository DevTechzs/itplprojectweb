<div class="second-child-1 p-2">
    <div class="team-members-div">
        <div class="team-member-head-div ">
            <div class="team-member-text"><b>Team members</b></div>

            <!-- <div><button type="button" class="btn btn-default" onclick="openNewTeamMemberModalForm()">Add
                    Member</button></div> -->
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addTeamMemberModal">
                Add member
            </button>
        </div>
        <ul class="team-list p-3" id="team-list-data" style="overflow-y:auto; max-height:400px;min-width:400px;">
        </ul>
    </div>
    <!-- team members modal -->
    <div id="teamMembersModal" class="team-members-modal ">
        <div class="team-members-modal-content modals-content">
            <div class="team-member-head-div modals-head-div">
                <div class="team-member-text">All Team members</div>
                <button type="button" class="btn btn-default" onclick="closeTeamMembersModal()">
                    Close
                </button>
            </div>
            <ul class="team-list" id="modal-team-list" style="max-height: 400px; overflow-y: auto;">
            </ul>
        </div>
    </div>

    <div class="modal fade " id="showTeamMemberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <table id="Loadtable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Module Name</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="team-members-modal-content modals-content" style="width:600px">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label class="col-sm-3 col-form-label" for="new-team-member">Select Staff</label>
                            <select id="new-team-member-select" name="new-team-member" class="select2">
                            </select>
                            <label for="modulesList" name='moduleList'>Select Module</label>
                            <select id="modulesList" class="select2"></select>
                        </div>
                    </div>
                    <button id="addNewMemberbtn" type="button" class="btn btn-primary" onclick="addNewTeamMember(`${localStorage.getItem('itplappprojectid')}`)">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade " id="editTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label>Add or Remove Staff from Module</label>
                            <select id="addOrRemoveModule" class="select2">
                                <option value=-1 selected>select</option>
                                <option value="1">Add</option>
                                <option value="0">Remove</option>
                            </select>
                            <input id="removeStaffWithID" type="hidden" />
                            <label>Modules</label>
                            <select id="ModulesToAdd" class="form-control"></select>
                            <select id="modulesStaffIsIn" class="form-control" style="display:none;"></select>
                            <label id="remove-module-remarks-label-id" for="member-remove-remarks" style="display:none;">Remove Remarks</label>
                            <textarea id="member-remove-remarks-text" name="member-remove-remarks" style="display:none;" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmEditTeamMember">CONFIRM</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="removeTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-3">
                        <!-- <div class="col-md">
                            <label class="col-sm-3 col-form-label" for="member-remove-remarks">Remove Remarks</label>
                            <input id="removeStaffWithID" type="hidden" />
                            <textarea id="member-remove-remarks-text" name="member-remove-remarks"></textarea>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmRemoveTeamMember" onclick="removeTeamMember()">CONFIRM</button>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    var SelectedModuleID;
    $(document).ready(function() {
        $('#addOrRemoveModule').change(function() {
            debugger;
            var selectValue = $(this).val();
            if (selectValue == '0') { //Remove TeamMember
                $('#remove-module-remarks-label-id').css('display', 'block');
                $("#member-remove-remarks-text").css('display', 'block');
                $("#ModulesToAdd").hide();
                $("#modulesStaffIsIn").show();
                getAllModulesOfMember($("#removeStaffWithID").val());
            } else {
                $('#remove-module-remarks-label-id').css('display', 'none');
                $("#member-remove-remarks-text").css('display', 'none');
                $("#ModulesToAdd").show();
                $("#modulesStaffIsIn").hide();

            }
        });


    });

    function openTeamMembersModal() {
        $(" #teamMembersModal").css("display", "flex");
    }

    function closeTeamMembersModal() {
        $("#teamMembersModal").css("display", "none");
    }
</script>

<script>
    $(function() {
        getTeamMembers(localStorage.getItem('itplappprojectid'));
        getStaffWithoutProjectByProjectID(localStorage.getItem('itplappprojectid'));

    })

    function getModulesForNotInStaff(StaffID) {
        const obj = {
            Module: "Project",
            Page_key: "getModulesForNotInStaff"
        }
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid'),
            StaffID: StaffID,
        }
        obj.JSON = json;
        SilentTransportCall(obj, onTeamMembersSuccess);
    }

    function editTeamMemberModule(StaffID) {
        debugger;
        const obj = {
            Module: "Project",
            Page_key: "editTeamMemberModule"
        }
        const json = {
            StaffId: StaffID,
            ModuleId: $("#ModulesToAdd").val(),
            AddOrRemove: $("#addOrRemoveModule").val(),
        };
        if ($("#addOrRemoveModule").val() == "0") {
            const removeRemarksText = $.trim($("#member-remove-remarks-text").val());
            if (removeRemarksText.length < 6) {
                alert("Please fill the remove remarks text");
                return;
            } else {
                json.ModuleId = $("#modulesStaffIsIn").val();
                json.removeRemarks = $("#member-remove-remarks-text").val()
            }
        }

        obj.JSON = json;
        // console.log(JSON.stringify(obj));
        SilentTransportCall(obj, onTeamMembersSuccess);
    }


    function getStaffWithoutProjectByProjectID(projectId) {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "getStaffWithoutProjectByProjectID";
        var json = new Object();
        json.ProjectID = projectId;
        obj.JSON = json;
        TransportCall(obj, onTeamMembersSuccess);
    }


    function getTeamMembers(projectId) {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "getTeamMembers";
        var json = new Object();
        json.ProjectID = projectId;
        obj.JSON = json;
        SilentTransportCall(obj, onTeamMembersSuccess);
    }

    function onTeamMembersSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getTeamMembers":
                    // loadTeamMemberData(rc.return_data);
                    loadingAllTeamMembers(rc.return_data);
                    loadSelect("#slTeamMembers", rc.return_data);
                    loadSelect("#add-staff-to-task", rc.return_data);
                    loadSelect("#meetingsAttendeeStaffIDs", rc.return_data);
                    break;
                case "getStaffWithoutProjectByProjectID":
                    loadSelect("#new-team-member-select", rc.return_data);
                    break;
                case 'addNewTeamMember':
                    $("#addTeamMemberModal").find("select").val('');
                    $("#addTeamMemberModal").modal('hide');
                    notify("success", rc.return_data);
                    getTeamMembers(localStorage.getItem('itplappprojectid'));
                    getStaffWithoutProjectByProjectID(localStorage.getItem('itplappprojectid'));
                    break;
                    // case "removeTeamMember":
                    //     $("#removeTeamMember").find("select,textarea").val('');
                    //     $("#removeTeamMember").modal('hide');
                    //     getTeamMembers(localStorage.getItem('itplappprojectid'));
                    //     getStaffWithoutProjectByProjectID(localStorage.getItem('itplappprojectid'));
                    //     break;
                case "editTeamMemberModule":
                    notify("success", rc.return_data);
                    $("#editTeamMember").find('select,textarea').val('');
                    $("#editTeamMember").modal('hide');
                    getTeamMembers(localStorage.getItem('itplappprojectid'));
                    getStaffWithoutProjectByProjectID(localStorage.getItem('itplappprojectid'));
                    break;
                case "getAllModulesOfMember":
                    showTeamMemberModules(rc.return_data);
                    loadSelect("#modulesStaffIsIn", rc.return_data);
                    break;
                case "getModulesForNotInStaff":
                    loadSelect("#ModulesToAdd", rc.return_data);
                    break;
                default:
                    notify("error", rc.Page_key);
            }
        } else {
            notify("error", rc.return_data);
        }
    }



    function showModules(data) {
        let content = "";
        data.map(item => content += `<option value = ${item.ProjectModuleID}>${item.ModuleName}</option>`);
        $("#modulesList").html("");
        $("#modulesList").append(content);
    }

    function loadingAllTeamMembers(data) {
        let team_list = $("#team-list-data");
        let content = "";
        for (var i = 0; i < data.length; i++) {
            content +=
                `<li class="list-item">
                <div class = "team-member-detail-div">
                    <div class="member-img-div">
                        <img id="member-profile-img" src="assets/img/projectImg/boy-1.png" alt="" />
                        <div class="member-name-role">
                            <p class="member-name">${data[i].StaffName}<br>${data[i].DesignationName}
                            </p>
                        </div>
                    </div>
                    
                </div>
                <div class="team-member-edit" style = "flex">
                <button class="btn btn-light" data-toggle="modal" data-target="#knowMoreAboutProjectMember"
        onclick="callToGetModules('${escape(JSON.stringify(data[i]))}')"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-success" style="color:aliceblue;" onclick = "openEditTeamMemberModal(${data[i].StaffID})"><i class="fas fa-edit"></i></button>
                    
                </div>
                </li>`;
        }
        team_list.html("");
        team_list.append(content);
    }

    function callToGetModules(data) {
        debugger;
        data = JSON.parse(unescape(data));
        getAllModulesOfMember(data.StaffID);
        $("#showTeamMemberModal").modal("show");
    }

    // function showRemoveTeamMemberModal(staffId) {
    //     $("#removeStaffWithID").val(staffId);
    //     $("#removeTeamMember").modal("show");
    // }

    function addNewTeamMember(projectId) {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "addNewTeamMember";
        var json = new Object();
        json.ProjectID = projectId;
        json.StaffId = $("#new-team-member-select").val();
        json.ProjectModuleId = $("#modulesList").val();
        obj.JSON = json;
        // console.log(JSON.stringify(obj));
        SilentTransportCall(obj, onTeamMembersSuccess);
    }


    function showTeamMemberModules(data) {
        var table = $("#Loadtable");
        try {
            if ($.fn.DataTable.isDataTable($(table))) {
                $(table).DataTable().destroy();
            }
        } catch (ex) {}

        var text = ""

        if (data.length == 0) {
            text += "No Data Found";
        } else {

            for (let i = 0; i < data.length; i++) {
                text += '<tr> ';
                text += '<td> ' + data[i].ModuleName + '</td>';
                text += '</tr >';
            }
        }

        $("#Loadtable tbody").html("");
        $("#Loadtable tbody").append(text);

    }



    function getAllModulesOfMember(StaffID) {

        const obj = {
            Module: "Project",
            Page_key: "getAllModulesOfMember"
        }
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid'),
            StaffID: StaffID
        }
        obj.JSON = json;
        // console.log(JSON.stringify(obj));
        SilentTransportCall(obj, onTeamMembersSuccess);
    }


    // function removeTeamMember() {
    //     const StaffID = $("#removeStaffWithID").val();
    //     const removeRemarksText = $.trim($("#member-remove-remarks-text").val());
    //     if (removeRemarksText.length < 6) {
    //         alert("Please fill the remove remarks text");
    //         return;
    //     }
    //     const obj = {
    //         Module: "Project",
    //         Page_key: "removeTeamMember",
    //     }
    //     const json = {
    //         StaffId: StaffID,
    //         removeRemarks: removeRemarksText
    //     }
    //     obj.JSON = json;
    //     TransportCall(obj, onTeamMembersSuccess);
    // }

    function openEditTeamMemberModal(StaffID) {
        // Open the modal using Bootstrap's modal() method
        $('#editTeamMember').modal('show');
        $("#removeStaffWithID").val(StaffID);
        getModulesForNotInStaff(StaffID);
        $("#confirmEditTeamMember").click(() => {
            editTeamMemberModule(StaffID);

        })

    }
</script>