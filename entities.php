<?php
date_default_timezone_set("Africa/Lagos");
require_once("config.php");

class Student {
    public int $user_id;
    public string $matriculation_number;
    public string $password;
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public string $email_address;
    public string $phone_number;
    public string $date_of_birth;
    public string $address;
    public State $state_of_origin;
    public string $institution;
    public Department $department;
    public ?string $it_placement_letter_path;
    public ?string $student_id_card_path;
    public string $gender;

    function __construct(mysqli $database_connection = null, string $matriculation_number = "", string $password = "") {
        if (isset($database_connection)) {
            $matriculation_number = cleanse_data($matriculation_number, $database_connection);
            $password = cleanse_data($password, $database_connection);

            $query = "SELECT * FROM students s
                        INNER JOIN departments d on s.department_id = d.department_id
                        INNER JOIN states s2 on s.state_id = s2.state_id
                        WHERE matriculation_number = '$matriculation_number'";

            $query .= ($password != "") ? " AND password = SHA('$password')" : "";

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->user_id = $row["user_id"];
                $this->matriculation_number = $row["matriculation_number"];
                $this->password = $row["password"];
                $this->first_name = $row["first_name"];
                $this->middle_name = $row["middle_name"];
                $this->last_name = $row["last_name"];
                $this->email_address = $row["email_address"];
                $this->phone_number = $row["phone_number"];
                $this->date_of_birth = $row["date_of_birth"];
                $this->address = $row["address"];
                $this->state_of_origin = new State($database_connection, $row["state_id"]);
                $this->institution = $row["institution"];
                $this->department = new Department($database_connection, $row["department_id"]);
                $this->it_placement_letter_path = $row["it_placement_letter_path"];
                $this->student_id_card_path = $row["student_id_card_path"];
                $this->gender = $row["gender"];
            }
        }
    }

    function is_found(): bool {
        return isset($this->matriculation_number);
    }

    public function get_full_name() {
        return strtoupper($this->last_name) . " $this->first_name $this->middle_name";
    }

    public function get_gender() {
        switch ($this->gender) {
            case 'M':
                return "Male";
            case 'F':
                return "Female";
        }
    }

    function is_male(): bool {
        return $this->gender == "Male";
    }

    function is_female(): bool {
        return $this->gender == "Female";
    }

    function get_date_of_birth(): string {
        return convert_date_to_readable_form($this->date_of_birth);
    }

    function get_student_id_card(): ?string {
        if ($this->is_student_id_card_submitted()) {
            return "../img/student_id_cards/$this->student_id_card_path";
        }

        return null;
    }

    function get_it_placement_letter(): ?string {
        if ($this->is_it_placement_letter_submitted()) {
            return "../img/it_placement_letters/$this->it_placement_letter_path";
        }

        return null;
    }

    function is_student_id_card_submitted(): bool {
        return isset($this->student_id_card_path);
    }

    function is_it_placement_letter_submitted(): bool {
        return isset($this->it_placement_letter_path);
    }

    /**
     * @param mysqli $database_connection
     * @return Student[]
     */
    public static function get_students(mysqli $database_connection): iterable {
        $students = array();

        $query = "SELECT * FROM students s
                        INNER JOIN departments d on s.department_id = d.department_id
                        INNER JOIN states s2 on s.state_id = s2.state_id";

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_student = new Student();

                $current_student->user_id = $row["user_id"];
                $current_student->matriculation_number = $row["matriculation_number"];
                $current_student->password = $row["password"];
                $current_student->first_name = $row["first_name"];
                $current_student->middle_name = $row["middle_name"];
                $current_student->last_name = $row["last_name"];
                $current_student->email_address = $row["email_address"];
                $current_student->phone_number = $row["phone_number"];
                $current_student->date_of_birth = $row["date_of_birth"];
                $current_student->address = $row["address"];
                $current_student->state_of_origin = new State($database_connection, $row["state_id"]);
                $current_student->institution = $row["institution"];
                $current_student->department = new Department($database_connection, $row["department_id"]);
                $current_student->it_placement_letter_path = $row["it_placement_letter_path"];
                $current_student->student_id_card_path = $row["student_id_card_path"];

                switch ($row["gender"]) {
                    case 'M':
                        $current_student->gender = "Male";
                        break;
                    case 'F':
                        $current_student->gender = "Female";
                        break;
                }

                array_push($students, $current_student);
            }
        }

        return $students;
    }
}

