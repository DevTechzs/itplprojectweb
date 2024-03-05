<?php

namespace app\modules\project\classes;

use app\database\DBController;

class Project
{
    /* 
    Current Version: 2.0.0
    Created By: Sahil,     dev1.in
    Created On: 
    Modified By:
    Modified On: 

*/

    function deleteProject()
    {
    }

    function addTask()
    {
        $sql = "INSERT INTO tasks (task_title, task_description, assigned_to, priority, due_date, attachments)VALUES (
    'Task Title Value',
    'Task Description Value',
    'emp-1,emp-2',  
    'High',         
    '2024-02-05',   
    'file1.txt,file2.txt' 
);";
    }
}