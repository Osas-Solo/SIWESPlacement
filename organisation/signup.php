<?php
$page_title = "Organisation Signup";

require_once "../student/header.php";
require_once "../entities.php";

session_start();
if (isset($_SESSION["organisation-email-address"])) {
    session_unset();
    session_destroy();
}

$password_error = "Please enter a valid password.";
$organisation_name_error = $confirm_password_error = $email_address_error = $phone_number_error = $address_error =
    $description_error = $logo_error = "";

$organisation_name = $email_address = $phone_number = $address = $description = "";

if (isset($_POST["signup"])) {
    signup_organisation($database_connection);
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
                                    <label class="form-label text-primary" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                           required minlength="8">
                                    <div>
                                        Please enter a password with an uppercase letter, a lowercase letter and a digit.
                                        Your password should be at least 8 characters long.
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
                                    <label class="form-label text-primary" for="phone-number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="phone-number" placeholder="08012345678"
                                           required value="<?php echo $phone_number?>" pattern="0[7-9][0-1]\d{8}">
                                    <div class="text-danger" id="phone-number-error-message"><?php echo $phone_number_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="logo">Organisation Logo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file form-control" name="logo" required
                                           accept="image/png, image/jpeg" onchange="previewMedia(event, 'logo-preview')">
                                    <img id="logo-preview" class="img-fluid d-block border mt-2" alt="Logo Preview">
                                    <div class="text-danger" id="logo-error-message">
                                        <?php echo $logo_error?>
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
                                    <button class="btn btn-primary w-100" type="submit" name="signup">Sign Up</button>
                                    <p class="mt-3 text-center">
                                        Already registered yet? <a href="login.php">Login as an organisation instead.</a>
                                    </p>
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

function signup_organisation(mysqli $database_connection) {
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
            $logo_error = "Organisation\'s logo must be a PNG or JPEG image ending with the .png, .jpg or .jpeg format suffix.";
        }
    } else {
        $logo_error = "Please upload organisation's logo.";
    }

    if (!is_password_valid($password)) {
        $password_error = "Please enter a valid password.";
    } else {
        $password_error = "";
    }

    if (!is_password_confirmed($password, $password_confirmer)) {
        $confirm_password_error = "Passwords do not match.";
    }

    if (!is_email_address_valid($email_address)) {
        $email_address_error = "Please enter a valid email address.";
    } else if (is_email_address_in_use($database_connection)) {
        $email_address_error = "Sorry, the email address $email_address is already in use.";
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
        $insert_query = "INSERT INTO organisations (organisation_name, address, description, phone_number, email_address, 
                           logo_path, password) VALUE 
                            ('$organisation_name', '$address', '$description', '$phone_number', '$email_address', 
                             '$logo_file', SHA('$password'))";

        if ($database_connection->query($insert_query)) {
            move_uploaded_file($logo["tmp_name"], $logo_path);

            $alert = "<script>
                        if (confirm('You\'ve successfully completed organisation\'s registration. You may now proceed to login.')) {";
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