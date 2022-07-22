<?php
$page_title = "Update Organisation Profile";

require_once "dashboard-header.php";

$organisation_name_error = $password_error = $confirm_password_error = $email_address_error = $phone_number_error = $address_error =
    $description_error = $logo_error = "";

$organisation_name = $organisation->organisation_name;
$email_address = $organisation->email_address;
$phone_number = $organisation->phone_number;
$address = $organisation->address;
$description = $organisation->description;

if (isset($_POST["update"])) {
    update_profile($database_connection, $organisation);
}
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                <div>
                    <form class="was-validated" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="organisation-name">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="organisation-name"
                                       placeholder="Organisation Name" required value="<?php echo $organisation_name?>">
                                <div class="text-danger" id="organisation-name-error-message">
                                    <?php echo $organisation_name_error?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="email-address">Organisation Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email-address" placeholder="Email Address"
                                       required value="<?php echo $email_address?>">
                                <div class="text-danger" id="email-address-error-message"><?php echo $email_address_error?></div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       minlength="8">
                                <div>
                                    Please leave blank if you do not intend to change your password.<br>
                                    If you would like to change your password, enter a password with an uppercase letter,
                                    a lowercase letter and a digit. Your password should be at least 8 characters long.
                                    <br>
                                    <span class="text-danger"><?php echo $password_error?></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="password-confirmer">Confirm Password</label>
                                <input type="password" class="form-control" name="password-confirmer"
                                       placeholder="Confirm Password">
                                <div class="text-danger" id="password-confirmer-error-message"><?php echo $confirm_password_error?></div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="phone-number">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone-number" placeholder="08012345678"
                                       required value="<?php echo $phone_number?>" pattern="0[7-9][0-1]\d{8}">
                                <div class="text-danger" id="phone-number-error-message"><?php echo $phone_number_error?></div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="logo">Organisation Logo</label>
                                <input type="file" class="form-control-file form-control" name="logo"
                                       accept="image/png, image/jpeg" onchange="previewMedia(event, 'logo-preview')">
                                <img src="<?php echo $organisation->get_logo()?>" id="logo-preview" class="img-fluid
                                    d-block border my-3" alt="Logo Preview">
                                <div>
                                    Do not select any image if you do not intend to change organisation's logo.<br>
                                    <span class="text-danger"><?php echo $logo_error?></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="address">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address" rows="5" placeholder="Address"
                                          required><?php echo $address?></textarea>
                                <div class="text-danger" id="address-error-message"><?php echo $address_error?></div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Description"
                                          required><?php echo $description?></textarea>
                                <div class="text-danger" id="description-error-message"><?php echo $description_error?></div>
                            </div>
                            <div class="col-12 pt-5">
                                <button class="btn btn-primary w-100" type="submit" name="update">Update Profile</button>
                            </div>
                        </div>

                        <script src="../js/media-previewer.js"></script>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
require_once "../student/footer.php";

function update_profile(mysqli $database_connection, Organisation $organisation) {
    global $password_error, $organisation_name_error, $confirm_password_error, $email_address_error, $phone_number_error,
           $address_error, $description_error, $logo_error;

    global $organisation_name, $email_address, $phone_number, $address, $description;

    $organisation_name = cleanse_data($_POST["organisation-name"], $database_connection);
    $email_address = cleanse_data($_POST["email-address"], $database_connection);
    $phone_number = cleanse_data($_POST["phone-number"], $database_connection);
    $address = cleanse_data($_POST["address"], $database_connection);
    $description = cleanse_data($_POST["description"], $database_connection);
    $password = cleanse_data($_POST["password"], $database_connection);
    $password_confirmer = cleanse_data($_POST["password-confirmer"], $database_connection);

    $logo = "";
    $logo_directory = "../img/organisation_logos/";
    $logo_file = "";
    $logo_path = "";

    if (isset($_FILES["logo"]) && !empty($_FILES["logo"]["name"])) {
        $logo = $_FILES["logo"];

        if (str_ends_with($logo["name"], ".png") || str_ends_with($logo["name"], ".jpg") ||
            str_ends_with($logo["name"], ".jpeg")) {
            preg_match("/\.(png)|(jpg)|(jpeg)$/", $logo["name"], $file_format);

            $logo_file = $email_address . "_logo" . $file_format[0];
            $logo_path = $logo_directory . $logo_file;
        } else {
            $logo_error = "Organisation logo must be a PNG or JPEG image ending with the .png, .jpg or .jpeg format suffix.";
        }
    }

    if (!empty($password)) {
        if (!is_password_valid($password)) {
            $password_error = "Please enter a valid password.";
        } else {
            $password_error = "";
        }

        if (!is_password_confirmed($password, $password_confirmer)) {
            $confirm_password_error = "Passwords do not match.";
        }
    }

    if ($email_address != $organisation->email_address) {
        if (!is_email_address_valid($email_address)) {
            $email_address_error = "Please enter a valid email address.";
        } else if (is_email_address_in_use($database_connection)) {
            $email_address_error = "Sorry, the email address $email_address is already in use.";
        }
    }

    if (!is_detail_filled($organisation_name)) {
        $organisation_name_error = "Please enter organisation's name.";
    }

    if (!is_phone_number_valid($phone_number)) {
        $phone_number_error = "Please enter a valid phone number.";
    }

    if (!is_detail_filled($address)) {
        $address_error = "Please enter organisation's address.";
    }

    if (!is_detail_filled($description)) {
        $description_error = "Please enter organisation's description.";
    }

    if (empty($organisation_name_error) && empty($password_error) && empty($confirm_password_error) &&
        empty($email_address_error) && empty($phone_number_error) && empty($address_error) && empty($description_error)
        && empty($logo_error)) {
        $update_query = "UPDATE students SET matriculation_number = '$matriculation_number', first_name = '$first_name',
                            middle_name = '$middle_name', last_name = '$last_name', gender = '$gender', address = '$address',
                            email_address = '$email_address', phone_number = '$phone_number', date_of_birth = '$date_of_birth',
                            state_id = $state_of_origin, department_id = $department";

        if (!empty($password)) {
            $update_query .= ", password = SHA('$password')";
        }

        $update_query .= " WHERE user_id = $organisation->user_id";

        if ($database_connection->query($update_query)) {
            $alert = "<script>
                        if (confirm('You\'ve successfully updated your profile.')) {";
            $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
            $alert .= "window.location.replace('$dashboard_url');
                        } else {";
            $alert .=           "window.location.replace('$dashboard_url');
                    }";
            $alert .= "</script>";

            echo $alert;
        }
    }
}
?>
