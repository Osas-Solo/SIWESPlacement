<?php
$page_title = "Post Placement Offer";

require_once "dashboard-header.php";

$departments = Department::get_departments($database_connection);

$salary = "";
$salary_error = "";
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
                                               id="offer-salary-checkbox" onchange="changeSalaryVisibility()">
                                    </div>
                                    <div class="col-12 mb-3" id="salary-div">
                                        <label class="form-label text-primary" for="salary">Salary (&#8358;)</label>
                                        <input type="number" id="salary-input" class="form-control" name="salary" placeholder="Salary"
                                               value="<?php echo $salary?>" step="0.01" min="10000">
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
                                                <input type="number" class="form-control number-of-students-inputs" name="number-of-students[]"
                                                       placeholder="Number of Student(s)" min="1">
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
?>