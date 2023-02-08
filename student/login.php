<?php
session_start();
if (isset($_SESSION["matriculation-number"])) {
    $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
    header("Location: " . $dashboard_url);
}

$page_title = "Student Login";

require_once "header.php";
require_once "../entities.php";

$matriculation_number_error = $password_error = "";

$matriculation_number = "";

if (isset($_POST["login"])) {
    login_student($database_connection);
}
?>

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                    <div>
                        <form method="post">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="matriculation-number">Matriculation Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="matriculation-number" pattern="CO[S|T]/[0-9]{4}/20[0-9]{2}"
                                           oninput="hideMatriculationNumberErrorMessage()" placeholder="COS/0123/2022" required value="<?php echo $matriculation_number?>">
                                    <div class="text-danger" id="matriculation-number-error-message"><?php echo $matriculation_number_error?></div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <label class="form-label text-primary" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                           oninput="hidePasswordErrorMessage()" required>
                                    <div id="password-error-message" class="text-danger"><?php echo $password_error?></div>
                                </div>

                                <script src="../js/login-validation.js"></script>
                                <div class="col-12">
                                    <button class="btn btn-primary d-block mx-auto" type="submit" name="login">Login</button>
                                    <p class="mt-3 text-center">
                                        Not registered yet? <a href="signup.php">Signup as a student instead.</a>
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
require_once "footer.php";

function login_student(mysqli $database_connection) {
    global $matriculation_number_error, $password_error;

    global $matriculation_number;

    $matriculation_number = cleanse_data($_POST["matriculation-number"], $database_connection);
    $password = cleanse_data($_POST["password"], $database_connection);

    $student = new Student($database_connection, $matriculation_number, $password);

    if ($student->is_found()) {
        session_start();
        $_SESSION["matriculation-number"] = $student->matriculation_number;

        $alert = "<script>
                    if (confirm('Login successful. You may now proceed to access your dashboard.')) {";
        $dashboard_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/index.php";
        $alert .=           "window.location.replace('$dashboard_url');
                    } else {";
        $alert .=           "window.location.replace('$dashboard_url');
                    }";
        $alert .= "</script>";

        echo $alert;
    } else if (is_matriculation_number_in_use($database_connection)) {
        $password_error = "Sorry, the password you have entered is incorrect.";
    } else {
        $matriculation_number_error = "Sorry, no student with the matriculation number $matriculation_number could be found.";
    }
}
?>