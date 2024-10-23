<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaserc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$country = $_SESSION['countryID'];
$subjects = $_SESSION['subjects'];

foreach ($subjects as $subjectName) {
    $fetchQuery = "SELECT SubjectID FROM subjects WHERE Subject = ?";
    $stmtFetch = $conn->prepare($fetchQuery);
    $stmtFetch->bind_param("s", $subjectName);
    $stmtFetch->execute();
    $stmtFetch->bind_result($subjectID);
    $stmtFetch->fetch();
    $stmtFetch->close();

    $updatesql = "UPDATE SET AnnualHours = ? WHERE CountryID = ? AND SubjectID = ? AND GradeID = ?";
    $updatestmt = $conn->prepare($updatesql);
    for ($i = $start; $i < $end; $i++) { 
        $updatestmt->bind_param("iiii", $annualHours[$subjectID][$i], $country, $subjectID, $gradeID);
        $updatestmt->execute();
    }
    $updatestmt->close();
}

$conn->close();
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>