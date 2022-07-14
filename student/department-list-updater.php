<?php
require_once "../entities.php";

$departments = Department::get_departments($database_connection, $_POST["college"]);

$department_list_json = array();

foreach ($departments as $current_department) {
    $current_department_json = array("departmentID"=> $current_department->department_id,
        "departmentName"=> $current_department->department_name);

    array_push($department_list_json, $current_department_json);
}

echo json_encode($department_list_json);
?>