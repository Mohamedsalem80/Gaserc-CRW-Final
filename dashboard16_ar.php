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

if (!isset($_SESSION['userID']) || 
    !isset($_SESSION['job']) || 
    !isset($_SESSION['country']) || 
    !isset($_SESSION['stage']) || 
    !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$_SESSION['lang'] = 'ar';

$country = $_SESSION['country'];

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
        s.Subject_ar
    FROM 
        Subjects s
    JOIN 
        TeachingHours th ON s.SubjectID = th.SubjectID
    WHERE 
        th.CountryID = ?;
";

$_SESSION['countryID'] = $countryID;

$stmtSubjects = $conn->prepare($subjectsQuery);
$stmtSubjects->bind_param("i", $countryID);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();

$subjects = [];
while ($row = $resultSubjects->fetch_assoc()) {
    $subjects[$row['SubjectID']] = $row['Subject_ar'];
}
$stmtSubjects->close();

ksort($subjects);
$_SESSION['subjects'] = $subjects;

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
        cd.minutes,
        cd.Grade_1,
        cd.Grade_2,
        cd.Grade_3,
        cd.Grade_4,
        cd.Grade_5,
        cd.Grade_6,
        cd.Grade_7,
        cd.Grade_8,
        cd.Grade_9
    FROM 
        CountriesData cd
    WHERE 
        cd.CountryID = ?;
";

$stmtMaximumHours = $conn->prepare($maximumHoursQuery);
$stmtMaximumHours->bind_param("i", $countryID);
$stmtMaximumHours->execute();
$stmtMaximumHours->bind_result($maxHours, $noWeeks, $minutesPerClass, $Grade_1, $Grade_2, $Grade_3, $Grade_4, $Grade_5, $Grade_6, $Grade_7, $Grade_8, $Grade_9);
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
ksort($teachingHours);

/**
 * All countries data
 */

 $specificSubjects = [
    'Arabic Language',
    'English Language',
    'Mathematics',
    'Science',
    'Social Studies',
    'Islamic Education',
    'Physical Education'
];

// Initialize the dataset structure
$countryDatasets = [];

// Fetch all relevant subject IDs
$subjectIds = [];
$subjectQuery = "SELECT SubjectID, Subject_ar FROM Subjects WHERE Subject IN ('" . implode("', '", $specificSubjects) . "')";
$subjectResult = $conn->query($subjectQuery);

if ($subjectResult->num_rows > 0) {
    while ($subjectRow = $subjectResult->fetch_assoc()) {
        $subjectIds[$subjectRow['SubjectID']] = $subjectRow['Subject_ar'];
    }
}

// Initialize the array for each subject
foreach ($subjectIds as $subjectId => $subjectName) {
    $countryDatasets[$subjectId] = [
        'subject_name' => $subjectName,
        1 => [], // Grade 1
        2 => [], // Grade 2
        3 => [], // Grade 3
        4 => [], // Grade 4
        5 => [], // Grade 5
        6 => [], // Grade 6
    ];
}

// Fetch teaching hours for each subject across all countries and grades
foreach ($subjectIds as $subjectId => $subjectName) {
    $teachingHoursQuery = "
        SELECT th.GradeID, th.AnnualHours 
        FROM TeachingHours th
        JOIN CountriesData cd ON th.CountryID = cd.CountryID
        WHERE th.SubjectID = $subjectId
    ";

    $teachingHoursResult = $conn->query($teachingHoursQuery);

    if ($teachingHoursResult->num_rows > 0) {
        while ($teachingHoursRow = $teachingHoursResult->fetch_assoc()) {
            $gradeId = $teachingHoursRow['GradeID'];
            $annualHours = $teachingHoursRow['AnnualHours'];

            // Store the hours for each grade
            if (!isset($countryDatasets[$subjectId][$gradeId])) {
                $countryDatasets[$subjectId][$gradeId] = [];
            }
            // Append the annual hours to the respective grade
            $countryDatasets[$subjectId][$gradeId][] = $annualHours;
        }
    }
}

// Structure the final output to match the expected format
$finalOutput = [];
foreach ($countryDatasets as $subjectId => $data) {
    $subjectName = $data['subject_name'];
    foreach ($data as $grade => $hours) {
        if ($grade !== 'subject_name') { // Skip the subject name key
            if (!isset($finalOutput[$grade])) {
                $finalOutput[$grade] = [];
            }
            // Check if there are any teaching hours, otherwise use a default value
            if (!empty($hours)) {
                $finalOutput[$grade][$subjectName] = $hours;
            } else {
                $finalOutput[$grade][$subjectName] = 0; // or any default value
            }
        }
    }
}

/**
 * End all countries data
 */



$minvalues = [];
$maxvalues = [];
$averagevalues = [];

$sql = "SELECT SubjectID, MinH, MaxH, AvgH FROM SubjectsLimits WHERE GradeID = 1 AND SubjectID BETWEEN 1 AND 7";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $minvalues[] = $row['MinH'];
        $maxvalues[] = $row['MaxH'];
        $averagevalues[] = $row['AvgH'];
    }
}

$conn->close();
$_SESSION['yearlyHours'] = round($noWeeks * ($minutesPerClass/60));
$errMsg1 = $_SESSION['lang'] == 'en' ? "Please select a cell inside the inside planning table" : "من فضلك اختر خلية داخل جدول تحت التخطيط";
$errMsg2 = $_SESSION['lang'] == 'en' ? "This is the minimum hours for this subject" : "هذا هو الحد الأدنى من الساعات لهذه المادة";
$errMsg3 = $_SESSION['lang'] == 'en' ? "This is the maximum hours for this subject" : "هذا هو الحد الأقصى للساعات لهذه المادة";
$errMsg4 = $_SESSION['lang'] == 'en' ? "Please select a subject inside the under planning table" : "من فضلك اختر مادة داخل جدول تحت التخطيط";
$errMsg5 = $_SESSION['lang'] == 'en' ? "Are you sure you want to delete this subject?" : "هل أنت متأكد أنك تريد حذف هذه المادة";

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- SEO Meta description -->
<meta name="description" content="جهاز بحثي متخصص في التربية تأسس في عام 1979 ويتبع لمكتب التربية العربي لدول الخليج، ويتخذ من دولة الكويت مقرا له">

<meta name="keywords" content="مركز البحوث, مركز البحوث التربوية, مركز الأبحاث التربوية, فرع مكتب التربية الكويت">


<!-- Facebook -->
<meta property="og:site_name" content="Gaserc الكويت" />
<meta property=”og:title” content="Gaserc Kuwait" />
<meta property=”og:description” content="جهاز بحثي متخصص في التربية تأسس في عام 1979 ويتبع لمكتب التربية العربي لدول الخليج، ويتخذ من دولة الكويت مقرا له" />
<meta property="og:url" content="https://www.gaserc.com/" /> <!-- website link -->
<meta property="og:image" content="https://www.gaserc.org/uploads/logo/favicon-d4e7f8470e08e4c5a91a3456f7952863.png" />
<meta property=”og:type” content=”website” />
<!-- Twitter -->
<meta name=”twitter:title” content="Gaserc Kuwait" />
<meta property="twitter:card" content="">
<meta name=”twitter:description” content="جهاز بحثي متخصص في التربية تأسس في عام 1979 ويتبع لمكتب التربية العربي لدول الخليج، ويتخذ من دولة الكويت مقرا له" />
<meta name=”twitter:url” content="https://www.gaserc.com/" />


<meta name="Revisit-After" content="2 days">
<meta name="robots" content="all">
<meta name="distribution" content="Global">

<meta name="author" content="Gulfweb Web Design, Kuwait">
<meta name="Designer" content="Gulfweb Web Design Kuwait">
<meta name="Country" content="Kuwait">
<meta name="city" content="Kuwait City">
<meta name="Language" content="Arabic">
<meta name="Geography" content="">


<!--title-->
<title>Gaserc</title>
    <!-- Main Stylesheets -->
<link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/style.css?v-hash=0e3598a">


<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/6212ad085b.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Menu Source -->
<link href="https://www.gaserc.org/website_assets/assets/css/menu/desktop_menu.css?v-hash=0e3598a" rel="stylesheet" type="text/css" media="all" />
<link href="https://www.gaserc.org/website_assets/assets/css/menu/mobile_menu.css?v-hash=0e3598a" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://www.gaserc.org/website_assets/assets/css/menu/menu.js?v-hash=0e3598a"></script>

