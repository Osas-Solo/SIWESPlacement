<?php
require_once "../entities.php";

if (!isset($_POST["id"])) {
    $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
    header("Location: " . $dashboard_url);
} else {
    $placement_request_id = $_POST["id"];
    $status = $_POST["status"];
    session_start();
    $organisation = new Organisation($database_connection, $_SESSION["organisation-email-address"]);
}

$alert_message = "";

$placement_request = new PlacementRequest($database_connection, $placement_request_id,
    organisation_id: $organisation->organisation_id);

if ($placement_request->placement_offer->is_placement_full) {
    $alert_message = "Sorry, the placement quota for this student's department is filled up.";
} else {
    $update_placement_request_query = "UPDATE placement_requests SET status = '$status'";

    if ($status == "Accepted") {
        $acceptance_date = date("Y-m-d");
        $update_placement_request_query .= ", acceptance_date = '$acceptance_date'";
    }

    $update_placement_request_query .= " WHERE placement_request_id = $placement_request_id";

    if ($database_connection->query($update_placement_request_query)) {
        if ($placement_request->placement_offer->calculate_number_of_students_allowed($database_connection) == 0) {
            $update_placement_offer_query = "UPDATE placement_offers SET is_placement_full = true 
                                                WHERE placement_offer_id = " .
                                                      $placement_request->placement_offer->placement_offer_id;

            $database_connection->query($update_placement_offer_query);
        }

        $status_state = strtolower($status);
        
        $alert_message = "Placement request has been $status_state.";
    }
}

echo $alert_message;
?>
