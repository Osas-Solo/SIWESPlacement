<?php
$page_title = "Student Dashboard";

require_once "dashboard-header.php";

$placement_offers = PlacementOffer::get_placement_offers($database_connection, "",
    $student->department->department_name);
$placement_requests = PlacementRequest::get_placement_requests($database_connection, $student->matriculation_number);
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                <div class="col-12 col-md-9 mx-auto">
                    <table class="table table-striped table-hover table-sm text-center mb-5">
                        <tbody>
                            <tr>
                                <th class="p-2">Name</th>
                                <td class="p-2"><?php echo $student->get_full_name()?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Matriculation Number</th>
                                <td class="p-2"><?php echo $student->matriculation_number?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Gender</th>
                                <td class="p-2"><?php echo $student->gender?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Email Address</th>
                                <td class="p-2"><?php echo $student->email_address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Phone Number</th>
                                <td class="p-2"><?php echo $student->phone_number?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Date of Birth</th>
                                <td class="p-2"><?php echo $student->get_date_of_birth()?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Address</th>
                                <td class="p-2"><?php echo $student->address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">State of Origin</th>
                                <td class="p-2"><?php echo $student->state_of_origin->state_name?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Institution</th>
                                <td class="p-2"><?php echo $student->institution?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Department</th>
                                <td class="p-2"><?php echo $student->department->department_name?></td>
                            </tr>
                            <tr>
                                <th colspan="2"><a href="update-profile.php">Update Details</a></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<?php
require_once "footer.php";
?>
