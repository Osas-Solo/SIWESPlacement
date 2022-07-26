<?php
$page_title = "Post Placement Offer";

require_once "dashboard-header.php";

$departments = Department::get_departments($database_connection);

$is_salary_offered = false;
$salary = "";
$salary_error = "";

if (isset($_POST["post-placement"])) {
    post_placement($database_connection, $organisation);
}
?>

    <!-- Job Detail Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                    <div>
                        <form class="was-validated" method="post">
                            <div class="row">
                                <div class="col-12 col-sm-3 mb-3">
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-primary me-3" for="offer-salary">Offer Salary</label>
                                        <input type="checkbox" class="form-check-input" name="offer-salary"
                                               id="offer-salary-checkbox"
                                               <?php
                                               if ($is_salary_offered) {
                                                   echo "checked";
                                               }
                                               ?>
                                               onchange="changeSalaryVisibility()">
                                    </div>
                                    <div class="col-12 mb-3" id="salary-div">
                                        <label class="form-label text-primary" for="salary">Salary (&#8358;)</label>
                                        <input type="number" id="salary-input" class="form-control" name="salary" placeholder="Salary"
                                               value="<?php echo $salary?>" step="0.01" min="10000" max="100000">
                                        <div class="text-danger" id="salary-error-message"><?php echo $salary_error?></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-9 mb-3x">
                                    <h3 class="form-label text-primary text-center mb-5">Select Department(s)</h3>

                                    <?php
                                    foreach ($departments as $current_department) {
                                    ?>
                                        <div class="row py-3 mb-5 mx-auto shadow">
                                            <div class="col-12 col-sm-4 mb-3 mx-auto">
                                                <input type="checkbox" class="form-check-input department-checkboxes" name="departments[]"
                                                    value="<?php echo $current_department->department_id?>"
                                                       onchange="changeNumberOfStudentsVisibility()"><br>
                                                <label class="form-label text-primary" for="departments[]">
                                                    <?php echo $current_department->department_name?>
                                                </label>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3 students-divs">
                                                <label class="form-label text-primary" for="number-of-students[]">
                                                    Number of Student(s)
                                                </label>
                                                <input type="number" class="form-control number-of-students-inputs"
                                                       name="number-of-students[]" placeholder="Number of Student(s)"
                                                       min="1">
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-12 pt-5">
                                    <button class="btn btn-primary w-100" type="submit" name="post-placement">Post Offer</button>
                                </div>
                            </div>

                            <script src="../js/post-placement-utils.js"></script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Job Detail End -->

<?php
require_once "../student/footer.php";

function post_placement(mysqli $database_connection, Organisation $organisation) {
    global $is_salary_offered, $salary_error, $salary;
    $insert_placement_offer_query = "";
    $is_salary_offered = false;
    $salary = "null";
    $selected_department_ids = array();
    $number_of_department_students = array();

    if (isset($_POST["offer-salary"])) {
        $is_salary_offered = cleanse_data($_POST["offer-salary"], $database_connection);
    }

    if ($is_salary_offered) {
        $salary = cleanse_data($_POST["salary"], $database_connection);

        if (empty($salary)) {
            $salary_error = "Please enter salary.";
        }
    }

    if (isset($_POST["departments"])) {
        foreach ($_POST["departments"] as $department) {
            if (isset($department)) {
                array_push($selected_department_ids, $department);
            }
        }

        foreach ($_POST["number-of-students"] as $number_of_current_department_students) {
            if (!empty($number_of_current_department_students)) {
                array_push($number_of_department_students, $number_of_current_department_students);
            }
        }
    }

    if (count($selected_department_ids) == 0) {
        echo "<script>alert('Please select departments to offer placement.')</script>";
    } else if (empty($salary_error) && count($selected_department_ids) > 0 && count($number_of_department_students) > 0) {
        $number_of_selected_departments = count($selected_department_ids);
        $placement_reference = "plmt_$organisation->organisation_id" . "_" . date("Ymdhis");

        for ($i = 0; $i < $number_of_selected_departments; $i++) {
            $insert_placement_offer_query .= "INSERT INTO placement_offers (organisation_id, department_id, 
                              number_of_students, salary, is_placement_full, placement_reference) VALUE 
                              ($organisation->organisation_id, $selected_department_ids[$i], $number_of_department_students[$i],
                              $salary, false, '$placement_reference');";
        }

        if ($database_connection->multi_query($insert_placement_offer_query)) {
            $alert = "<script>
                        if (confirm('Placement offer successfully posted.')) {";
            $placement_offers_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) .
                "/placement-offers.php";
            $alert .= "window.location.replace('$placement_offers_url');
                        } else {";
            $alert .=           "window.location.replace('$placement_offers_url');
                    }";
            $alert .= "</script>";

            echo $alert;
        }
    }
}
?>