class Organisation {
    public int $organisation_id;
    public string $email_address;
    public string $organisation_name;
    public string $address;
    public string $description;
    public string $phone_number;
    public string $logo_path;
    public string $password;

    function __construct(mysqli $database_connection = null, string $email_address = "", string $password = "") {
        if (isset($database_connection)) {
            $email_address = cleanse_data($email_address, $database_connection);
            $password = cleanse_data($password, $database_connection);

            $query = "SELECT * FROM organisations
                        WHERE email_address = '$email_address'";

            $query .= ($password != "") ? " AND password = SHA('$password')" : "";

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->organisation_id = $row["organisation_id"];
                $this->email_address = $row["email_address"];
                $this->organisation_name = $row["organisation_name"];
                $this->address = $row["address"];
                $this->description = $row["description"];
                $this->phone_number = $row["phone_number"];
                $this->logo_path = $row["logo_path"];
                $this->password = $row["password"];
            }
        }
    }

    function is_found(): bool {
        return isset($this->email_address);
    }

    function get_logo(): string {
        return "../img/organisation_logos/$this->logo_path";
    }

    public function display_description() {
        echo "<ul class='list-unstyled'>";
        $split_description_lines = explode("\n", $this->description);

        foreach ($split_description_lines as $line) {
            echo "<li class='mb-2'><i class='fa fa-angle-right text-primary me-2'></i>$line</li>";
        }

        echo "</ul>";
    }

    /**
     * @param mysqli $database_connection
     * @return Organisation[]
     */
    public static function get_organisations(mysqli $database_connection): iterable {
        $organisations = array();

        $query = "SELECT * FROM organisations";

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_organisation = new Organisation();

                $current_organisation->organisation_id = $row["organisation_id"];
                $current_organisation->email_address = $row["email_address"];
                $current_organisation->organisation_name = $row["organisation_name"];
                $current_organisation->address = $row["address"];
                $current_organisation->description = $row["description"];
                $current_organisation->phone_number = $row["phone_number"];
                $current_organisation->logo_path = $row["logo_path"];
                $current_organisation->password = $row["password"];

                array_push($organisations, $current_organisation);
            }
        }

        return $organisations;
    }
}

class State {
    public int $state_id;
    public string $state_name;

    function __construct(mysqli $database_connection = null, int $state_id = 0) {
        if (isset($database_connection)) {
            $state_id = cleanse_data($state_id, $database_connection);

            $query = "SELECT * FROM states WHERE state_id = $state_id";

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->state_id = $row["state_id"];
                $this->state_name = $row["state_name"];
            }
        }
    }

    /**
     * @param mysqli $database_connection
     * @return State[]
     */
    public static function get_states(mysqli $database_connection): iterable {
        $states = array();

        $query = "SELECT * FROM states";

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_state = new State();

                $current_state->state_id = $row["state_id"];
                $current_state->state_name = $row["state_name"];

                array_push($states, $current_state);
            }
        }

        return $states;
    }
}

class Department {
    public int $department_id;
    public string $department_name;
    public string $college;

    function __construct(mysqli $database_connection = null, int $department_id = 0) {
        if (isset($database_connection)) {
            $department_id = cleanse_data($department_id, $database_connection);

            $query = "SELECT * FROM departments WHERE department_id = $department_id";

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->department_id = $row["department_id"];
                $this->department_name = $row["department_name"];
                $this->college = $row["college"];
            }
        }
    }

    /**
     * @param mysqli $database_connection
     * @return Department[]
     */
    public static function get_departments(mysqli $database_connection, string $college = ""): iterable {
        $college = cleanse_data($college, $database_connection);

        $departments = array();

        $query = "SELECT * FROM departments";

        if ($college != "") {
            $query .= " WHERE college = '$college' ORDER BY department_id";
        }

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_department = new Department();

                $current_department->department_id = $row["department_id"];
                $current_department->department_name = $row["department_name"];
                $current_department->college = $row["college"];

                array_push($departments, $current_department);
            }
        }

        return $departments;
    }
}

