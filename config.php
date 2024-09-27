<?php

$localhost = "localhost";
$user = "root";
$password = "";
$dbname = "bookshop";

$conn = new mysqli($localhost, $user, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}