<?php

$Server="localhost";
$DatabaseName="nuvieliv_school_attendance";
$DatabaseUserID="nuvieliv_theresia";
$DatabasePasscode="peter@2002";

$conn = mysqli_connect($Server,$DatabaseUserID,$DatabasePasscode,$DatabaseName);

if (!$conn){
    die("<center>Well, That's Embarising... <br>We got a 500<br>Database error detected");
}

$sql = "SELECT * FROM `login` WHERE `user` LIKE '".filter_var($_POST["id"], FILTER_SANITIZE_SPECIAL_CHARS)."' AND `pass` LIKE '".filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS)."'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION["user"] = $row["user"];
    $_SESSION["subject"] = explode(',', $row["sub"]);
    $_SESSION["class"] = explode(',', $row["authorise"]);
    var_dump($_SESSION["class"]);
    header("location: ./attendance.php");
} else {
    header("location: ./index.php?err=true");
}