class PlacementOffer {
    public int $placement_offer_id;
    public Organisation $organisation;
    public Department $department;
    public int $number_of_students;
    public ?float $salary;
    public bool $is_placement_full;
    public string $placement_reference;

    function __construct(mysqli $database_connection = null, int $placement_offer_id = 0) {
        if (isset($database_connection)) {
            $placement_offer_id = cleanse_data($placement_offer_id, $database_connection);

            $query = "SELECT * FROM placement_offers p 
                        INNER JOIN organisations o on p.organisation_id = o.organisation_id
                        WHERE placement_offer_id = $placement_offer_id";

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->placement_offer_id = $row["placement_offer_id"];
                $this->organisation = new Organisation($database_connection, $row["email_address"]);
                $this->department = new Department($database_connection, $row["department_id"]);
                $this->number_of_students = $row["number_of_students"];
                $this->salary = $row["salary"];
                $this->is_placement_full = $row["is_placement_full"];
                $this->placement_reference = $row["placement_reference"];
            }
        }
    }

    public function is_found(): bool {
        return isset($this->placement_offer_id);
    }

    public function is_salary_offered(): bool {
        return $this->salary != null;
    }

    public function get_salary(): ?string {
        if ($this->is_salary_offered()) {
            return "&#8358;" . number_format($this->salary, 2);
        }

        return null;
    }

    public function display_departments(mysqli $database_connection) {
        $placement_offers = PlacementOffer::get_placement_offers($database_connection, $this->placement_reference,
            is_placement_full: false);

        echo "<ul class='list-unstyled'>";
        foreach ($placement_offers as $current_placement_offer) {
            $number_of_students_allowed = $current_placement_offer->calculate_number_of_students_allowed($database_connection);

            $department_detail = "<li><i class='fa fa-angle-right text-primary me-2'></i>" .
                $current_placement_offer->department->department_name;

            $department_detail .= " - $number_of_students_allowed" . (($number_of_students_allowed == 1) ? " student" :
                    " students") . " allowed";

            $department_detail .= "</li>";

            echo $department_detail;
        }

        echo "</ul>";
    }

    public function calculate_number_of_students_allowed(mysqli $database_connection): int {
        $placement_requests = PlacementRequest::get_placement_requests($database_connection, $this->placement_offer_id,
            status: "Approved");

        $number_of_placement_requests = count($placement_requests);

        return $this->number_of_students - $number_of_placement_requests;
    }

    /**
     * @param mysqli $database_connection
     * @return PlacementOffer[]
     */
    public static function get_placement_offers(mysqli $database_connection, string $placement_reference = "",
                                                string $department = "", bool $is_placement_full = null): iterable {
        $placement_offers = array();

        $query = "SELECT * FROM placement_offers p     
                    INNER JOIN organisations o on p.organisation_id = o.organisation_id
                    INNER JOIN departments d on p.department_id = d.department_id";

        if (!empty($placement_reference)) {
            $query .= " WHERE placement_reference = '$placement_reference'";

            if (!empty($department)) {
                $query .= " AND d.department_name = '$department'";
            }

            if (isset($is_placement_full)) {
                $is_placement_full = ($is_placement_full) ? "true" : "false";

                $query .= " AND is_placement_full = $is_placement_full";
            }
        } else if (!empty($department)) {
            $query .= " WHERE d.department_name = '$department'";

            if (isset($is_placement_full)) {
                $is_placement_full = ($is_placement_full) ? "true" : "false";

                $query .= " AND is_placement_full = $is_placement_full";
            }
        } else if (isset($is_placement_full)) {
            $is_placement_full = ($is_placement_full) ? "true" : "false";

            $query .= " WHERE is_placement_full = $is_placement_full";
        }

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_placement_offer = new PlacementOffer();

                $current_placement_offer->placement_offer_id = $row["placement_offer_id"];
                $current_placement_offer->organisation = new Organisation($database_connection, $row["email_address"]);
                $current_placement_offer->department = new Department($database_connection, $row["department_id"]);
                $current_placement_offer->number_of_students = $row["number_of_students"];
                $current_placement_offer->salary = $row["salary"];
                $current_placement_offer->is_placement_full = $row["is_placement_full"];
                $current_placement_offer->placement_reference = $row["placement_reference"];

                array_push($placement_offers, $current_placement_offer);
            }
        }

        return $placement_offers;
    }

    /**
     * @param PlacementOffer[] $placement_offers
     * @return PlacementOffer[]
     */
    public static function get_distinct_placement_offers(array $placement_offers): iterable {
        $distinct_placement_offers = array();

        foreach ($placement_offers as $current_placement_offer) {
            $is_placement_offer_already_distinct = false;

            foreach ($distinct_placement_offers as $current_distinct_order) {
                if ($current_placement_offer->placement_reference == $current_distinct_order->placement_reference) {
                    $is_placement_offer_already_distinct = true;
                }
            }

            if (!$is_placement_offer_already_distinct) {
                array_push($distinct_placement_offers, $current_placement_offer);
            }
        }

        return $distinct_placement_offers;
    }
}