<!-- Slideshow Source -->
<link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/slider/owl.css?v-hash=0e3598a">
<link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/slider/style.css?v-hash=0e3598a">

<!-- Slick Slideshow -->
<!-- <link rel='stylesheet' href='slickslide/slick.min.css'> -->

<!-- slick source -->
<link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/slick/slick.css?v-hash=0e3598a">
<link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/slick/slick-theme.css?v-hash=0e3598a">
<link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/custom.css?v11?v-hash=0e3598a">

<!-- fav icon -->
<link rel="icon" href="https://www.gaserc.org/uploads/logo/favicon-d4e7f8470e08e4c5a91a3456f7952863.png?v-hash=0e3598a" type="image/png" sizes="16x16">

<!-- <script async="" src="//connect.facebook.net/en_US/fbds.js"></script> -->
<script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script>
        <!-- Modal (pop up) -->
	
		<!-- chartjs -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .custom-btn {
                border-radius: 30px;  /* Rounded corners */
                padding: 10px 20px;   /* More padding for a better feel */
                font-size: 16px;      /* Increase the font size */
                transition: background-color 0.3s, transform 0.3s;  /* Smooth transition for hover */
            }

            .custom-btn:hover {
                background-color: #0056b3;  /* Darken the color on hover */
                transform: scale(1.05);     /* Slightly enlarge the button on hover */
            }

            .custom-btn:active {
                transform: scale(0.98);     /* Shrink button when clicked */
            }

            .mx-2 {
                margin-left: 10px;
                margin-right: 10px;
            }
            .chart-container {
                position: relative;
                height: 400px;  /* Fixed height */
                width: 100%;    /* Responsive width */
            }

            canvas {
                display: block;
                width: 100% !important;  /* Ensure full width of the canvas */
                height: 100% !important; /* Ensure full height of the canvas */
            }
            .form-step {
                display: none !important;
            }

            .form-step.actived {
                display: block !important;
            }

            .stepper {
                position: relative;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 50px;
            }
    
            .step {
                width: 40px;
                height: 40px;
                line-height: 40px;
                background-color: #e9ecef;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                font-weight: bold;
                position: relative;
                z-index: 2;
                transition: background-color 0.3s, color 0.3s;
            }
    
            .step.actived {
                background-color: #0d6efd;
                color: white;
            }
    
            .step.completed {
                background-color: #198754;
                color: white;
            }
    
            .step:hover {
                background-color: #adb5bd;
                cursor: pointer;
            }
    
            .line {
                flex-grow: 1;
                height: 2px;
                background-color: #e9ecef;
                position: relative;
                z-index: 1;
            }
    
            .completed + .line,
            .actived + .line {
                background-color: #198754;
            }
    
            .actived + .line {
                background-color: #0d6efd;
            }
    
            .step:last-child + .line {
                display: none;
            }

            .custom-select {
                display: block;
                padding: 0.375rem 1.5rem 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                position: relative;
                background: none;
                background-position: right 0.75rem center;
                background-repeat: no-repeat;
                margin: 10px auto !important;
            }

            .custom-select::after {
                content: '';
                position: absolute;
                top: 50%;
                right: 0.75rem;
                width: 0;
                height: 0;
                margin-top: -3px;
                border-width: 6px 6px 0 6px;
                border-style: solid;
                border-color: #495057 transparent transparent transparent;
                pointer-events: none;
            }

            .custom-select:focus {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .custom-select:disabled {
                background-color: #e9ecef;
                opacity: 1;
            }

            .custom-select option {
                color: #000;
            }

            .prog-img {
                width: 100%;
                height: 333px;
            }
            .numVal {
                cursor: pointer;
            }
            .numVal.active {
                background-color: #8cdedf !important;
                border: 1px solid #aaa;
            }
            .numVal.clowLim {
                background-color: #ffffb4 !important;
            }
            .numVal.cHigLim {
                background-color: #ffc1c1 !important;
            }
            .numVal.lowLim {
                background-color: #ffff68 !important;
            }
            .numVal.HigLim {
                background-color: #ff8484 !important;
            }
            
            .numValp, .numValt {
                width: 75px;
            }
            .subname {
                width: 330px;
            }
            .subname.active {
                background-color: #92df8c !important;
            }
            .control_panel {
                width: 100%;
                padding: 6px;
                position: fixed;
                z-index: 5;
                color: #fff;
                background-color: #045184;
                bottom: 0;
                left: 0;
                direction: ltr;
                right: 0;
            }
            .panel_btn {
                position: absolute;
                top: -22px;
                padding: 4px;
                color: #fff;
                background-color: #094871;
                width: 48px;
                left: 0;
                text-align: center;
                height: 22px;
                display: flex;
                align-content: center;
                justify-content: center;
                align-items: center;
                border-radius: 1rem 1rem 0 0;
                transition: bottom 0.4s ease;
            }
            .panel_down {
                bottom: -<?php if (isset($_SESSION['job']) && $_SESSION['job'] != 1) { echo "86px"; } else { echo "54px"; } ?>;
            }
            table {
                border-collapse: collapse !important; /* Ensures no spacing between cells */
                border: none !important; /* Removes the table border */
            }
            
            th, td {
                border: 1px solid #eee !important;
                padding: 1.5rem !important;
                /* border-radius: 1rem !important; */
                background-color: #fff;
                text-align: center;
            }
            tbody td {
                background-color: #f6feff !important;
                color: #000;
            }
            tbody td:first-child {
                background-color: #f6fff8 !important;
                color: #000;
            }

            .images_holder {
                width: 100%;
                position: relative;
                padding: 10px;
                overflow: hidden;
            }

            .left {
                float: left;
            }

            .right {
                float: right;
            }

            .images_holder img {
                max-width: 100%;
                height: auto;
            }
        </style>
        
        <!-- Modal (pop up) -->
        <style>
            @media only screen and (max-width: 600px) {
                #homemodalbox .popup-img {
                    width: 96vw !important;
                    height: auto !important;
                }
            }

            .center {
                display: flex;
                align-content: center;
                justify-content: center;
                flex-direction: column;
            }

            .col-centered{
                margin: 0 auto;
                float: none;
            }

            .navigation-buttons {
                margin-top: 20px;
                padding: 0;
                justify-content: left;
                flex-direction: row !important;
            }

            .navigation-buttons button {
                width: 100px;
                margin-right: 10px;
                padding: 5px;
            }

            .next-step {
                color: #fff;
                border-radius: 0.5rem;
                transition: background 0.4s ease-in-out;
            }

            .prev-step {
                border-radius: 0.5rem;
            }

            #map-container {
            position: relative;
            overflow: hidden;
            width: 80%;
            height: 80%;
            border: 1px solid #fff;
            background-color: #fff;
            margin: 0px auto;
        }

        #map {
            width: 100%;
            height: 100%;
            transform-origin: center center;
            transition: transform 0.3s ease-in-out;
        }

        .tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px;
            border-radius: 3px;
            font-size: 12px;
            pointer-events: none;
            visibility: hidden;
            z-index: 10;
        }

        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        button {
            padding: 5px 10px;
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #666;
        }

        svg {
            background-color: #01171b;
        }
        
        svg path {
            fill: #00394f;
            stroke: #eee;
            stroke-width: 0.25;
            transition: 0.3s;
        }

        svg path:not(.red):hover {
            fill: #1890b8;
            cursor: pointer;
        }

        html body svg path.green {
            fill: #045184;
        }

        html body svg path.green:hover {
            fill: #1b75b0;
        }

        html body svg path.red {
            fill: navy;
        }
        </style>
    </head>
    <body>
	<script>
		document.querySelector('[data-target="#homemodalbox"]').click()
	</script>
        <header>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">مادة جديدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addSubForm" action="addsubject.php" method="POST">
                            <div class="form-group">
                                <label class="col-form-label">اسم المادة:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="subjectEnglishName" id="subject-name" placeholder="اسم المادة باللغة الانجليزية">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="subjectArabicName" id="subject-name" placeholder="اسم المادة باللغة العربية">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Grades 1-6 in a single row -->
                            <div class="form-group">
                                <label class="col-form-label">عدد الحصص الاسبوعية للصفوف 1-9:</label>
                                <div class="row">
                                    <div class="col-md-4  mb-1 mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 1" name="grade1">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 2" name="grade2">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 3" name="grade3">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 4" name="grade4">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 5" name="grade5">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 6" name="grade6">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 7" name="grade7">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 8" name="grade8">
                                    </div>
                                    <div class="col-md-4  mb-1">
                                        <input type="text" class="form-control" placeholder="الصف 9" name="grade9">
                                    </div>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label class="col-form-label">الاوزان النسبية للمواد الدراسية:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="minHours" placeholder="الحد الادنى">
                                    </div>
                                    <div class="col-md-4">
                                    <input type="text" class="form-control" name="maxHours" placeholder="الحد الاقصى">
                                    </div>
                                    <div class="col-md-4">
                                    <input type="text" class="form-control" name="avgHours" placeholder="الوزن النسبي">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلق</button>
                            <button type="submit" class="btn btn-primary">اضف المادة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	<div class="topline"></div>
	<div class="top_header">
		<!-- Logo -->
		<div class="container">
			<div class="d-flex align-items-center justify-content-between" style="flex-direction: row-reverse;">

									<div class="m_hide text-left" style="padding-left: 0;">
						<div class="d-flex align-items-center justify-content-end gap-4">

															<a class="formobile" href="https://www.gaserc.org/pdf/pdf2-48461d251794906fdedb2cc9f6f077fc.pdf" target="_blank"
									style="float:left;color: #fecb3e;text-decoration:none;"><span class=""
										style="color: #fecb3e;"><p style="line-height: 1.2;"><span style="font-family: almarai; color: rgb(35, 111, 161);"><strong>الدليل التعريفي بالمركز</strong></span></p></span></a>
														<form method="GET" action="https://gaserc.org/searchWebsite" class="d-flex justify-content-end">
								<input type="text" id="search" name="search_input" class="search_input"
									placeholder="بحث" style="height: fit-content"
									onblur="this.placeholder='بحث'" onfocus="this.placeholder=''">
								<button class="search_button" style="height: 37px"><i class="fa fa-search fa-lg"></i></button>

							</form>

							<span>
																											<a href="dashboard16.php"><img title="English" width="34px" height="38px"
												src="https://www.gaserc.org/admin_assets/assets/media/flags/260-united-kingdom.svg" alt="english"></a>
																								</span>
							<div
								class="kt-nav__item ">
							</div>
						</div>

					</div>
					<div class="">
						<a href="https://www.gaserc.org">
							<div class=""><img src="https://www.gaserc.org/uploads/logo/logo-bd7ce013407e32b04cf16127268086ba.png" alt="" title="logo"
									style="max-width: 500px" class="logo"></div>
						</a>
					</div>
				
			</div>
		</div>
	</div>

	<!-- Menu -->
	<div class="menu_bg">
		<div class="container">
			<ul id="nav" class="m_hide desk_show">
																					<li class="/"><a href="https://gaserc.org/"
								target="">الرئيسية</a>
						</li>
																				<li><a href="#">عن المركز</a>
							<ul>
																										<li><a href="https://gaserc.org/about/establishment-of-gaserc"
											target="">تعريف بالمركز</a>
									</li>
																										<li><a href="https://gaserc.org/council-of-trustees"
											target="">مجلس أمناء المركز</a>
									</li>
																										<li><a href="https://gaserc.org/about/partners"
											target="">مواقع صديقة</a>
									</li>
															</ul>
						</li>
																				<li><a href="#">البرامج</a>
							<ul>
																										<li><a href="https://gaserc.org/programs/current-projects"
											target="">برامج الدورة الحالية</a>
									</li>
																										<li><a href="https://gaserc.org/programs/projects-of-2021-2022"
											target="">برامج الدورة (2021-2022)</a>
									</li>
																										<li><a href="https://gaserc.org/programs/previous-projects"
											target="">برامج الدورات السابقة</a>
									</li>
															</ul>
						</li>
																				<li><a href="#">الفعاليات</a>
							<ul>
																										<li><a href="https://gaserc.org/news-events/1"
											target="">الندوات وورش العمل</a>
									</li>
																										<li><a href="https://gaserc.org/news-events/2"
											target="">المؤتمرات</a>
									</li>
																										<li><a href="https://gaserc.org/news-events/3"
											target="">المواسم الثقافية</a>
									</li>
																										<li><a href="https://gaserc.org/news-events/4"
											target="">الحلقات النقاشية</a>
									</li>
																										<li><a href="https://gaserc.org/news-events/5"
											target="">أخبار المركز</a>
									</li>
															</ul>
						</li>
																				<li><a href="#">الإصدارات</a>
							<ul>
																										<li><a href="https://gaserc.org/versions/study-and-research"
											target="">الدراسات والأبحاث</a>
									</li>
																										<li><a href="https://gaserc.org/versions/educational-future-magazine"
											target="">مجلة مستقبليات تربوية</a>
									</li>
															</ul>
						</li>
																				<li><a href="#">المكتبة</a>
							<ul>
																										<li><a href="https://gaserc.portal.medad.com/ar"
											target="_blank">فهرس المكتبة</a>
									</li>
																										<li><a href="https://gaserc.org/library/work-hours"
											target="">ساعات العمل</a>
									</li>
																										<li><a href="https://gaserc.portal.medad.com/ar/widget-listing/605"
											target="_blank">وصل حديثا</a>
									</li>
																										<li><a href="https://gaserc.org/library/ask-the-librarian"
											target="">اسأل المكتبي</a>
									</li>
															</ul>
						</li>
																										<li class="https://conf2024.gaserc.org/ar"><a href="https://conf2024.gaserc.org/ar"
								target="_blank">المؤتمر التربوي ٢٠٢٤</a>
						</li>
																										<li class="/announcement"><a href="https://gaserc.org/announcement"
								target="">كراسات للطرح</a>
						</li>
																										<li class="/contact-us"><a href="https://gaserc.org/contact-us"
								target="">تواصل معنا</a>
						</li>
									
			</ul>


			<!-- Mobile Menu -->
			<nav class="tab-bar desk_hide m_show">
				<div class="menu">
					<a href="#" class="slide-menu-open"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
					<div class="side-menu-overlay" style="width: 0px; opacity: 0;"></div>
					<div class="side-menu-wrapper">

						<a href="#" class="menu-close">&times;</a>
						<ul>
																																	<li style="border-right:none;" class="/"><a
											target=""
											href="https://gaserc.org/">الرئيسية</a></li>
																																<li><a href="javascript:;">عن المركز</a>
										<ul>
																																			<li><a href="https://gaserc.org/about/establishment-of-gaserc"
														target="">تعريف بالمركز</a>
												</li>
																																			<li><a href="https://gaserc.org/council-of-trustees"
														target="">مجلس أمناء المركز</a>
												</li>
																																			<li><a href="https://gaserc.org/about/partners"
														target="">مواقع صديقة</a>
												</li>
																					</ul>
									</li>
																																<li><a href="javascript:;">البرامج</a>
										<ul>
																																			<li><a href="https://gaserc.org/programs/current-projects"
														target="">برامج الدورة الحالية</a>
												</li>
																																			<li><a href="https://gaserc.org/programs/projects-of-2021-2022"
														target="">برامج الدورة (2021-2022)</a>
												</li>
																																			<li><a href="https://gaserc.org/programs/previous-projects"
														target="">برامج الدورات السابقة</a>
												</li>
																					</ul>
									</li>
																																<li><a href="javascript:;">الفعاليات</a>
										<ul>
																																			<li><a href="https://gaserc.org/news-events/1"
														target="">الندوات وورش العمل</a>
												</li>
																																			<li><a href="https://gaserc.org/news-events/2"
														target="">المؤتمرات</a>
												</li>
																																			<li><a href="https://gaserc.org/news-events/3"
														target="">المواسم الثقافية</a>
												</li>
																																			<li><a href="https://gaserc.org/news-events/4"
														target="">الحلقات النقاشية</a>
												</li>
																																			<li><a href="https://gaserc.org/news-events/5"
														target="">أخبار المركز</a>
												</li>
																					</ul>
									</li>
																																<li><a href="javascript:;">الإصدارات</a>
										<ul>
																																			<li><a href="https://gaserc.org/versions/study-and-research"
														target="">الدراسات والأبحاث</a>
												</li>
																																			<li><a href="https://gaserc.org/versions/educational-future-magazine"
														target="">مجلة مستقبليات تربوية</a>
												</li>
																					</ul>
									</li>
																																<li><a href="javascript:;">المكتبة</a>
										<ul>
																																			<li><a href="https://gaserc.portal.medad.com/ar"
														target="_blank">فهرس المكتبة</a>
												</li>
																																			<li><a href="https://gaserc.org/library/work-hours"
														target="">ساعات العمل</a>
												</li>
																																			<li><a href="https://gaserc.portal.medad.com/ar/widget-listing/605"
														target="_blank">وصل حديثا</a>
												</li>
																																			<li><a href="https://gaserc.org/library/ask-the-librarian"
														target="">اسأل المكتبي</a>
												</li>
																					</ul>
									</li>
																																									<li style="border-right:none;" class="https://conf2024.gaserc.org/ar"><a
											target="_blank"
											href="https://conf2024.gaserc.org/ar">المؤتمر التربوي ٢٠٢٤</a></li>
																																									<li style="border-right:none;" class="/announcement"><a
											target=""
											href="https://gaserc.org/announcement">كراسات للطرح</a></li>
																																									<li style="border-right:none;" class="/contact-us"><a
											target=""
											href="https://gaserc.org/contact-us">تواصل معنا</a></li>
															
																						<li><a href="https://www.gaserc.org/pdf/pdf2-48461d251794906fdedb2cc9f6f077fc.pdf" target="_blank"
										style="color: #fecb3e;text-decoration:none;"><span
											style="color: #fecb3e;"><p style="line-height: 1.2;"><span style="font-family: almarai; color: rgb(35, 111, 161);"><strong>الدليل التعريفي بالمركز</strong></span></p></span></a></li>
							

																								<li><a href="https://www.gaserc.org/locale/en">English</a></li>
																					</ul>
                        </div>
                    </div>
                </nav>
		    </div>
	    </div>
    </header>
        
    <!-- Slider -->
  <div class="container" style="padding:0;">
    <section class="main-slider" dir="ltr">
        <div class="slider-box">
            <!-- Banner Carousel -->
            <div class="banner-carousel owl-theme owl-carousel">

                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-4d6993a27fa3a9b2aebd3eec5995df60.jpeg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="https://gaserc.org/news-events/30-09-2024/read" target="_blank">
                                    <p class="slide_text">
                                        وزير التربية ووزير التعليم العالي والبحث العلمي في دولة الكويت يستقبل مدير المركز
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-809f5dcc1e4ea6a356108ed9b574ab42.jpeg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="http://gaserc.org/news-events/11-9-2024/read" target="_blank">
                                    <p class="slide_text">
                                        المركز يعقد ملتقى "تعزيز قيم التسامح وقبول الآخر في المؤسسات التعليمية" في مملكة البحرين
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-dbec7605181184046cacc365fb4cc136.png) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="https://gaserc.org/news-events/26-8-2024/read" target="_blank">
                                    <p class="slide_text">
                                        المركز يشارك في معرض الكتاب الصيفي السابع
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-ffdb9256804b428936012dbc3461c218.jpeg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="http://gaserc.org/news-events/02062024/read" target="_blank">
                                    <p class="slide_text">
                                        انعقاد اجتماع مجلس أمناء المركز العربي للبحوث التربوية لدول الخليج في دورته الدورة الثامنة والثلاثين
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-a307a2d5512b455b5fef660d476d4319.jpg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="https://gaserc.org/news-events/omanmeeting15may/read" target="_blank">
                                    <p class="slide_text">
                                        المركز العربي للبحوث التربوية لدول الخليج يعقد اجتماعا لمسؤولي المعلومات والإحصاءات التعليمية في وزارات التربية والتعليم بالدول الأعضاء، في مدينة مسقط، بسلطنة عمان.
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-ca1959754b4e07bc37fefa2ba9d4644f.jpeg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="https://gaserc.org/news-events/event1742024/read" target="_blank">
                                    <p class="slide_text">
                                        المركز العربي للبحوث التربوية لدول الخليج ينظم أمسية ثقافية بعنوان: "المشترك الثقافي بين دول الخليج".
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                                    <!-- Slide -->
                    <div class="slide">
                        <div class="image-layer"
                            style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-31b337e0a84c475b69a0bcd5154cd2b6.jpeg) ">
                        </div>
                        <div class="auto-container">
                            <div class="content m_hide">
                                <a href="https://gaserc.org/news-events/29-2-2024/read" target="_blank">
                                    <p class="slide_text">
                                        وفد أكاديمية الملكة رانيا  لتدريب المعلمين بالأردن يزور المركز
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                            </div>
        </div>
    </section>
