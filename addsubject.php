<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaserc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$subjectEnglishName = $_POST['subjectEnglishName'];
$subjectArabicName = $_POST['subjectArabicName'];

$grades = [
    1 => $_POST['grade1'],
    2 => $_POST['grade2'],
    3 => $_POST['grade3'],
    4 => $_POST['grade4'],
    5 => $_POST['grade5'],
    6 => $_POST['grade6'],
    7 => $_POST['grade7'],
    8 => $_POST['grade8'],
    9 => $_POST['grade9'],
];

$minHours = $_POST['minHours'];
$maxHours = $_POST['maxHours'];
$avgHours = $_POST['avgHours'];

$country = $_SESSION['countryID'];

// Insert into the Subjects table
$insertSubjectQuery = "INSERT INTO Subjects (Subject, Subject_ar) VALUES (?, ?)";
$stmtSubject = $conn->prepare($insertSubjectQuery);
$stmtSubject->bind_param("ss", $subjectEnglishName, $subjectArabicName);

if ($stmtSubject->execute()) {
    $subjectID = $conn->insert_id; // Get the ID of the newly inserted subject

    // Prepare TeachingHours insert statement
    $insertTeachingHoursQuery = "INSERT INTO TeachingHours (CountryID, SubjectID, GradeID, AnnualHours) VALUES (?, ?, ?, ?)";
    $stmtTeachingHours = $conn->prepare($insertTeachingHoursQuery);

    // Loop through grades 1 to 9
    foreach ($grades as $gradeID => $annualHours) {
        // Define the annual hours variable to bind by reference
        $annualHoursRef = $annualHours; // Create a separate variable for binding
        $stmtTeachingHours->bind_param("iiii", $country, $subjectID, $gradeID, $annualHoursRef);
        
        // Execute TeachingHours insert
        if (!$stmtTeachingHours->execute()) {
            echo "Error inserting teaching hours for Grade $gradeID: " . $stmtTeachingHours->error;
        }
    }

    // Insert into SubjectsLimits for Grade 1 and Grade 7 only
    $insertLimitsQuery = "INSERT INTO SubjectsLimits (SubjectID, GradeID, MinH, MaxH, AvgH) VALUES (?, ?, ?, ?, ?)";
    $stmtLimits = $conn->prepare($insertLimitsQuery);

    // Insert limits for Grade 1
    $grade1 = 1;
    $grade7 = 7;
    $stmtLimits->bind_param("iiiii", $subjectID, $grade1, $minHours, $maxHours, $avgHours);
    if (!$stmtLimits->execute()) {
        echo "Error inserting limits for Grade 1: " . $stmtLimits->error;
    }

    // Insert limits for Grade 7
    $stmtLimits->bind_param("iiiii", $subjectID, $grade7, $minHours, $maxHours, $avgHours);
    if (!$stmtLimits->execute()) {
        echo "Error inserting limits for Grade 7: " . $stmtLimits->error;
    }

    // Close prepared statements
    $stmtLimits->close();
    $stmtTeachingHours->close();
    $stmtSubject->close();

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Error inserting subject: " . $stmtSubject->error;
}

$conn->close();
?>