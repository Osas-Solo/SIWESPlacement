<?php
$page_title = "Student Signup";

require_once "header.php";
require_once "../entities.php";

$password_error = "Please enter a valid password.";

$first_name_error = $last_name_error = $matriculation_number_error = $confirm_password_error = $email_address_error =
    $phone_number_error = $date_of_birth_error = $address_error = $state_of_origin_error = $college_error = $department_error = "";

$gender = "M";
$first_name = $middle_name = $last_name = $matriculation_number = $email_address = $phone_number = $date_of_birth =
    $address = $state_of_origin = $college = $department = "";

if (isset($_POST["signup"])) {
    signup_student($database_connection);
}

$states = State::get_states($database_connection);
$colleges = ["", "College of Science", "College of Technology"];
?>

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                    <div>
                        <form class="was-validated" method="post">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="first-name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first-name" placeholder="First Name"
                                           required value="<?php echo $first_name?>">
                                    <div class="text-danger" id="first-name-error-message"><?php echo $first_name_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="middle-name">Middle Name</label>
                                    <input type="text" class="form-control" name="middle-name" placeholder="Middle Name"
                                           value="<?php echo $middle_name?>">
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="last-name">Surname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last-name" placeholder="Surname"
                                           required value="<?php echo $last_name?>">
                                    <div class="text-danger" id="last-name-error-message"><?php echo $last_name_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="matriculation-number">Matriculation Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="matriculation-number" pattern="CO[S|T]/[0-9]{4}/20[0-9]{2}"
                                           placeholder="COS/0123/2022" required value="<?php echo $matriculation_number?>">
                                    <div class="text-danger" id="matriculation-number-error-message"><?php echo $matriculation_number_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                           required minlength="8">
                                    <div>
                                        Please enter of password with an uppercase, lowercase and a number. Your
                                        password should be at least 8 characters long.
                                        <br>
                                        <span class="text-danger"><?php echo $password_error?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="password-confirmer">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password-confirmer"
                                           placeholder="Confirm Password" required>
                                    <div class="text-danger" id="password-confirmer-error-message"><?php echo $confirm_password_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="email-address">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email-address" placeholder="Email Address"
                                           required value="<?php echo $email_address?>">
                                    <div class="text-danger" id="email-address-error-message"><?php echo $email_address_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="phone-number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="phone-number" placeholder="08012345678"
                                           required value="<?php echo $phone_number?>" pattern="0[7-9][0-1]\d{8}">
                                    <div class="text-danger" id="phone-number-error-message"><?php echo $phone_number_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="date-of-birth">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date-of-birth" min="1940-01-01"
                                           max="2006-12-31" required value="<?php echo $date_of_birth?>">
                                    <div class="text-danger" id="date-of-birth-error-message"><?php echo $date_of_birth_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="gender">Gender <span class="text-danger">*</span></label>
                                    <br>
                                    <div class="p-2 border border-1 border-primary shadow col-12">
                                        <input type="radio" class="form-check-input" name="gender" value="M"
                                               <?php if ($gender == 'M') {
                                                   echo "checked";
                                               }?>> Male
                                        <input type="radio" class="form-check-input ms-3" name="gender" value="F"
                                            <?php if ($gender == 'F') {
                                                echo "checked";
                                            }?>> Female
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="state-of-origin">State of Origin <span class="text-danger">*</span></label>
                                    <select class="form-select" name="state-of-origin" required>
                                        <option value="" <?php if ($state_of_origin == "") {
                                            echo "selected";
                                        }?>>
                                        </option>
                                        <?php
                                        foreach ($states as $current_state) {
                                        ?>
                                        <option value="<?php echo $current_state->state_id?>"
                                            <?php if ($state_of_origin == $current_state->state_id) {
                                            echo "selected";
                                        }?>>
                                            <?php echo $current_state->state_name?>
                                        </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger" id="state-of-origin-error-message"><?php echo $state_of_origin_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="institution">Institution <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="institution" readonly
                                        value="Federal University of Petroleum Resources, Effurun">
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="college">College <span class="text-danger">*</span></label>
                                    <select id="college-select" class="form-select" name="college" required
                                            onchange="updateDepartmentSelect()">
                                        <?php
                                        foreach ($colleges as $current_college) {
                                        ?>
                                            <option value="<?php echo $current_college?>"
                                                <?php if ($college == $current_college) {
                                                    echo "selected";
                                                }?>>
                                                <?php echo $current_college?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger" id="college-error-message"><?php echo $college_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="department">Department <span class="text-danger">*</span></label>
                                    <span class="d-none" id="department-id"><?php echo $department?></span>
                                    <select id="department-select" class="form-select" name="department" required>
                                    </select>
                                    <div class="text-danger" id="department-message"><?php echo $department_error?></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-primary" for="address">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" rows="5" placeholder="Address"><?php echo $address?></textarea>
                                    <div class="text-danger" id="address-error-message"><?php echo $address_error?></div>
                                </div>
                                <div class="col-12 pt-5">
                                    <button class="btn btn-primary w-100" type="submit" name="signup">Sign Up</button>
                                    <p class="mt-3 text-center">Already registered yet? <a href="login.php">Login as a student instead.</a></p>
                                </div>
                            </div>

                            <script src="../js/department-list-updater.js"></script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
require_once "footer.php";

function signup_student(mysqli $database_connection) {
    global $password_error, $first_name_error, $last_name_error, $matriculation_number_error, $confirm_password_error,
           $email_address_error, $phone_number_error, $date_of_birth_error, $address_error, $state_of_origin_error,
           $college_error, $department_error;

    global $gender, $first_name, $middle_name, $last_name, $matriculation_number, $email_address, $phone_number,
           $date_of_birth, $address, $state_of_origin, $college, $department;

    $gender = cleanse_data($_POST["gender"], $database_connection);
    $matriculation_number = cleanse_data($_POST["matriculation-number"], $database_connection);
    $first_name = cleanse_data($_POST["first-name"], $database_connection);
    $middle_name = cleanse_data($_POST["middle-name"], $database_connection);
    $last_name = cleanse_data($_POST["last-name"], $database_connection);
    $email_address = cleanse_data($_POST["email-address"], $database_connection);
    $phone_number = cleanse_data($_POST["phone-number"], $database_connection);
    $date_of_birth = cleanse_data($_POST["date-of-birth"], $database_connection);
    $address = cleanse_data($_POST["address"], $database_connection);
    $state_of_origin = cleanse_data($_POST["state-of-origin"], $database_connection);
    $institution = cleanse_data($_POST["institution"], $database_connection);
    $college = cleanse_data($_POST["college"], $database_connection);
    $department = cleanse_data($_POST["department"], $database_connection);
    $password = cleanse_data($_POST["password"], $database_connection);
    $password_confirmer = cleanse_data($_POST["password-confirmer"], $database_connection);

    if (!is_password_valid($password)) {
        $password_error = "Please enter a valid password.";
    } else {
        $password_error = "";
    }

    if (!is_password_confirmed($password, $password_confirmer)) {
        $confirm_password_error = "Passwords do not match.";
    }

    if (!is_matriculation_number_valid($matriculation_number)) {
        $matriculation_number_error = "Please enter a valid matriculation number.";
    } else if (is_matriculation_number_in_use($database_connection)) {
        $matriculation_number_error = "Sorry, the matriculation number $matriculation_number is already in use.";
    }

    if (!is_detail_filled($first_name)) {
        $first_name_error = "Please enter your first name.";
    }

    if (!is_detail_filled($last_name)) {
        $last_name_error = "Please enter your surname.";
    }

    if (!is_email_address_valid($email_address)) {
        $email_address_error = "Please enter a valid email address.";
    }

    if (!is_phone_number_valid($phone_number)) {
        $phone_number_error = "Please enter a valid phone number.";
    }

    if (!is_date_of_birth_valid($date_of_birth)) {
        $date_of_birth_error = "Please enter a valid date of birth.";
    }

    if (!is_detail_filled($address)) {
        $address_error = "Please enter your address.";
    }

    if (!is_detail_filled($state_of_origin)) {
        $state_of_origin_error = "Please select your state of origin.";
    }

    if (!is_detail_filled($college)) {
        $college_error = "Please select your college.";
    }

    if (!is_detail_filled($department)) {
        $department_error = "Please select your department.";
    }

    if (empty($first_name_error) && empty($last_name_error) && empty($matriculation_number_error) && empty($password_error)
        && empty($confirm_password_error) && empty($email_address_error) && empty($phone_number_error) &&
        empty($date_of_birth_error) && empty($address_error) && empty($state_of_origin_error) && empty($college_error)
        && empty($department_error)) {
        $insert_query = "INSERT INTO students (matriculation_number, password, first_name, middle_name, last_name, 
                            email_address, phone_number, date_of_birth, address, state_id, institution, department_id, 
                            gender) VALUE 
                            ('$matriculation_number', SHA('$password'), '$first_name', '$middle_name', '$last_name', 
                             '$email_address', '$phone_number', '$date_of_birth', '$address', $state_of_origin, 
                             '$institution', $department, '$gender')";

        if ($database_connection->query($insert_query)) {
            $alert = "<script>
                        if (confirm('You\'ve successfully completed your registration. You may now proceed to login.')) {";
            $login_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/login.php";
            $alert .= "window.location.replace('$login_url');
                        } else {";
            $alert .=           "window.location.replace('$login_url');
                    }";
            $alert .= "</script>";

            echo $alert;
        }
    }
}
?>