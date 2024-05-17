<?php

namespace app\modules\project;

use app\core\Controller;
use app\modules\project\classes\Meetings;
use app\modules\project\classes\Project;
use app\modules\project\classes\Task;

class ProjectController implements Controller
{

    public function Route($data)
    {
        $jsondata = $data["JSON"];
        switch ($data["Page_key"]) {
            case 'addProject':
                return (new Project())->addProject($jsondata);
            case "getClients":
                return (new Project())->getClients($jsondata);
            case 'getProjectList':
                return (new Project())->getProjectList($jsondata);
            case 'getInfoOfIndividualProjects':
                return (new Project())->getInfoOfIndividualProjects($jsondata);
            case 'getTeamMembers':
                return (new Project())->getTeamMembers($jsondata);
            case 'getModulesByProjectID':
                return (new Project())->getModulesByProjectID($jsondata);
            case "addTask":
                return (new Task())->addTask($jsondata);
            case 'seeAllProjectTaskByProjectID':
                return (new Task())->seeAllProjectTaskByProjectID($jsondata);
            case "getProjectMeetingsInfoByProjectID":
                return (new Meetings())->getProjectMeetingsInfoByProjectID($jsondata);
            case "getStaffWithoutProjectByProjectID":
                return (new Project())->getStaffWithoutProjectByProjectID($jsondata);
            case "showStaffAllToAssignProject":
                return (new Project())->showStaffAllToAssignProject($jsondata);
            case "addNewTeamMember":
                return (new Project())->addNewTeamMember($jsondata);
            case "getManagers":
                return (new Project())->getManagers($jsondata);
                // case "removeTeamMember":
                //     return (new Project())->removeTeamMember($jsondata);
            case "editTeamMemberModule":
                return (new Project())->editTeamMemberModule($jsondata);
            case  "updateProjectField":
                return (new Project())->updateProjectField($jsondata);

            case "StaffWithoutTaskByTaskID":
                return (new Task())->StaffWithoutTaskByTaskID($jsondata);
            case "UpdateTask":
                return (new Task())->UpdateTask($jsondata);
            case "getStaffWithTaskID":
                return (new Task())->getStaffWithTaskID($jsondata);
            case "showProjectCoordinatorName":
                return (new Project())->showProjectCoordinatorName($jsondata);
            case "addProjectMeetingsData":
                return (new Meetings())->addProjectMeetingsData($jsondata);
            case "getAllModulesOfMember":
                return (new Project())->getAllModulesOfMember($jsondata);
            case "getModulesForNotInStaff":
                return (new Project())->getModulesForNotInStaff($jsondata);
            case "addModule":
                return (new Project())->addModule($jsondata);
            case "getProjectModules":
                return (new Project())->getProjectModules($jsondata);
            case "removeModuleByModuleID":
                return (new Project())->removeModuleByModuleID($jsondata);
            case "editProjectModuleDetails":
                return (new Project())->editProjectModuleDetails($jsondata);
            case "uploadTaskDocument":
                return (new Task())->uploadTaskDocument($jsondata);
            default:
                // header('HTTP/1.1 401  Unauthorized Access');
                // header("Status: 401 ");
                // session_destroy();
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }

    public static function Views($page)
    {

        $viewpath = "../app/modules/project/views/";

        switch ($page[1]) {
            case 'showProject':
                load($viewpath . "showProject.php");
                break;

            case 'projectList':
                load($viewpath . "projectList.php");
                break;

            case 'test':
                load($viewpath . "test.php");
                break;

            default:
                // session_destroy();
                include '404.php';
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }
    }
}
