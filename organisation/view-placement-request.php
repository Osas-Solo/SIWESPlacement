<?php
$page_title = "View Placement Request";

require_once "dashboard-header.php";

$placement_request_id = "";

if (isset($_GET["id"])) {
    $placement_request_id = $_GET["id"];
}

$placement_request = new PlacementRequest($database_connection, placement_request_id: $placement_request_id,
    organisation_id: $organisation->organisation_id);
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-primary mb-5 text-center"><?php echo $page_title?></h1>

                <?php
                if ($placement_request->is_found()) {
                ?>
                <div class="col-12 col-md-9 mx-auto">
                    <table class="table table-striped table-hover table-sm text-center mb-5">
                        <tbody>
                        <tr>
                            <th class="p-2">Student Name</th>
                            <td class="p-2"><?php echo $placement_request->student->get_full_name()?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Matriculation Number<i class="fa fa-id-card text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->matriculation_number?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Gender</th>
                            <td class="p-2">
                                <?php
                                echo $placement_request->student->get_gender();
                                if ($placement_request->student->is_male()) {
                                    echo "<i class='fa fa-male text-primary ms-1'></i>";
                                } else if ($placement_request->student->is_female()) {
                                    echo "<i class='fa fa-female text-primary ms-1'></i>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="p-2">Email Address<i class="fa fa-laptop text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->email_address?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Phone Number<i class="fa fa-phone-alt text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->phone_number?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Date of Birth<i class="fa fa-calendar-day text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->get_date_of_birth()?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Address<i class="fa fa-home text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->address?></td>
                        </tr>
                        <tr>
                            <th class="p-2">State of Origin<i class="fa fa-map text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->state_of_origin->state_name?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Institution<i class="fa fa-building text-primary ms-1"></i></th>
                            <td class="p-2"><?php echo $placement_request->student->institution?></td>
                        </tr>
                        <tr>
                            <th class="p-2">Department</th>
                            <td class="p-2"><?php echo $placement_request->student->department->department_name?></td>
                        </tr>
                        <tr>
                            <th class="p-2 align-middle">Student ID Card<i class="fa fa-id-card text-primary ms-1"></i></th>
                            <td class="p-2">
                                <img src="<?php echo $placement_request->student->get_student_id_card()?>"
                                     alt="Student ID Card" class="img-thumbnail d-block border">
                            </td>
                        </tr>
                        <tr>
                            <th class="p-2 align-middle">Student IT Placement Letter<i class="fa fa-file text-primary ms-1"></i></th>
                            <td class="p-2">
                                <iframe class="w-100 h-100" src="<?php echo $placement_request->student->get_it_placement_letter()?>"
                                        alt="IT Placement Letter"></iframe>
                            </td>
                        </tr>
                        <tr>
                            <th class="p-2">Status</th>
                            <td class="p-2 <?php
                            if ($placement_request->is_pending()) {
                                echo 'text-warning';
                            } else if ($placement_request->is_accepted()) {
                                echo 'text-success';
                            } else if ($placement_request->is_rejected()) {
                                echo 'text-danger';
                            }
                            ?>">
                                <?php echo $placement_request->status?>
                            </td>
                        </tr>
                        <?php
                        if ($placement_request->is_accepted()) {
                        ?>
                        <tr>
                            <th class="p-2">Acceptance Date</th>
                            <td class="p-2"><?php echo $placement_request->get_acceptance_date()?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>

                    <?php
                    if ($placement_request->is_pending()) {
                    ?>
                    <div class="row mt-5">
                        <div class="col-12 col-sm-4 mx-auto mb-3">
                            <button class="btn btn-success d-block mx-auto" type="button"
                                onclick="respondToPlacementRequestResponderRequest('Accepted', <?php echo $placement_request->placement_request_id?>)">
                                Accept Request
                            </button>
                        </div>
                        <div class="col-12 col-sm-4 mx-auto">
                            <button class="btn btn-danger d-block mx-auto" type="button"
                                    onclick="respondToPlacementRequestResponderRequest('Rejected', <?php echo $placement_request->placement_request_id?>)">
                                Reject Request
                            </button>
                        </div>

                        <script src="../js/placement-request-responder.js"></script>
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <?php
                } else {
                    ?>
                    <div class="row my-5 gy-5 gx-4">
                        <div class="col-12 my-5">
                            <div class="text-center ps-4">
                                <h3 class="mb-3">
                                    Sorry, no placement request with the id: <?php echo $placement_request_id?> could be found.
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php
require_once "../student/footer.php";
?>
