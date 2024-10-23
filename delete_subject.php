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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectName = $_POST['subjectName'];

    // Fetch the Subject ID based on the subject name
    $fetchQuery = "SELECT SubjectID FROM subjects WHERE Subject = ?";
    $stmtFetch = $conn->prepare($fetchQuery);
    $stmtFetch->bind_param("s", $subjectName);
    $stmtFetch->execute();
    $stmtFetch->bind_result($subjectID);
    $stmtFetch->fetch();
    $stmtFetch->close();

    if (!$subjectID) {
        echo json_encode(['success' => false, 'message' => 'Subject not found.']);
        exit;
    }

    // Prepare delete queries
    $deleteTeachingHoursQuery = "DELETE FROM teachinghours WHERE CountryID = ? AND SubjectID = ?";
    $stmtTeachingHours = $conn->prepare($deleteTeachingHoursQuery);
    $stmtTeachingHours->bind_param("ii", $country, $subjectID);

    $deleteLimitsQuery = "DELETE FROM subjectslimits WHERE SubjectID = ?";
    $stmtLimits = $conn->prepare($deleteLimitsQuery);
    $stmtLimits->bind_param("i", $subjectID);

    $deleteQuery = "DELETE FROM subjects WHERE SubjectID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $subjectID);

    // Debugging information
    error_log("Deleting SubjectID: $subjectID for CountryID: $country");

    // Execute delete operations
    if ($stmtTeachingHours->execute() && $stmtLimits->execute() && $stmt->execute()) {
        $response = ['success' => true, 'message' => 'Subject deleted successfully.'];
    } else {
        // Debugging information
        $errorMessage = 'Error deleting subject: ';
        $errorMessage .= $stmt->error . ' | ';
        $errorMessage .= $stmtTeachingHours->error . ' | ';
        $errorMessage .= $stmtLimits->error;
        $response = ['success' => false, 'message' => $errorMessage];
    }

    error_log("JSON Response: " . json_encode($response)); // Log the response
    echo json_encode($response);

    // Close statements
    $stmt->close();
    $stmtTeachingHours->close();
    $stmtLimits->close();
}

$conn->close();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();

?>