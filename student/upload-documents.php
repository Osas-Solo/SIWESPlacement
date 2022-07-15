<?php
$page_title = "Student Upload Documents";

require_once "dashboard-header.php";

$it_placement_letter_error = $student_id_card_error = "";

$it_placement_letter_path = $student->get_it_placement_letter();
$student_id_card_path = $student->get_student_id_card();

if (isset($_POST["upload"])) {
    upload_documents($database_connection, $student);
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
                                <label class="form-label text-primary" for="student-id-card">Student ID Card</label>
                                <input type="file" class="form-control-file form-control" name="student-id-card"
                                       accept="image/jpeg" onchange="previewPhoto(event)">
                                <img src="<?php echo $student_id_card_path?>" id="photo-preview"
                                     class="img-fluid d-block border mt-2">
                                <div class="text-danger" id="student-id-card-error-message">
                                    <?php echo $student_id_card_error?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-3">
                                <label class="form-label text-primary" for="it-placement-letter">IT Placement Letter</label>
                                <input type="file" class="form-control-file form-control" name="it-placement-letter"
                                       accept="application/pdf">
                                <div class="text-danger" id="it-placement-letter-error-message">
                                    <?php echo $it_placement_letter_error?>
                                </div>
                            </div>
                            <div class="col-12 pt-5">
                                <button class="btn btn-primary w-100" type="submit" name="upload">Upload Documents</button>
                            </div>
                        </div>

                        <script src="../js/photo-previewer.js"></script>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
require_once "footer.php";

function upload_documents(mysqli $database_connection, Student $student) {
    global $student_id_card_error, $it_placement_letter_error;

    $update_query = "";

    if (isset($_FILES["student-id-card"])) {
        $student_id_card = $_FILES["student-id-card"];

        if (str_ends_with($student_id_card["name"], ".jpg") || str_ends_with($student_id_card["name"], ".jpeg")) {
            $target_directory = "../img/student_id_cards/";
            $target_file = str_replace("/", "_", $student->matriculation_number) . ".jpg";

            move_uploaded_file($student_id_card["tmp_name"], $target_directory . $target_file);

            $update_query = "UPDATE students SET student_id_card_path = '$target_file'";
        } else {
            $student_id_card_error = "Student ID Card must be a JPEG image ending with the .jpg or .jpeg format suffix.";
        }
    }

    if (isset($_FILES["it-placement-letter"])) {
        $it_placement_letter = $_FILES["it-placement-letter"];

        if (!str_ends_with($it_placement_letter["name"], ".pdf")) {
            $it_placement_letter_error = "IT Placement Letter must be a PDF file.";
        } else {
            $target_directory = "../img/it_placement_letters/";
            $target_file = str_replace("/", "_", $student->matriculation_number) . ".pdf";

            move_uploaded_file($it_placement_letter["tmp_name"], $target_directory . $target_file);

            if (empty($update_query)) {
                $update_query = "UPDATE students SET it_placement_letter_path = '$target_file'";
            } else {
                $update_query .= ", it_placement_letter_path = '$target_file'";
            }
        }
    }

    $update_query .= " WHERE user_id = $student->user_id";

    if (empty($student_id_card_error) && empty($it_placement_letter_error)) {
        if ($database_connection->query($update_query)) {
            $alert = "<script>
                        if (confirm('You\'ve successfully uploaded your document.')) {";
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
