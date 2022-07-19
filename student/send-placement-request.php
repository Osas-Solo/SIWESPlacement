<?php
require_once "../entities.php";

if (!isset($_POST["placement-reference"])) {
    $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
    header("Location: " . $dashboard_url);
} else {
    $placement_reference = $_POST["placement-reference"];
    session_start();

    $student = new Student($database_connection, $_SESSION["matriculation-number"]);
}

$alert_message = "";

$placement_offers = PlacementOffer::get_placement_offers($database_connection, $placement_reference,
    $student->department->department_name);
$placement_requests = PlacementRequest::get_placement_requests($database_connection, $placement_offers[0]->placement_offer_id,
    $student->matriculation_number, "Pending");

if (count($placement_requests)) {
    $alert_message = "Sorry, you already have a pending placement request with this organisation.";
} else if (count($placement_offers)) {
    if ($placement_offers[0]->is_placement_full) {
        $alert_message = "Sorry, the placement quota for your department at this organisation is filled up.";
    } else {
        $placement_offer_id = $placement_offers[0]->placement_offer_id;

        $insert_placement_request_query = "INSERT INTO placement_requests (student_id, placement_offer_id, status) VALUE 
                                            ($student->user_id, $placement_offer_id, 'Pending')";

        if ($database_connection->query($insert_placement_request_query)) {
            $placement_requests = PlacementRequest::get_placement_requests($database_connection,
                $placement_offer_id, $student->matriculation_number);
            $last_placement_request_index = count($placement_requests) - 1;
            $placement_request_id = $placement_requests[$last_placement_request_index]->placement_request_id;

            $alert_message = $view_placement_request_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) .
                "/view-placement-request.php?id=" . $placement_request_id;
        }
    }
} else {
    $alert_message = "Sorry, there is no placement currently available at this organisation for your department.";
}

echo $alert_message;
?>
