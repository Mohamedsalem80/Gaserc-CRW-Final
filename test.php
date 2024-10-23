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

if (isset($_GET['country'])) {
    $_SESSION['country'] = $_GET['country'];
}

$country = $_SESSION['country'];

// Get the CountryID based on the country name
$countryIDQuery = "SELECT CountryID FROM Countries WHERE Country = ?";
$stmtCountryID = $conn->prepare($countryIDQuery);
$stmtCountryID->bind_param("s", $country);
$stmtCountryID->execute();
$stmtCountryID->bind_result($countryID);
$stmtCountryID->fetch();
$stmtCountryID->close();

// 1. Get all subjects for the specific country
$subjectsQuery = "
    SELECT 
        s.SubjectID, 
        s.Subject
    FROM 
        Subjects s
    JOIN 
        TeachingHours th ON s.SubjectID = th.SubjectID
    WHERE 
        th.CountryID = ?;
";

$stmtSubjects = $conn->prepare($subjectsQuery);
$stmtSubjects->bind_param("i", $countryID);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();

$subjects = [];
while ($row = $resultSubjects->fetch_assoc()) {
    $subjects[$row['SubjectID']] = $row['Subject'];
}
$stmtSubjects->close();

// 2. Get all teaching hours for each subject in the country
$teachingHoursQuery = "
    SELECT 
        th.SubjectID, 
        th.GradeID, 
        th.AnnualHours
    FROM 
        TeachingHours th
    WHERE 
        th.CountryID = ?;
";

$maximumHoursQuery = "
    SELECT 
        cd.Total, 
        cd.no_weeks, 
        cd.minutes
    FROM 
        CountriesData cd
    WHERE 
        cd.CountryID = ?;
";

$stmtMaximumHours = $conn->prepare($maximumHoursQuery);
$stmtMaximumHours->bind_param("i", $countryID);
$stmtMaximumHours->execute();
$stmtMaximumHours->bind_result($maxHours, $noWeeks, $minutesPerClass);
$stmtMaximumHours->fetch();
$stmtMaximumHours->close();

$stmtTeachingHours = $conn->prepare($teachingHoursQuery);
$stmtTeachingHours->bind_param("i", $countryID);
$stmtTeachingHours->execute();
$resultTeachingHours = $stmtTeachingHours->get_result();

$teachingHours = [];
while ($row = $resultTeachingHours->fetch_assoc()) {
    $teachingHours[$row['SubjectID']][$row['GradeID']] = $row['AnnualHours'];
}
$stmtTeachingHours->close();
$conn->close();

echo '<table>';
echo '<tr>
        <th>Subject Name</th>
        <th>Grade 1</th>
        <th>Grade 2</th>
        <th>Grade 3</th>
        <th>Grade 4</th>
        <th>Grade 5</th>
        <th>Grade 6</th>
        <th>Total</th>
        <th>percent</th>
      </tr>';

foreach ($teachingHours as $subjectID => $grades) {
    $subjectName = isset($subjects[$subjectID]) ? $subjects[$subjectID] : 'Unknown Subject';
    $totalTeachingHours = array_sum($grades);
    
    $percentage = $totalTeachingHours > 0 ? round(($totalTeachingHours / $maxHours) * 100, 0) . '%' : '0%';

    echo '<tr>';
    echo '<td class="subname">' . htmlspecialchars($subjectName) . '</td>';
    
    for ($grade = 1; $grade <= 6; $grade++) {
        $hours = isset($grades[$grade]) ? $grades[$grade] : 0;
        echo '<td class="numVal">' . htmlspecialchars($hours) . '</td>';
    }
    echo '<td class="numValt">' . $totalTeachingHours . '</td>';
    echo '<td class="numValp">' . $percentage . '</td>';
    echo '</tr>';
}

echo '</table>';
?>