class PlacementRequest {
    public int $placement_request_id;
    public Student $student;
    public PlacementOffer $placement_offer;
    public string $status;
    public ?string $acceptance_date;

    function __construct(mysqli $database_connection = null, int $placement_offer_id = 0, string $matriculation_number = "",
                            int $organisation_id = 0) {
        if (isset($database_connection)) {
            $placement_offer_id = cleanse_data($placement_offer_id, $database_connection);

            $query = "SELECT * FROM placement_requests p
                        INNER JOIN students s on p.student_id = s.user_id
                        INNER JOIN placement_offers po on p.placement_offer_id = po.placement_offer_id
                        WHERE p.placement_offer_id = $placement_offer_id";

            if (!empty($matriculation_number)) {
                $query .= " AND matriculation_number = '$matriculation_number'";
            }

            if ($organisation_id != 0) {
                $query .= " AND p.organisation_id = $organisation_id";
            }

            $result = $database_connection->query($query);

            if ($result->num_rows) {
                $row = $result->fetch_assoc();

                $this->placement_request_id = $row["placement_offer_id"];
                $this->student = new Student($database_connection, $row["student_id"]);
                $this->placement_offer = new PlacementOffer($database_connection, $row["placement_offer_id"]);
                $this->status = $row["status"];
                $this->acceptance_date = $row["acceptance_date"];
            }
        }
    }

    public function is_found(): bool {
        return isset($this->placement_request_id);
    }

    public function is_pending(): bool {
        return $this->status == "Pending";
    }

    public function is_accepted(): bool {
        return $this->status == "Accepted";
    }

    public function is_rejected(): bool {
        return $this->status == "Rejected";
    }

    public function get_acceptance_date(): ?string {
        if ($this->acceptance_date != null) {
            return convert_date_to_readable_form($this->acceptance_date);
        }

        return null;
    }