</div>

    <!-- News&Events -->

    <section class="mtb-40 scroll-element">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-sm-12">
                    <!-- News Title -->
                    <div class="news_title">الاوزان النسبية</div>
                    <div class="title_line"></div>
                    <div class="title_dot"></div>
                    <div class="clear30x"></div>
                    <div class="control_panel panel_up">
                        <div class="panel_btn">
                            <i class="fa fa-arrow-down"></i>
                        </div>
                        <div class="container mt-2">
                            <div class="form-group row mb-1">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">
                                <?php
                                        if (isset($_SESSION['job']) && $_SESSION['job'] != 1) {
                                            echo "تعديل";
                                        } else {
                                            echo "الإجراءات";
                                        }
                                    ?>
                                </label>
                                <div class="col-sm-10">
                                    <?php
                                            if (isset($_SESSION['job']) && $_SESSION['job'] != 1) {
                                    ?>
                                    <button type="button" class="btn btn-danger" onclick="spinButton2SpinDown();" style="width: 32px;">-</button>
                                    <button type="button" class="btn btn-danger" onclick="spinButton2SpinUp();" style="width: 32px;">+</button>
                                    <button type="button" class="btn btn-secondary ml-5" onclick="ButtonToNeutraliseAnomalies_Click();" style="width: 180px;">تعويض</button>
                                    <?php
                                        }
                                    ?>
                                    <button type="button" class="btn btn-success" onclick="downloadPDF2();" style="width: 132px;">طباعة</button>
                                    <?php
                                        if (isset($_SESSION['job']) && $_SESSION['job'] != 1) {
                                    ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: 150px;">إضافة مادة</button>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                                if (isset($_SESSION['job']) && $_SESSION['job'] != 1) {
                            ?>
                            <div class="form-group row" style="margin-bottom: 0;">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">تعديل-تلقائي</label>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-primary" onclick="spinButton1SpinDown();" style="width: 32px;">-</button>
                                    <button type="button" class="btn btn-primary" onclick="spinButton1SpinUp();" style="width: 32px;">+</button>
                                    <button type="button" class="btn btn-warning ml-5" onclick="reset();" style="width: 180px;">إعادة تعيين</button>
                                    <button type="button" class="btn btn-success" onclick="publish();" style="width: 132px;">نشر</button>
                                    <button type="button" class="btn btn-danger" onclick="removeSub();" style="width: 150px;">إزالة مادة</button>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <form action="delete_subject.php" method="POST" id="rform">
                                <input type="hidden" name="subjectName" value="" id="rforminp">
                            </form>
                            <form action="update_teachinghours.php" method="POST" id="rform2">
                                <input type="hidden" name="start" value="1">
                                <input type="hidden" name="end" value="6">
                                <input type="hidden" name="values" value="" id="rforminp2">
                            </form>
                            <form id="pdfForm" action="generate_pdf.php" method="POST" target="_blank" style="display: none;">
                                <input type="hidden" name="start" value="1">
                                <input type="hidden" name="end" value="6">
                                <input type="hidden" name="subjects" id="subjectsField">
                                <input type="hidden" name="mainMatrix" id="mainMatrixField">
                                <input type="hidden" name="planningMatrix" id="planningMatrixField">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="images_holder">
                    <img src="./images/logo.png" width="100" id="country_flag" class="left">
                    <img src="./images/logo.png" width="400" class="right">
                </div>
                <div id="printable">
                    <div class="container mt-4">
                        <h1>
                            الرئيسي
                        </h1>
                        <div class="table-responsive">
                            <table class="table" id="IncrementPeriodsPerClick">
                                <tbody>
                                    <tr>
                                        <th>عدد الاسابيع</th>
                                        <td class="numVal" id="noWeeks"><?php echo $noWeeks; ?></td>
                                    </tr>
                                    <tr>
                                        <th>وقت الحصة (دقيقة)</th>
                                        <td class="numVal" id="classMints"><?php echo $minutesPerClass; ?></td>
                                    </tr>
                                    <tr>
                                        <th>ساعة / سنة</th>
                                        <td class="numVal" id="incrementPeriodsPerClick"><?php echo round($noWeeks * ($minutesPerClass/60)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" id="historicalTableHead">
                                <thead>
                                    <tr>
                                        <th style="width: 330px;">الصف</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th style="width: 75px;">كلي</th>
                                        <th style="width: 75px;">%</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="table" id="historicalTable">
                                <tbody>
                                <?php 
                                        foreach ($teachingHours as $subjectID => $grades) {
                                            // Get the subject name or set it to 'Unknown Subject' if not found
                                            $subjectName = isset($subjects[$subjectID]) ? $subjects[$subjectID] : 'Unknown Subject';
                                            
                                            // Calculate total teaching hours for grades 1 to 6
                                            $totalTeachingHours = 0;
                                            for ($grade = 1; $grade <= 6; $grade++) {
                                                $totalTeachingHours += isset($grades[$grade]) ? $grades[$grade] : 0;
                                            }
                                            
                                            // Calculate percentage based on maxHours for grades 1 to 6
                                            $percentage = $totalTeachingHours > 0 ? round(($totalTeachingHours / $maxHours) * 100, 0) . '%' : '0%';

                                            echo '<tr>';
                                            echo '<td class="subname">' . htmlspecialchars($subjectName) . '</td>';
                                            
                                            // Output hours for each grade from 1 to 6
                                            for ($grade = 1; $grade <= 6; $grade++) {
                                                $hours = isset($grades[$grade]) ? $grades[$grade] : 0;
                                                echo '<td class="numVal">' . htmlspecialchars($hours) . '</td>';
                                            }

                                            // Output the total hours and percentage for grades 1 to 6
                                            echo '<td class="numValt">' . $totalTeachingHours . '</td>';
                                            echo '<td class="numValp">' . $percentage . '</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <h1>
                            تحت التخطيط
                        </h1>
                        <div class="table-responsive">
                            <table class="table" id="HypotheticalTableHead">
                                <thead>
                                    <tr>
                                        <th style="width: 330px;">الصف</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th style="width: 75px;">كلي</th>
                                        <th style="width: 75px;">%</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="table" id="totalYearlyHours">
                                <tbody>
                                    <tr>
                                        <td style="width: 330px;">وقت التدريس الكلي</td>
                                        <td class="numVal"><?php echo $Grade_1; ?></td>
                                        <td class="numVal"><?php echo $Grade_2; ?></td>
                                        <td class="numVal"><?php echo $Grade_3; ?></td>
                                        <td class="numVal"><?php echo $Grade_4; ?></td>
                                        <td class="numVal"><?php echo $Grade_5; ?></td>
                                        <td class="numVal"><?php echo $Grade_6; ?></td>
                                        <td class="numValt" style="width: 75px;"><?php echo $Grade_1+$Grade_2+$Grade_3+$Grade_4+$Grade_5+$Grade_6; ?></td>
                                        <td class="numValp" style="width: 75px;">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" id="HypotheticalTable">
                                <tbody>
                                <?php 
                                        foreach ($teachingHours as $subjectID => $grades) {
                                            // Get the subject name or set it to 'Unknown Subject' if not found
                                            $subjectName = isset($subjects[$subjectID]) ? $subjects[$subjectID] : 'Unknown Subject';
                                            
                                            // Calculate total teaching hours for grades 1 to 6
                                            $totalTeachingHours = 0;
                                            for ($grade = 1; $grade <= 6; $grade++) {
                                                $totalTeachingHours += isset($grades[$grade]) ? $grades[$grade] : 0;
                                            }
                                            
                                            // Calculate percentage based on maxHours for grades 1 to 6
                                            $percentage = $totalTeachingHours > 0 ? round(($totalTeachingHours / $maxHours) * 100, 0) . '%' : '0%';

                                            echo '<tr>';
                                            echo '<td class="subname">' . htmlspecialchars($subjectName) . '</td>';
                                            
                                            // Output hours for each grade from 1 to 6
                                            for ($grade = 1; $grade <= 6; $grade++) {
                                                $hours = isset($grades[$grade]) ? $grades[$grade] : 0;
                                                echo '<td class="numVal">' . htmlspecialchars($hours) . '</td>';
                                            }

                                            // Output the total hours and percentage for grades 1 to 6
                                            echo '<td class="numValt">' . $totalTeachingHours . '</td>';
                                            echo '<td class="numValp">' . $percentage . '</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="container mt-5">
                    <h1>
                        التغييرات
                    </h1>
                    <div class="table-responsive">
                        <table class="table" id="changesHead">
                            <thead>
                                <tr>
                                    <th style="width: 330px;">الصف</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th style="width: 75px;">كلي</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table" id="ChangesTable">
                            <tbody>
                            <?php 
                                foreach ($teachingHours as $subjectID => $grades) {
                                    $subjectName = isset($subjects[$subjectID]) ? $subjects[$subjectID] : 'Unknown Subject';
                                    $totalTeachingHours = array_sum($grades);
                                    
                                    $percentage = $totalTeachingHours > 0 ? round(($totalTeachingHours / $maxHours) * 100, 0) . '%' : '0%';
                                
                                    echo '<tr>';
                                    echo '<td class="subname">' . htmlspecialchars($subjectName) . '</td>';
                                    
                                    for ($grade = 1; $grade <= 6; $grade++) {
                                        $hours = isset($grades[$grade]) ? $grades[$grade] : 0;
                                        echo '<td class="numVal">' . 0 . '</td>';
                                    }
                                    echo '<td class="numValt">' . 0 . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                        <table class="table" id="totalAnomaly">
                            <tbody>
                                <tr>
                                    <td style="width: 330px;">
                                        التغييرات الكلية
                                        <br>
                                        (قد تكون بسبب التقريبات)
                                    </td>
                                    <td class="numVal">0</td>
                                    <td class="numVal">0</td>
                                    <td class="numVal">0</td>
                                    <td class="numVal">0</td>
                                    <td class="numVal">0</td>
                                    <td class="numVal">0</td>
                                    <td class="numValt">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clear20x"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Pie Chart Column -->
                <div class="col-md-6">
                    <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 20px; direction: ltr;">
                        <button class="btn btn-primary custom-btn mx-2" id="btn0" onclick="updatePieChart(0)">1</button>
                        <button class="btn btn-primary custom-btn mx-2" id="btn1" onclick="updatePieChart(1)">2</button>
                        <button class="btn btn-primary custom-btn mx-2" id="btn2" onclick="updatePieChart(2)">3</button>
                        <button class="btn btn-primary custom-btn mx-2" id="btn3" onclick="updatePieChart(3)">4</button>
                        <button class="btn btn-primary custom-btn mx-2" id="btn4" onclick="updatePieChart(4)">5</button>
                        <button class="btn btn-primary custom-btn mx-2" id="btn5" onclick="updatePieChart(5)">6</button>
                    </div>
                </div>
        
                <!-- Bar Chart Column -->
                <div class="col-md-6">
                    <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        
            <!-- Full Width Pie Chart Row -->
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-12">
                    <div class="chart-container" style="position: relative; height: 600px; width: 70%; margin: 0 auto;">
                        <canvas id="fullWidthPieChart"></canvas>
                    </div>
                    <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 4px; direction: ltr;">
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('التربية الإسلامية')">التربية الإسلامية</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('اللغة العربية')">اللغة العربية</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('اللغة الإنجليزية')">اللغة الإنجليزية</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('الرياضيات')">الرياضيات </button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('العلوم')">العلوم </button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('الدراسات الاجتماعية')">الدراسات الاجتماعية</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('التربية البدنية')">التربية البدنية</button>
                    </div>
                    <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 4px; direction: ltr;">
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(1)">1</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(2)">2</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(3)">3</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(4)">4</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(5)">5</button>
                        <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(6)">6</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear30x"></div>
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <!-- Logout Button -->
                    <a href="logout.php" class="btn btn-danger btn-margin">تسجيل الخروج</a>
                    <!-- Follow Up Button -->
                    <a href="followup_ar.php" class="btn btn-primary">العودة للمتابعة</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Books -->
    <section class="gray_bg mb-40 scroll-element js-scroll fade-in-bottom"
        dir='rtl'>
        <div class="container">
            <div class="row justify-content-md-center">
                <!-- title -->

                <div class="title_contaner">
                    <div class="title_line2"></div>
                    <div class="title_dot2"></div>
                    <div class="act_title">أحدث الإصدارات</div>
                    <div class="title_dot3"></div>
                    <div class="clear"></div>
                </div>
                <div class="table_bg">

                    <div class="col-lg-10 col-md-10 col-sm-12 ml-96" >
                        <div class="responsive" style="margin: 0rem 2rem;">
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/magazines/b-36fa780582c08a89d77a9fdb71e7a888.jpg" alt="">
                                                                        <p>المهارات الناعمة ومستقبل التعليم وا...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/161'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/magazines/b-f5417f092c52652b43b8f6b7d8be7716.jpg" alt="">
                                                                        <p>التعليم من أجل التنمية المستدامة</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/160'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/magazines/b-bc90617545110e79aec7a1fef61bf9e9.jpg" alt="">
                                                                        <p>الذكاء الاصطناعي في التعليم: الوعود...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/157'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/magazines/b-9458b1bb57f215d3210d986feb9273d9.jpg" alt="">
                                                                        <p>مهارات القراءة الرقمية</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/154'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/studies_and_research/b-37d0376364f84c8eb5f767760aa296cb.jpeg"
                                            alt="المشترك الثقافي بين الدول الأعضاء بمكتب التربية العربي لدول الخليج"  height="500px">
                                                                        <p>المشترك الثقافي بين الدول الأعضاء ب...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/studies-and-research/details/156'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/studies_and_research/b-485992b8567fd34f6b69f84bfc1b3469.jpeg"
                                            alt="توعية الطلبة بقيم التسامح وقبول الآخر: دليل مرجعي‬"  height="500px">
                                                                        <p>توعية الطلبة بقيم التسامح وقبول الآ...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/studies-and-research/details/158'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/studies_and_research/b-20bdb7077abc437c3c4b821137ead7af.jpg"
                                            alt="معايير إدارة برامج مكتب التربية العربي لدول الخليج ومشروعاته"  height="500px">
                                                                        <p>معايير إدارة برامج مكتب التربية الع...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/studies-and-research/details/159'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/studies_and_research/b-9f0a53fa6dc69a8e7364eb5b8800e6fa.jpeg"
                                            alt="التعلم المدمج"  height="500px">
                                                                        <p>التعلم المدمج</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/studies-and-research/details/155'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/magazines/b-f6f5e5b46b2206e323d7e82512b3703c.jpg" alt="">
                                                                        <p>الصحة النفسية للطلبة: هدف أساسي للت...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/153'">المزيد</button>
                                </div>
                                                                                            <div class="my_slide">
                                                                            <img src="https://www.gaserc.org/uploads/studies_and_research/b-42c431729fcc68823425c09d235eb170.jpg"
                                            alt="معجم لغوي لمؤلفي كتب الأطفال : فئة الأعمار 3-12"  height="500px">
                                                                        <p>معجم لغوي لمؤلفي كتب الأطفال : فئة...</p>
                                    <button
                                        onClick="location.href='https://www.gaserc.org/studies-and-research/details/151'">المزيد</button>
                                </div>
                                                    </div>
                    </div>


                    <div class="clear40x"></div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p class="text-center"><button
                                onClick="location.href='https://www.gaserc.org/versions/educational-future-magazine'"
                                class="view_all">مجلة مستقبليات تربوية</button></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p class="text-center"><button
                                onClick="location.href='https://www.gaserc.org/versions/study-and-research'"
                                class="view_all">أحدث الدراسات</button></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities -->
    <section class="scroll-element js-scroll fade-in-bottom mb-50">
        <div class="container">
            <div class="row">
                <!-- title -->
                <div class="title_contaner">
                    <div class="title_line2"></div>
                    <div class="title_dot2"></div>
                    <div class="act_title">نشاطات المركز</div>
                    <div class="title_dot3"></div>
                    <div class="clear"></div>
                </div>
                <!-- Card -->
                <div class="col-3 col-md-3 col-sm-6"><a href="https://www.gaserc.org/news-events/1">
                        <div class="act_bg"><img src="https://www.gaserc.org/website_assets/assets/images/video_ico.png"
                                alt="">
                            <p>الندوات وورش العمل</p>
                        </div>
                    </a></div>
                <div class="col-3 col-md-3 col-sm-6"><a href="https://www.gaserc.org/news-events/2">
                        <div class="act_bg"><img src="https://www.gaserc.org/website_assets/assets/images/study_ico.png"
                                alt="">
                            <p>المؤتمرات</p>
                        </div>
                    </a></div>

                <div class="col-3 col-md-3 col-sm-6"><a href="https://www.gaserc.org/news-events/3">
                        <div class="act_bg"><img src="https://www.gaserc.org/website_assets/assets/images/speach_ico.png"
                                alt="">
                            <p>المواسم الثقافية</p>
                        </div>
                    </a></div>
                <div class="col-3 col-md-3 col-sm-6"><a href="https://www.gaserc.org/news-events/4">
                        <div class="act_bg"><img src="https://www.gaserc.org/website_assets/assets/images/meeting_ico.png"
                                alt="">
                            <p>الحلقات النقاشية</p>
                        </div>
                    </a></div>
            </div>
        </div>
    </section>
    <!-- Footer -->
<footer class="scroll-element js-scroll fade-in-bottom">
	<div class="footer_op">
		<div class="container">
			<div class="row">
				<!-- Card -->
				<div class="col-4 col-md-4 col-sm-6">
					<p class="footer_title">اتصل بنا
					<p>
						<img width="320px" src="https://www.gaserc.org/website_assets/assets/images/footer_logo.png" alt="" />
					<ul class="address">
						<li><i class="fas fa-map-marked-alt"></i>
							شارع يوسف ابراهيم الغانم ، قطعة 3 ، الشامية ، الكويت
12580 - الشامية 71656</li>
						<li><i class="fas fa-paper-plane"></i> <a href="mailto:registration@gaserc.org"
								target="_blank">registration@gaserc.org</a></li>
						<li><i class="fas fa-phone-alt right"></i>
							<div dir="ltr" class="phone">+965 24830428, +965 24830499 ,+965 24832677 </div>
						</li>
						<div class="clear"></div>
						<li><i class="fas fa-fax right"></i>
							<div dir="ltr" class="phone"> +965 24830571</div>
						</li>
					</ul>

					<div class="clear30x"></div>
					<ul class="social_links">
						<li><a href="https://www.facebook.com/GASERCKUWAIT/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a></li>
						<li><a href="https://twitter.com/gaserckuwait" target="_blank"><i class="fab fa-twitter fa-lg"></i></a></li>
						<li><a href="https://www.youtube.com/@gaserckuwait" target="_blank"><i class="fab fa-youtube fa-lg"></i></a></li>
						<li><a href="https://www.instagram.com/GASERCKUWAIT/" target="_blank"><i class="fab fa-instagram fa-lg"></i></a></li>
					</ul>
					<div class="clear"></div>
				</div>

				<!-- Card -->
				<div class="col-4 col-md-4 col-sm-6">
					<p class="footer_title">روابط قصيرة
					<p>
					<ul class="footer_links">
						                            															<li><a href="/">الرئيسية</a></li>
																				                            																																									<li><a href="/about/establishment-of-gaserc">تعريف بالمركز</a></li>
																																				<li><a href="council-of-trustees">مجلس أمناء المركز</a></li>
																																															                            																				                            																				                            																				                            																				                            															<li><a href="https://conf2024.gaserc.org/ar">المؤتمر التربوي ٢٠٢٤</a></li>
																				                            															<li><a href="/announcement">كراسات للطرح</a></li>
																				                                                            <li><a href="https://portal.gaserc.org/">بوابة الموظف</a></li>
                            															<li><a href="/contact-us">تواصل معنا</a></li>
																									</ul>
				</div>


				<!-- Card -->
				<div class="col-4 col-md-4 col-sm-6">
					<p class="footer_title">النشرة البريدية
					<p>
					<form method="POST" action="https://gaserc.org/newsletter/email">
						<input type="hidden" name="_token" value="mrC4zTH5w46ndqPje2ADEv4NH4AP3vMaKxVLBqBI" autocomplete="off">						<input type="text" name="name" placeholder="أدخل اسمك"
							onblur="this.placeholder='أدخل اسمك'"
							onfocus="this.placeholder='أدخل اسمك'" class="news_letter news_letter_width">
						<input type="email" name="email" placeholder="أدخل بريدك الإلكتروني"
							onblur="this.placeholder='أدخل بريدك الإلكتروني'"
							onfocus="this.placeholder='أدخل بريدك الإلكتروني'" class="news_letter">
						<button class="news_button"><i class="fas fa-paper-plane fa-lg"></i></button>
						<div class="col-12">
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="6LeMueQUAAAAAJ-ZUe9ZqGK3pma9VwbeoaYDgJte">
								</div>
															</div>
						</div>
					</form>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</footer>



<!-- Copyright -->
<div class="copyright">
	جميع الحقوق محفوظة © للمركز العربي للبحوث التربوية لدول الخليج - الكويت 2023
	<br />
	مركز CARDI، جامعة حلوان، القاهرة، مصر.
</div>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <!--slick js-->
        <script type="text/javascript" charset="utf-8" src="https://www.gaserc.org/website_assets/assets/js/slick/slick.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/owl.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/custom.js?v-hash=936708f"></script>
        <script type="text/javascript">
            $(document).on('ready', function() {
                const _URL_img = document.getElementById("country_flag");
                const _URL_country = <?php echo json_encode($_SESSION['country']); ?>;
                _URL_img.src = `./images/Flag_of_${_URL_country.replaceAll(" ", "_")}.png`;
                $('.responsive').slick({
                    dots: false,
                    infinite: false,
                    rtl: false,
                    speed: 300,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        }
                    }, {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                    ]
                });

            });
        </script>
        <script id="rendered-js">
            const scrollElements = document.querySelectorAll(".js-scroll");

            const elementInView = (el,dividend=1)=>{
                const elementTop = el.getBoundingClientRect().top;

                return (elementTop <= (window.innerHeight || document.documentElement.clientHeight) / dividend);

            }
            ;

            const elementOutofView = el=>{
                const elementTop = el.getBoundingClientRect().top;

                return (elementTop > (window.innerHeight || document.documentElement.clientHeight));

            }
            ;

            const displayScrollElement = element=>{
                element.classList.add("scrolled");
            }
            ;

            const hideScrollElement = element=>{
                element.classList.remove("scrolled");
            }
            ;

            const handleScrollAnimation = ()=>{
                scrollElements.forEach(el=>{
                    if (elementInView(el, 1.25)) {
                        displayScrollElement(el);
                    } else if (elementOutofView(el)) {
                        hideScrollElement(el);
                    }
                }
                );
            }
            ;

            window.addEventListener("scroll", ()=>{
                handleScrollAnimation();
            }
            );
            //# sourceURL=pen.js
            $("#alert-msg").slideUp(2000);
            $('ul.nav').on('click', 'li', function(e) {
                e.preventDefault();
                let idSel = $(e.target).attr('href');
                $('.tab-content').hide();
                $(idSel).show();
                $('ul.nav li').removeClass('active');
                $(e.target).closest('li').addClass('active');
            })

            $('.accordion-header').on('click', function(event) {
                let target = $(this)
                if (target.next('.accordion-collapse.show').length > 0) {
                    return target.next('.accordion-collapse.show').slideUp().removeClass('show')
                }
                target.closest('.accordion').find('.accordion-collapse.show').slideUp().removeClass('show')
                target.next('.accordion-collapse:not(.show)').slideDown().addClass('show')

            })
        </script>
        <!--captcha-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-213489498-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-213489498-1');
        </script>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-H4339YK1ZB"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-H4339YK1ZB');
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
            let specificSubjects = [
                'Arabic Language',
                'English Language',
                'Mathematics',
                'Science',
                'Social Studies',
                'Islamic Education',
                'Physical Education'
            ];
            function extendArray(arr, desiredLength, fillValue = 0) {
                if (arr.length < desiredLength) {
                    arr.length = desiredLength;
                    arr.fill(fillValue, arr.length - (desiredLength - arr.length));
                }
                return arr;
            }

            var totalSchoolYears = 6;
            var totalSchoolSubjects = <?php echo count($subjects) ?>;
            var HistoricalHours = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
            var HistoricalHoursMin = Array.from({ length: totalSchoolSubjects }).fill(0);
            var HistoricalHoursMax = Array.from({ length: totalSchoolSubjects }).fill(0);
            var HITV = document.querySelectorAll("#historicalTable .numVal");
            var indx = 0;
            var indxv = 0;
            for (let i = 0; i < totalSchoolSubjects; i++) {
                for (let j = 0; j < totalSchoolYears; j++) {
                    indxv = parseInt(HITV[indx++].innerText);
                    HistoricalHours[i][j] = indxv;
                    // HistoricalHoursMax[i][j] = (indxv + 87);
                    // HistoricalHoursMin[i][j] = ((indxv - 87) > 0 ) ? (indxv - 87) : 0;
                }
            }
            HistoricalHoursMin = <?php echo json_encode($minvalues); ?>;
            HistoricalHoursMin = extendArray(HistoricalHoursMin, totalSchoolSubjects);
            HistoricalHoursMax = <?php echo json_encode($maxvalues); ?>;
            HistoricalHoursMax = extendArray(HistoricalHoursMax, totalSchoolSubjects, <?php echo $maxHours; ?>);
            var AnomaliesEachYear = [0, 0, 0, 0, 0, 0]; 
            var DesiredTotInstrucTimeEachYear = [<?php echo $Grade_1; ?>,
                                                 <?php echo $Grade_2; ?>,
                                                 <?php echo $Grade_3; ?>,
                                                 <?php echo $Grade_4; ?>,
                                                 <?php echo $Grade_5; ?>,
                                                 <?php echo $Grade_6; ?>];
            var HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);
            var HypotheticalHours = HypotheticalWeeklyPeriods;
            var totals = [<?php echo $Grade_1; ?>,
                          <?php echo $Grade_2; ?>,
                          <?php echo $Grade_3; ?>,
                          <?php echo $Grade_4; ?>,
                          <?php echo $Grade_5; ?>,
                          <?php echo $Grade_6; ?>]; 
            var totals_c = <?php echo $Grade_1+$Grade_2+$Grade_3+$Grade_4+$Grade_5+$Grade_6; ?>;
            var diff = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));

            var errMsg1 = "<?php echo $errMsg1; ?>";
            var errMsg2 = "<?php echo $errMsg2; ?>";
            var errMsg3 = "<?php echo $errMsg3; ?>";
            var errMsg4 = "<?php echo $errMsg4; ?>";
            var errMsg5 = "<?php echo $errMsg5; ?>";
        </script>
        <script src="./js/extra-script-16.js"></script>
        <script>
            var pyear = 1;
            var psubject = 'التربية الإسلامية';
            function updateCountryPieChart(country) {
                psubject = country;
                fullWidthPieChart.data.datasets[0].data = countryDatasets[pyear][country]; // Update data
                fullWidthPieChart.update(); // Re-render the chart
            }

            function setPYear(num) {
                pyear = num;
                fullWidthPieChart.data.datasets[0].data = countryDatasets[num][psubject]; // Update data
                fullWidthPieChart.update(); // Re-render the chart
            }
            // Pie chart datasets
            let pieDatasets = [
                [12, 19, 3, 5, 2, 3, 1, 5],
                [8, 12, 6, 10, 4, 9, 2, 4],
                [10, 7, 12, 4, 5, 6, 3, 6],
                [9, 5, 2, 18, 7, 3, 4, 3],
                [15, 8, 9, 5, 13, 4, 5, 7],
                [5, 6, 10, 8, 12, 15, 6, 1]
            ];
            let transh = transposeMatrix(HypotheticalHours);
            for (let i = 0; i < 6; i++) {
                for (let j = 0; j < 8; j++) {
                    pieDatasets[i][j] = transh[i][j];
                }
            }
            let sublabels = <?php echo json_encode(array_values($subjects)); ?>;

            // Pie chart configuration
            let pieChart = new Chart(document.getElementById('pieChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: sublabels,
                    datasets: [{
                        data: pieDatasets[0],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',   // 1st color
                            'rgba(54, 162, 235, 0.8)',   // 2nd color
                            'rgba(255, 206, 86, 0.8)',    // 3rd color
                            'rgba(75, 192, 192, 0.8)',    // 4th color
                            'rgba(153, 102, 255, 0.8)',   // 5th color
                            'rgba(255, 159, 64, 0.8)',    // 6th color
                            'rgba(255, 99, 71, 0.8)',     // 7th color (Tomato)
                            'rgba(75, 0, 130, 0.8)'       // 8th color (Indigo)
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',   // 1st color
                            'rgba(54, 162, 235, 1)',   // 2nd color
                            'rgba(255, 206, 86, 1)',    // 3rd color
                            'rgba(75, 192, 192, 1)',    // 4th color
                            'rgba(153, 102, 255, 1)',   // 5th color
                            'rgba(255, 159, 64, 1)',    // 6th color
                            'rgba(255, 99, 71, 1)',     // 7th color (Tomato)
                            'rgba(75, 0, 130, 1)'       // 8th color (Indigo)
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true  // Keep it responsive
                }
            });

            // Bar chart configuration (with horizontal bars)
            let barChart = new Chart(document.getElementById('barChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['الصف 1', 'الصف 2', 'الصف 3', 'الصف 4', 'الصف 5', 'الصف 6'],
                    datasets: [{
                        label: 'التغييرات',
                        data: [0, 0, 0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',   // 1st color
                            'rgba(54, 162, 235, 0.8)',   // 2nd color
                            'rgba(255, 206, 86, 0.8)',    // 3rd color
                            'rgba(75, 192, 192, 0.8)',    // 4th color
                            'rgba(153, 102, 255, 0.8)',   // 5th color
                            'rgba(255, 159, 64, 0.8)',    // 6th color
                            'rgba(255, 99, 71, 0.8)',     // 7th color (Tomato)
                            'rgba(75, 0, 130, 0.8)'       // 8th color (Indigo)
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',   // 1st color
                            'rgba(54, 162, 235, 1)',   // 2nd color
                            'rgba(255, 206, 86, 1)',    // 3rd color
                            'rgba(75, 192, 192, 1)',    // 4th color
                            'rgba(153, 102, 255, 1)',   // 5th color
                            'rgba(255, 159, 64, 1)',    // 6th color
                            'rgba(255, 99, 71, 1)',     // 7th color (Tomato)
                            'rgba(75, 0, 130, 1)'       // 8th color (Indigo)
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,  // Keep it responsive
                    indexAxis: 'y',    // Horizontal bar chart
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            function updateBarChart() {
                barChart.data.datasets[0].data = AnomaliesEachYear;
                barChart.update();
            }

            // Function to update pie chart datasets
            function updatePieChart(index) {
                let transh = transposeMatrix(HypotheticalHours);
                for (let i = 0; i < 6; i++) {
                    for (let j = 0; j < 8; j++) {
                        pieDatasets[i][j] = transh[i][j];
                    }
                }
                pieChart.data.datasets[0].data = pieDatasets[index];
                pieChart.update();
            }

            let countryDatasets = {
                1: {
                    "التربية الإسلامية": [12, 18, 25, 30, 50, 70, 80],
                    "اللغة العربية": [14, 23, 37, 45, 55, 65, 75],
                    "اللغة الإنجليزية": [22, 29, 33, 48, 55, 60, 73],
                    "الرياضيات": [10, 15, 35, 45, 52, 64, 76],
                    "العلوم": [25, 32, 41, 50, 65, 70, 80],
                    "الدراسات الاجتماعية": [18, 28, 35, 42, 59, 68, 72],
                    "التربية البدنية والصحية": [5, 15, 25, 35, 55, 63, 75],
                    "الفنون": [15, 11, 5, 13, 15, 16, 17]
                },
                2: {
                    "التربية الإسلامية": [14, 20, 30, 35, 55, 72, 82],
                    "اللغة العربية": [16, 26, 40, 50, 60, 68, 78],
                    "اللغة الإنجليزية": [24, 31, 36, 50, 58, 63, 75],
                    "الرياضيات": [12, 17, 37, 47, 55, 66, 78],
                    "العلوم": [27, 34, 44, 53, 68, 73, 83],
                    "الدراسات الاجتماعية": [20, 30, 38, 45, 62, 71, 74],
                    "التربية البدنية والصحية": [7, 17, 27, 37, 58, 65, 77],
                    "الفنون": [16, 13, 7, 15, 17, 18, 19]
                },
                3: {
                    "التربية الإسلامية": [13, 19, 28, 32, 52, 71, 81],
                    "اللغة العربية": [15, 25, 38, 47, 57, 66, 77],
                    "اللغة الإنجليزية": [23, 30, 34, 49, 57, 62, 74],
                    "الرياضيات": [11, 16, 36, 46, 54, 65, 77],
                    "العلوم": [26, 33, 43, 52, 67, 72, 82],
                    "الدراسات الاجتماعية": [19, 29, 37, 44, 61, 70, 73],
                    "التربية البدنية والصحية": [6, 16, 26, 36, 57, 64, 76],
                    "الفنون": [15, 12, 6, 14, 16, 17, 18]
                },
                4: {
                    "التربية الإسلامية": [11, 17, 27, 31, 51, 69, 79],
                    "اللغة العربية": [13, 22, 36, 44, 54, 64, 74],
                    "اللغة الإنجليزية": [21, 28, 32, 47, 54, 59, 72],
                    "الرياضيات": [9, 14, 34, 44, 51, 63, 75],
                    "العلوم": [24, 31, 40, 49, 64, 69, 79],
                    "الدراسات الاجتماعية": [17, 27, 34, 41, 58, 67, 71],
                    "التربية البدنية والصحية": [4, 14, 24, 34, 54, 61, 74],
                    "الفنون": [14, 10, 4, 12, 14, 15, 16]
                },
                5: {
                    "التربية الإسلامية": [16, 22, 32, 37, 57, 74, 84],
                    "اللغة العربية": [18, 28, 42, 52, 62, 70, 80],
                    "اللغة الإنجليزية": [26, 33, 38, 52, 60, 65, 77],
                    "الرياضيات": [14, 19, 39, 49, 57, 69, 81],
                    "العلوم": [29, 36, 46, 55, 70, 75, 85],
                    "الدراسات الاجتماعية": [22, 32, 40, 47, 64, 73, 76],
                    "التربية البدنية والصحية": [9, 19, 29, 39, 60, 67, 79],
                    "الفنون": [18, 15, 9, 17, 19, 20, 21]
                },
                6: {
                    "التربية الإسلامية": [17, 23, 33, 38, 58, 75, 85],
                    "اللغة العربية": [19, 29, 43, 53, 63, 71, 81],
                    "اللغة الإنجليزية": [27, 34, 39, 53, 61, 66, 78],
                    "الرياضيات": [15, 20, 40, 50, 58, 70, 82],
                    "العلوم": [30, 37, 47, 56, 71, 76, 86],
                    "الدراسات الاجتماعية": [23, 33, 41, 48, 65, 74, 77],
                    "التربية البدنية والصحية": [10, 20, 30, 40, 61, 68, 80],
                    "الفنون": [19, 16, 10, 18, 20, 21, 22]
                }
            };

            countryDatasets = <?php echo json_encode($finalOutput); ?>;

            // Labels for the country datasets (same for all)
            const countryLabels = [
                'الامارات',
                'البحرين',
                'السعودية',
                'عمان',
                'قطر',
                'الكويت', 
                'اليمن'
            ];

            const colors = [
                'rgba(255, 99, 132, 0.8)',   // 1st color
                'rgba(54, 162, 235, 0.8)',   // 2nd color
                'rgba(255, 206, 86, 0.8)',    // 3rd color
                'rgba(75, 192, 192, 0.8)',    // 4th color
                'rgba(153, 102, 255, 0.8)',   // 5th color
                'rgba(255, 159, 64, 0.8)',    // 6th color
                'rgba(255, 99, 71, 0.8)',     // 7th color (Tomato)
                'rgba(75, 0, 130, 0.8)'       // 8th color (Indigo)
            ];

            // Create full-width pie chart
            let fullWidthPieChart = new Chart(document.getElementById('fullWidthPieChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: countryLabels,
                    datasets: [{
                        data: countryDatasets[pyear][psubject].slice(0, 6), // Default dataset
                        backgroundColor: colors,  // Reuse the color array
                        borderColor: colors.map(color => color.replace(/0.8/, '1')), // Reuse the border colors
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
            function updateCountryPieChart(subject) {
                psubject = subject;
                fullWidthPieChart.data.datasets[0].data = countryDatasets[pyear][subject].slice(0, 6); // Update data
                fullWidthPieChart.update(); // Re-render the chart
            }

            function setPYear(num) {
                pyear = num;
                fullWidthPieChart.data.datasets[0].data = countryDatasets[num][psubject].slice(0, 6); // Update data
                fullWidthPieChart.update(); // Re-render the chart
            }
        </script>            
    </body>
</html>