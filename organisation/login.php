<?php
session_start();
if (isset($_SESSION["organisation-email-address"])) {
    $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
    header("Location: " . $dashboard_url);
}

$page_title = "Organisation Login";

require_once "../student/header.php";
require_once "../entities.php";

$email_address_error = $password_error = "";

$email_address = "";

if (isset($_POST["login"])) {
    login_organisation($database_connection);
}
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
                                    <label class="form-label text-primary" for="email-address">Organisation Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email-address" placeholder="Email Address"
                                           required value="<?php echo $email_address?>">
                                    <div class="text-danger" id="email-address-error-message"><?php echo $email_address_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                           required>
                                    <div id="password-error-message" class="text-danger"><?php echo $password_error?></div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary d-block mx-auto" type="submit" name="login">Login</button>
                                    <p class="mt-3 text-center">
                                        Not registered yet? <a href="signup.php">Signup as an organisation instead.</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
require_once "../student/footer.php";

function login_organisation(mysqli $database_connection) {
    global $email_address_error, $password_error;

    global $email_address;

    $email_address = cleanse_data($_POST["email-address"], $database_connection);
    $password = cleanse_data($_POST["password"], $database_connection);

    $organisation = new Organisation($database_connection, $email_address, $password);

    if ($organisation->is_found()) {
        session_start();
        $_SESSION["organisation-email-address"] = $organisation->email_address;

        $alert = "<script>
                    if (confirm('Login successful. You may now proceed to access the organisation\'s dashboard.')) {";
        $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
        $alert .=           "window.location.replace('$dashboard_url');
                    } else {";
        $alert .=           "window.location.replace('$dashboard_url');
                    }";
        $alert .= "</script>";

        echo $alert;
    } else if (is_email_address_in_use($database_connection)) {
        $password_error = "Sorry, the password you have entered is incorrect.";
    } else {
        $email_address_error = "Sorry, no organisation with the email address $email_address could be found.";
    }
}
?>