    /**
     * @param mysqli $database_connection
     * @return PlacementRequest[]
     */
    public static function get_placement_requests(mysqli $database_connection, int $placement_offer_id = 0,
                                                  string $matriculation_number = "", int $organisation_id = 0, string $status = ""): iterable {
        $placement_requests = array();

        $query = "SELECT * FROM placement_requests p
                    INNER JOIN students s on p.student_id = s.user_id
                    INNER JOIN placement_offers po on p.placement_offer_id = po.placement_offer_id";

        if ($placement_offer_id != 0) {
            $query .= " WHERE p.placement_offer_id = $placement_offer_id";

            if (!empty($matriculation_number)) {
                $query .= " AND matriculation_number = '$matriculation_number'";
            }

            if ($organisation_id != 0) {
                $query .= " AND p.organisation_id = $organisation_id";
            }

            if (!empty($status)) {
                $query .= " AND status = '$status'";;
            }
        } else if (!empty($matriculation_number)) {
            $query .= " WHERE matriculation_number = '$matriculation_number'";

            if ($organisation_id != 0) {
                $query .= " AND p.organisation_id = $organisation_id";
            }

            if (!empty($status)) {
                $query .= " AND status = '$status'";;
            }
        } else if ($organisation_id != 0) {
            $query .= " WHERE p.organisation_id = $organisation_id";

            if (!empty($status)) {
                $query .= " AND status = '$status'";;
            }
        } else if (!empty($status)) {
            $query .= " WHERE status = '$status'";;
        }

        $result = $database_connection->query($query);

        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $current_placement_request = new PlacementRequest();

                $current_placement_request->placement_request_id = $row["placement_offer_id"];
                $current_placement_request->student = new Student($database_connection, $row["student_id"]);
                $current_placement_request->placement_offer = new PlacementOffer($database_connection, $row["placement_offer_id"]);
                $current_placement_request->status = $row["status"];
                $current_placement_request->acceptance_date = $row["acceptance_date"];

                array_push($placement_requests, $current_placement_request);
            }
        }

        return $placement_requests;
    }
}

function cleanse_data(string $data, mysqli $database_connection): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return mysqli_escape_string($database_connection, $data);
}

function is_detail_filled(string $detail): bool {
    return strlen($detail) > 0;
}

function is_matriculation_number_valid(string $matriculation_number): bool {
    $matriculation_number_regex = "/CO[S|T]\/[0-9]{4}\/20[0-9]{2}/";

    return preg_match($matriculation_number_regex, $matriculation_number);
}

function is_date_of_birth_valid(string $date_of_birth): bool {
    $minimum_valid_date_of_birth = "1940-01-01";
    $maximum_valid_date_of_birth = "2006-12-31";

    return ($date_of_birth >= $minimum_valid_date_of_birth) && ($date_of_birth <= $maximum_valid_date_of_birth);
}

function is_email_address_valid(string $email_address): bool {
    $email_regex = "/^[A-Za-z0-9+_.-]+@(.+\..+)$/";

    return preg_match($email_regex, $email_address);
}

function is_phone_number_valid(string $phone_number): bool {
    $phone_number_regex = "/0[7-9][0-1]\d{8}/";

    return preg_match($phone_number_regex, $phone_number);
}

function is_password_valid(string $password): bool {
    $lowercase_regex = "/[a-z]/";
    $uppercase_regex = "/[A-Z]/";
    $digit_regex = "/[0-9]/";

    return preg_match($lowercase_regex, $password) && preg_match($uppercase_regex, $password)
        && preg_match($digit_regex, $password) && strlen($password) >= 8;
}

function is_password_confirmed(string $password, string $password_confirmer): bool{
    return $password == $password_confirmer;
}

function is_textarea_filled(string $text_area_text): bool {
    $text_area_regex = "/[a-zA-Z0-9]+/";

    return preg_match($text_area_regex, $text_area_text);
}

function convert_date_to_readable_form(string $reverse_date): string {
    $reverse_date_regex = "/(\d{4})-(\d{2})-(\d{2})/";

    preg_match($reverse_date_regex, $reverse_date, $match_groups);

    $year = $match_groups[1];
    $month = $match_groups[2];
    $day = $match_groups[3];

    $month = get_month($month);

    return $month . " " . $day . ", " . $year;
}

function get_month(int $month_number): string {
    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
        "November", "December"];

    return $months[$month_number - 1];
}

/**
 * @param mysqli $database_connection
 * @return bool
 */
function is_matriculation_number_in_use(mysqli $database_connection): bool {
    $is_matriculation_number_in_use = false;

    $student = new Student($database_connection, $_POST["matriculation-number"]);

    if ($student->is_found()) {
        $is_matriculation_number_in_use = true;
    }

    return $is_matriculation_number_in_use;
}
?>