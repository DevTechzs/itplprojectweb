<div class="second-child-3">
    <div class="meeting-div">
        <div class="team-member-head-div ">
            <h2 class="card-title" style="font-size:20px;"><b>Project Meetings</b></h2>
            <div class="see-all-btn-div">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#meetings-add-modal">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <!-- meetings modal -->
            <div class="modal fade" id="meetings-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container">

                                <div class="form-group">
                                    <label for="meetingDescription">Meeting Description:</label>
                                    <input type="text" class="form-control" id="meetingDescription" placeholder="Enter meeting description">
                                </div>

                                <div class="form-group">
                                    <label for="attendeeStaffIDs">Attendee Staff IDs:</label>
                                    <select id="meetingsAttendeeStaffIDs" class="select2" multiple></select>
                                </div>
                                <div class=" form-group">
                                    <label for="report">Report:</label>
                                    <input type="file" class="form-control-file" id="meetingsReport">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveMeetingsBtn">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body p-1" style="max-height:500px; overflow-y:auto;">
            <table class="table table-striped" id="meetings-data-table">
                <thead style=" top:0; background-color:white;color:black;" class="sticky-top">
                    <tr>
                        <th style=" width: 10px">#</th>
                        <th>Meeting ID</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Attendees</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        getProjectMeetingsInfoByProjectID(localStorage.getItem('itplappprojectid'));
    });

    function getProjectMeetingsInfoByProjectID(projectId) {
        var obj = new Object();
        obj.Module = "Project";
        obj.Page_key = "getProjectMeetingsInfoByProjectID";
        var json = new Object();
        json.ProjectID = projectId;
        obj.JSON = json;
        TransportCall(obj, onProjectMeetingsSuccess);
    }

    function onProjectMeetingsSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getProjectMeetingsInfoByProjectID":
                    loadMeetingsData(rc.return_data);
                    break;
                case "addProjectMeetingsData":
                    notify("success", rc.return_data);
                    $("#meetings-add-modal").find('input', 'select').val('');
                    $("#meetings-add-modal").modal('hide');
                    getProjectMeetingsInfoByProjectID(localStorage.getItem('itplappprojectid'));
                    break;
                default:
                    notify("error", rc.Page_key);
            }
        } else {
            notify("error", rc.return_data);
        }
    }

    function loadMeetingsData(data) {
        let content = "";
        for (let i = 0; i < data.length; i++) {
            content += `<tr>
                        <td>${i+1}</td>
                        <td>${data[i].MeetingID}</td>
                        <td>${data[i].MeetingDescription}</td>
                        <td>${data[i].MeetingDate}</td>
                        <td>${data[i].AttendeeNames}</td>
                        <td>
                        ${data[i].DocumentPath ? `<a href="file?type=letters&name=${data[i].DocumentPath}" download class="report-download"><span class="badge bg-light">Download Report</span></a>`:'no files'}
                        </td>
                    </tr>`;
        }
        $("#meetings-data-table tbody").html("");
        $("#meetings-data-table tbody").append(content);
    }

    $("#saveMeetingsBtn").click(async () => {
        debugger;
        var files = $("#meetingsReport")[0].files;
        let fileData = {};
        let base64;
        if (files.length > 0) {
            base64 = await getBase64(files[0]);
            fileData = {
                filedata: base64,
                filename: files[0].name
            }
        }

        const obj = {
            Module: "Project",
            Page_key: "addProjectMeetingsData"
        };
        const json = {
            ProjectID: localStorage.getItem('itplappprojectid'),
            MeetingDescription: $("#meetingDescription").val(),
            MeetingsAttendes: $("#meetingsAttendeeStaffIDs").val(),
            MeetingsReport: fileData

        }
        obj.JSON = json;

        SilentTransportCall(obj, onProjectMeetingsSuccess);
    })


    function getBase64(file) {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                resolve(reader.result);
            };
            reader.onerror = function(error) {
                reject(error);
            };
        })

    }
</script>