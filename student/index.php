<?php
$page_title = "Student Dashboard";

require_once "dashboard-header.php";
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
                                <th class="p-2">Matriculation Number<i class="fa fa-id-card text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->matriculation_number?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Gender</th>
                                <td class="p-2">
                                    <?php
                                    echo $student->get_gender();
                                    if ($student->is_male()) {
                                        echo "<i class='fa fa-male text-primary ms-1'></i>";
                                    } else if ($student->is_female()) {
                                        echo "<i class='fa fa-female text-primary ms-1'></i>";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">Email Address<i class="fa fa-laptop text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->email_address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Phone Number<i class="fa fa-phone-alt text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->phone_number?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Date of Birth<i class="fa fa-calendar-day text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->get_date_of_birth()?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Address<i class="fa fa-home text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">State of Origin<i class="fa fa-map text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->state_of_origin->state_name?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Institution<i class="fa fa-building text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $student->institution?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Department</th>
                                <td class="p-2"><?php echo $student->department->department_name?></td>
                            </tr>
                            <tr>
                                <th class="p-2 align-middle">Student ID Card<i class="fa fa-id-card text-primary ms-1"></i></th>
                                <td class="p-2">
                                    <?php
                                    if ($student->is_student_id_card_submitted()) {
                                    ?>
                                    <img src="<?php echo $student->get_student_id_card()?>"
                                         alt="Student ID Card" class="img-thumbnail d-block border">
                                    <?php
                                    } else {
                                    ?>
                                    You have not yet uploaded your student ID Card
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2 align-middle">Student IT Placement Letter<i class="fa fa-file text-primary ms-1"></i></th>
                                <td class="p-2">
                                    <?php
                                    if ($student->is_it_placement_letter_submitted()) {
                                        ?>
                                        <iframe class="w-100 h-100" src="<?php echo $student->get_it_placement_letter()?>"
                                                alt="IT Placement Letter"></iframe>
                                        <?php
                                    } else {
                                        ?>
                                        You have not yet uploaded your IT placement letter
                                        <?php
                                    }
                                    ?>
                                </td>
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
