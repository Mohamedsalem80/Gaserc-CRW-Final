<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaserc";

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();
$country = $_SESSION['countryID'];
$subjects = $_SESSION['subjects'];

// Retrieve the annual hours and start/end from the POST request
$annualHours = $_POST['annualHours'];
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0; // Default to 0 if not set
$end = isset($_POST['end']) ? (int)$_POST['end'] : 6; // Default to 6 if not set

// Check if annualHours is an array
if (!is_array($annualHours)) {
    echo json_encode(['success' => false, 'message' => 'Invalid annual hours data.']);
    exit();
}

// Loop through each subject
foreach ($subjects as $index => $subjectName) {
    // Fetch the Subject ID based on the subject name
    $fetchQuery = "SELECT SubjectID FROM subjects WHERE Subject = ?";
    $stmtFetch = $conn->prepare($fetchQuery);
    $stmtFetch->bind_param("s", $subjectName);
    $stmtFetch->execute();
    $stmtFetch->bind_result($subjectID);
    $stmtFetch->fetch();
    $stmtFetch->close();

    // Check if the subject ID was found
    if (!$subjectID) {
        echo json_encode(['success' => false, 'message' => 'Subject not found: ' . $subjectName]);
        continue; // Skip to the next subject if not found
    }

    // Loop through each grade based on the provided start and end
    for ($gradeID = $start; $gradeID < $end; $gradeID++) {
        // Prepare the update SQL query
        $updatesql = "UPDATE TeachingHours SET AnnualHours = ? WHERE CountryID = ? AND SubjectID = ? AND GradeID = ?";
        $updatestmt = $conn->prepare($updatesql);

        // Check if the statement was prepared successfully
        if (!$updatestmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
            exit;
        }

        // Get the annual hours for the current subject and grade
        $annualHour = $annualHours[$index][$gradeID - 1]; // Access based on the 0-based index

        // Bind parameters and execute the update
        $updatestmt->bind_param("iiii", $annualHour, $country, $subjectID, $gradeID); // gradeID + 1 to match your 1-based ID
        if (!$updatestmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error updating AnnualHours: ' . $updatestmt->error]);
            exit; // Exit if there's an error
        }

        // Close the update statement
        $updatestmt->close();
    }
}

// Close the database connection
$conn->close();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>