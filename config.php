<?php
const DB_HOST = "localhost";
const DB_NAME = "siwes_placement_system";
const DB_USER = "root";
const DB_PASSWORD = "";

$database_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($database_connection->connect_error) {
    die("Connection failed: " . $database_connection->connect_error);
}
?>