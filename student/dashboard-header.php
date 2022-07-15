<?php
require_once "../entities.php";

session_start();

if (!isset($_SESSION["matriculation-number"])) {
    $login_url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/login.php";
    header("Location: " . $login_url);
}

$student = new Student($database_connection, $_SESSION["matriculation-number"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $page_title?> | SIWES Placement</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="../lib/font-awesome.all.min.css" rel="stylesheet">
    <link href="../lib/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-xxl bg-white p-0">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="../index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
            <h1 class="m-0 text-primary">SIWES Placement</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Dashboard</a>
                <a href="find-placement.php" class="nav-item nav-link">Find Placement<i class="fa fa-search text-primary ms-1"></i></a>
                <a href="placement-requests.php" class="nav-item nav-link">Placement Requests<i class="fa fa-mail-bulk text-primary ms-1"></i></a>
                <a href="update-profile.php" class="nav-item nav-link">Update Profile<i class="fa fa-user text-primary ms-1"></i></a>
                <a href="logout.php" class="nav-item nav-link">Logout<i class="fa fa-user-slash text-primary ms-1"></i></a>
            </div>
    </nav>
    <!-- Navbar End -->
