<?php

session_start(); // Start the session
$error = '';
// Set the default language
$_SESSION['lang'] = 'en';
// Generate CSRF token if not set
if (empty($_SESSION['ms_csrf_token'])) {
    $_SESSION['ms_csrf_token'] = bin2hex(random_bytes(32));
}

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    $lang = ($_SESSION['lang'] == 'en') ? '' : '_ar';
	if (!isset($_SESSION['stage'])) {
		header("Location: followup{$lang}.php");
        exit();
	}
    $dashboard = ($_SESSION['stage'] == 1) ? 'dashboard16' : 'dashboard79';
    header("Location: {$dashboard}{$lang}.php");
    exit();
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionToken = $_SESSION['ms_csrf_token'] ?? '';
    $formToken = $_POST['ms_csrf_token'] ?? '';
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if the CSRF token is valid
    if ($sessionToken == $formToken) {
        unset($_SESSION['ms_csrf_token']); // Prevent token reuse

        // Validate email and password
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $dbpassword = "";
            $dbname = "gaserc";

            // Connect to the database
            $conn = new mysqli($servername, $username, $dbpassword, $dbname);

            // Check database connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL statement
            $stmt = $conn->prepare("SELECT userID, password, jobID FROM users WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            // Check if the user exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userID, $hashedPassword, $jobID);
                $stmt->fetch();

                // Verify the password
                $password = hash('sha256', $password);

                if ($password == $hashedPassword) {
                    // Set session variables upon successful login
                    $_SESSION['email'] = $email;
                    $_SESSION['userID'] = $userID;
                    $_SESSION['job'] = $jobID;

                    // Redirect the user to the dashboard
                    header("Location: followup.php");
                    exit();
                } else {
                    $error = "Invalid Password.";
                }
            } else {
                $error = "No account found with that email address.";
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid CSRF token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- SEO Meta description -->
        <meta name="description" content="Gulf Arab States Educational Center">
        <meta name="keywords" content="gaserc,kuwait,kw,q8,library">
        <!-- Facebook -->
        <meta property="og:site_name" content="Gaserc Kuwait"/>
        <meta property=”og:title” content="Gaserc Kuwait"/>
        <meta property=”og:description” content="Gulf Arab States Educational Center"/>
        <meta property="og:url" content="https://www.gaserc.com/"/>
        <!-- website link -->
        <meta property="og:image" content="https://www.gaserc.org/uploads/logo/favicon-d4e7f8470e08e4c5a91a3456f7952863.png"/>
        <meta property=”og:type” content=”website”/>
        <!-- Twitter -->
        <meta name=”twitter:title” content="Gaserc Kuwait"/>
        <meta property="twitter:card" content="">
        <meta name=”twitter:description” content="Gulf Arab States Educational Center"/>
        <meta name=”twitter:url” content="https://www.gaserc.com/"/>
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
        <link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/style.css?v-hash=936708f">
        <link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/ltr.css?v-hash=936708f">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/6212ad085b.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Menu Source -->
        <link href="https://www.gaserc.org/website_assets/assets/css/menu/desktop_menu.css?v-hash=936708f" rel="stylesheet" type="text/css" media="all"/>
        <link href="https://www.gaserc.org/website_assets/assets/css/menu/mobile_menu.css?v-hash=936708f" rel="stylesheet" type="text/css" media="all"/>
        <script type="text/javascript" src="https://www.gaserc.org/website_assets/assets/css/menu/menu.js?v-hash=936708f"></script>
        <!-- Slideshow Source -->
        <link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/slider/owl.css?v-hash=936708f">
        <link rel="stylesheet" href="https://www.gaserc.org/website_assets/assets/css/slider/style.css?v-hash=936708f">
        <!-- Slick Slideshow -->
        <!-- <link rel='stylesheet' href='slickslide/slick.min.css'> -->
        <!-- slick source -->
        <link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/slick/slick.css?v-hash=936708f">
        <link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/slick/slick-theme.css?v-hash=936708f">
        <link rel="stylesheet" type="text/css" href="https://www.gaserc.org/website_assets/assets/css/custom.css?v11?v-hash=936708f">
        <!-- fav icon -->
        <link rel="icon" href="https://www.gaserc.org/uploads/logo/favicon-d4e7f8470e08e4c5a91a3456f7952863.png?v-hash=936708f" type="image/png" sizes="16x16">
        <!-- <script async="" src="//connect.facebook.net/en_US/fbds.js"></script> -->
        <script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script>
    </head>
    <body>
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
        </style>
        <script>
            document.querySelector('[data-target="#homemodalbox"]').click()
        </script>
        <header>
            <div class="topline"></div>
            <div class="top_header">
                <!-- Logo -->
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="https://www.gaserc.org">
                            <div class="">
                                <img src="https://www.gaserc.org/uploads/logo/logo-alt-44733f5cd87a59df93d13d1b06237011.png" alt="" title="logo" style="max-width: 500px" class="logo">
                            </div>
                        </a>
                        <div class="m_hide text-right" style="padding-right: 0;">
                            <div class="d-flex align-items-center justify-content-end gap-4">
                                <form method="GET" action="https://gaserc.org/searchWebsite" class="d-flex justify-content-end" style="height: 35px">
                                    <input type="text" id="query" name="search_input" class="search_input" placeholder="Search" onblur="this.placeholder='Search'" onfocus="this.placeholder=''">
                                    <button class="search_button">
                                        <i class="fa fa-search fa-lg"></i>
                                    </button>
                                </form>
                                <div>
                                    <a href="login_ar.php">
                                        <img title="العربية" width="34px" height="38px" src="https://www.gaserc.org/admin_assets/assets/media/flags/107-kwait.svg" alt="arabic">
                                    </a>
                                </div>
                                <div class="kt-nav__item ">
                                    <span class="kt-nav__link">
                                        <p>
                                            <a style="background-color: transparent; font-size: 14px;" href="https://portal.gaserc.org/Account/Login.aspx" target="_blank" rel="noopener">
                                            </a>
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu -->
            <div class="menu_bg">
                <div class="container">
                    <ul id="nav" class="m_hide desk_show">
                        <li class="/">
                            <a href="https://gaserc.org/" target="">Home</a>
                        </li>
                        <li>
                            <a href="#">About GASERC</a>
                            <ul>
                                <li>
                                    <a href="https://gaserc.org/about/establishment-of-gaserc" target="">Establishment of GASERC</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/council-of-trustees" target="">Council of Trustees</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/about/partners" target="">Partners</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Programs</a>
                            <ul>
                                <li>
                                    <a href="https://gaserc.org/programs/current-projects" target="">Current Projects</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/programs/projects-of-2021-2022" target="">Projects of (2021-2022)</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/programs/previous-projects" target="">Previous Projects</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">News and Events</a>
                            <ul>
                                <li>
                                    <a href="https://gaserc.org/news-events/1" target="">Seminars and workshops</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/news-events/2" target="">Conferences</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/news-events/3" target="">Cultural seasons</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/news-events/4" target="">Discussion Panels</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/news-events/5" target="">GASERC News</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">publications</a>
                            <ul>
                                <li>
                                    <a href="https://gaserc.org/versions/study-and-research" target="">Studies and Research</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/versions/educational-future-magazine" target="">Educational Prospects</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Library</a>
                            <ul>
                                <li>
                                    <a href="https://gaserc.portal.medad.com/ar" target="_blank">Library Catalog</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/library/work-hours" target="">Work Hours</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.portal.medad.com/ar/widget-listing/605" target="_blank">New Arrivals</a>
                                </li>
                                <li>
                                    <a href="https://gaserc.org/library/ask-the-librarian" target="">Ask the librarian</a>
                                </li>
                            </ul>
                        </li>
                        <li class="/announcement">
                            <a href="https://gaserc.org/announcement" target="">Announcement</a>
                        </li>
                        <li class="/contact-us">
                            <a href="https://gaserc.org/contact-us" target="">Contact Us</a>
                        </li>
                    </ul>
                    <a class="formobile" href="https://www.gaserc.org/pdf/pdf-48461d251794906fdedb2cc9f6f077fc.pdf" target="_blank" style="float:right;color: #fecb3e;text-decoration:none;">
                        <span class="" style="color: #fecb3e;">
                            <p>
                                <span style="color: rgb(255, 255, 255);">GASERC Guide</span>
                            </p>
                        </span>
                    </a>
                    <!-- Mobile Menu -->
                    <nav class="tab-bar desk_hide m_show">
                        <div class="menu">
                            <a href="#" class="slide-menu-open">
                                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                            </a>
                            <div class="side-menu-overlay" style="width: 0px; opacity: 0;"></div>
                            <div class="side-menu-wrapper">
                                <a href="#" class="menu-close">&times;</a>
                                <ul>
                                    <li style="border-right:none;" class="/">
                                        <a target="" href="https://gaserc.org/">Home</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">About GASERC</a>
                                        <ul>
                                            <li>
                                                <a href="https://gaserc.org/about/establishment-of-gaserc" target="">Establishment of GASERC</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/council-of-trustees" target="">Council of Trustees</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/about/partners" target="">Partners</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Programs</a>
                                        <ul>
                                            <li>
                                                <a href="https://gaserc.org/programs/current-projects" target="">Current Projects</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/programs/projects-of-2021-2022" target="">Projects of (2021-2022)</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/programs/previous-projects" target="">Previous Projects</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">News and Events</a>
                                        <ul>
                                            <li>
                                                <a href="https://gaserc.org/news-events/1" target="">Seminars and workshops</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/news-events/2" target="">Conferences</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/news-events/3" target="">Cultural seasons</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/news-events/4" target="">Discussion Panels</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/news-events/5" target="">GASERC News</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">publications</a>
                                        <ul>
                                            <li>
                                                <a href="https://gaserc.org/versions/study-and-research" target="">Studies and Research</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/versions/educational-future-magazine" target="">Educational Prospects</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Library</a>
                                        <ul>
                                            <li>
                                                <a href="https://gaserc.portal.medad.com/ar" target="_blank">Library Catalog</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/library/work-hours" target="">Work Hours</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.portal.medad.com/ar/widget-listing/605" target="_blank">New Arrivals</a>
                                            </li>
                                            <li>
                                                <a href="https://gaserc.org/library/ask-the-librarian" target="">Ask the librarian</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li style="border-right:none;" class="/announcement">
                                        <a target="" href="https://gaserc.org/announcement">Announcement</a>
                                    </li>
                                    <li style="border-right:none;" class="/contact-us">
                                        <a target="" href="https://gaserc.org/contact-us">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="https://www.gaserc.org/pdf/pdf-48461d251794906fdedb2cc9f6f077fc.pdf" target="_blank" style="color: #fecb3e;text-decoration:none;">
                                            <span style="color: #fecb3e;">
                                                <p>
                                                    <span style="color: rgb(255, 255, 255);">GASERC Guide</span>
                                                </p>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.gaserc.org/locale/ar">العربية</a>
                                    </li>
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
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-ffdb9256804b428936012dbc3461c218.jpeg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="http://gaserc.org/news-events/02062024/read" target="_blank">
                                        <p class="slide_text">The meeting of the Council of Trustees of the Gulf Arab States Educational Research Center (GASERC), in its thirty-eighth session was held
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-a307a2d5512b455b5fef660d476d4319.jpg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://gaserc.org/news-events/omanmeeting15may/read" target="_blank">
                                        <p class="slide_text">GASERC holds a meeting for officials of educational information and statistics in the Ministries of Education in Member States, in Muscat, Sultanate of Oman
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-ca1959754b4e07bc37fefa2ba9d4644f.jpeg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://gaserc.org/news-events/event1742024/read" target="_blank">
                                        <p class="slide_text">GASERC organizes a cultural evening entitled: The Cultural Commonalities Among ABEGS Member States
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-31b337e0a84c475b69a0bcd5154cd2b6.jpeg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://gaserc.org/news-events/29-2-2024/read" target="_blank">
                                        <p class="slide_text">The delegation from the Queen Rania Teacher Academy in Jordan visits GASERC
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-db56acf3f57e613c6bb5b8affc42ec29.png) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://www.gaserc.org/news-events/وزير-التربية-ووزير-التعليم-العالي-والبحث-العلمي-في-دولة-الكويت-يستقبل-مدير-المركز/read" target="_blank">
                                        <p class="slide_text">The Minister of Education and Minister of Higher Education and Scientific Research in Kuwait receives GASERC Director
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-30d8acb3b0aed87a148763fc27c9ac65.png) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://www.gaserc.org/news-events/مدير-المركز-يلتقي-الأمين-العام-لمجلس-الوزراء-بدولة-الكويت/read" target="_blank">
                                        <p class="slide_text">GASERC Director meets with the Secretary-General of the Council of Ministers in Kuwait
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/2024-02-06at11.37.02_9f317bec.jpg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://www.gaserc.org/news-events/المركز-العربي-للبحوث-التربوية-لدول-الخليج-يعقد-مشغلا-تربويا-حول-تنمية-الهوية-الثقافية-والانتماء-الوطني-في-مدارس-التعليم-غير-الحكومي-(الأهلي-والخاص)/read" target="_blank">
                                        <p class="slide_text">GASERC holds an educational workshop on developing cultural identity and national belonging in non-governmental schools
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-b51254ad9e50601808193761a2015337.png) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://www.gaserc.org/news-events/alaaal-lltkhtyt-yokaa-atfaky-maa-almrkz-alaarby-llbhoth-altrboy-ldol-alkhlyg-lttoyr-alsyasat-altaalymy/read" target="_blank">
                                        <p class="slide_text">The Supreme Council for Planning and Development signs an agreement with GASERC to develop educational policies
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-b3af5fbdf20572a5fa8624d9879a4e5e.png) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://www.gaserc.org/news-events/almrkz-alaarby-llbhoth-altrboy-ldol-alkhlyg-yaakd-ndo-doly-hol-altaalm-alagtmaaay-oalaaatfy-fy-mdyn-almnam/read" target="_blank">
                                        <p class="slide_text">GASERC holds an International Symposium on: “Social and Emotional Learning” in Manama City
                                    </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide -->
                        <div class="slide">
                            <div class="image-layer" style="background-image:url(https://www.gaserc.org/uploads/slideshow/b-16d9f7b83886d251c0b992c436c303a6.jpeg) "></div>
                            <div class="auto-container">
                                <div class="content m_hide">
                                    <a href="https://gaserc.org/news-events/agtmaaa-mgls-amnaaa-almrkz-alaarby-llbhoth-altrboy-ldol-alkhlyg-aldor-alsabaa-oalthlathon/read" target="_blank">
                                        <p class="slide_text">Meeting of GASERC Council of Trustees (37th session)
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
                        <div class="news_title">CRW Register</div>
                        <div class="title_line"></div>
                        <div class="title_dot"></div>
                        <div class="clear30x"></div>
                        <?php
                            if (!empty($error)) {
                                echo '
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error!</strong><br />' . htmlspecialchars($error) . '
                                </div>
                                <div class="clear30x"></div>';
                            }
                        ?>
                        <div class="row news-row text-center">
                            <form method="POST" action="login.php">
                                <input type="hidden" name="ms_csrf_token" value="<?php if(isset($_SESSION['ms_csrf_token'])) {echo htmlspecialchars($_SESSION['ms_csrf_token']); } ?>" autocomplete="off">
                                <input required type="email" name="email" placeholder="Enter your email address" onblur="this.placeholder='Enter your email address'" onfocus="this.placeholder='Enter your email address'" class="col-centered center col-9 col-md-9 col-sm-9 news_letter">
                                <div class="clear20x"></div>
                                <input required type="password" name="password" placeholder="Enter your password" onblur="this.placeholder='Enter your password'" onfocus="this.placeholder='Enter your password'" class="col-9 col-md-9 col-sm-9 news_letter col-centered center">
                                <div class="clear20x"></div>
                                <button type="submit" class="col-4 col-md-4 col-sm-4 news_letter col-centered center">Log In</button>
                            </form>
                        </div>
                        <div class="clear20x"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Latest Books -->
        <section class="gray_bg mb-40 scroll-element js-scroll fade-in-bottom" dir='ltr'>
            <div class="container">
                <div class="row justify-content-md-center">
                    <!-- title -->
                    <div class="title_contaner">
                        <div class="title_line2"></div>
                        <div class="title_dot2"></div>
                        <div class="act_title">Latest Releases</div>
                        <div class="title_dot3"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="table_bg">
                        <div class="col-lg-10 col-md-10 col-sm-12 ml-96">
                            <div class="responsive" style="margin: 0rem 2rem;">
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/magazines/b-bc90617545110e79aec7a1fef61bf9e9.jpg" alt="">
                                    <p>الذكاء الاصطناعي في التعليم: الوعود...</p>
                                    <button onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/157'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/magazines/b-9458b1bb57f215d3210d986feb9273d9.jpg" alt="">
                                    <p>Digital Reading Skills</p>
                                    <button onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/154'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-37d0376364f84c8eb5f767760aa296cb.jpeg" alt="Cultural shared elements among ABEGS member states" height="500px">
                                    <p>Cultural shared elements among ABEG...</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/156'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-485992b8567fd34f6b69f84bfc1b3469.jpeg" alt="Teaching and promoting tolerance and acceptance in schools" height="500px">
                                    <p>Teaching and promoting tolerance an...</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/158'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-20bdb7077abc437c3c4b821137ead7af.jpg" alt="Management Standards of the Arab Bureau of Education for the Gulf states Programs and Projects" height="500px">
                                    <p>Management Standards of the Arab Bu...</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/159'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-9f0a53fa6dc69a8e7364eb5b8800e6fa.jpeg" alt="Blended learning." height="500px">
                                    <p>Blended learning.</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/155'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/magazines/b-f6f5e5b46b2206e323d7e82512b3703c.jpg" alt="">
                                    <p>Students’ Mental Health: A Fundamen...</p>
                                    <button onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/153'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-42c431729fcc68823425c09d235eb170.jpg" alt="Children’s Writers Dictionary: Age Group 3-12" height="500px">
                                    <p>Children’s Writers Dictionary: Age...</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/151'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/studies_and_research/b-7e0b9e0a7bc9ccfb849d7619407940ef.jpg" alt="Education During Crisis" height="500px">
                                    <p>Education During Crisis</p>
                                    <button onClick="location.href='https://www.gaserc.org/studies-and-research/details/152'">Read More</button>
                                </div>
                                <div class="my_slide">
                                    <img src="https://www.gaserc.org/uploads/magazines/b-c8d08375ec1142a1cc35429bfce993bd.jpeg" alt="">
                                    <p>Partnership between Family and Scho...</p>
                                    <button onClick="location.href='https://www.gaserc.org/educational-future-magazine/details/149'">Read More</button>
                                </div>
                            </div>
                        </div>
                        <div class="clear40x"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <p class="text-center">
                                <button onClick="location.href='https://www.gaserc.org/versions/educational-future-magazine'" class="view_all">Educational Prospects</button>
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <p class="text-center">
                                <button onClick="location.href='https://www.gaserc.org/versions/study-and-research'" class="view_all">Latest Studies</button>
                            </p>
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
                        <div class="act_title">Activities</div>
                        <div class="title_dot3"></div>
                        <div class="clear"></div>
                    </div>
                    <!-- Card -->
                    <div class="col-3 col-md-3 col-sm-6">
                        <a href="https://www.gaserc.org/news-events/1">
                            <div class="act_bg">
                                <img src="https://www.gaserc.org/website_assets/assets/images/video_ico.png" alt="">
                                <p>Seminars &amp;Workshops</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-3 col-md-3 col-sm-6">
                        <a href="https://www.gaserc.org/news-events/2">
                            <div class="act_bg">
                                <img src="https://www.gaserc.org/website_assets/assets/images/study_ico.png" alt="">
                                <p>Conferences</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-3 col-md-3 col-sm-6">
                        <a href="https://www.gaserc.org/news-events/3">
                            <div class="act_bg">
                                <img src="https://www.gaserc.org/website_assets/assets/images/speach_ico.png" alt="">
                                <p>Cultural Seasons</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-3 col-md-3 col-sm-6">
                        <a href="https://www.gaserc.org/news-events/4">
                            <div class="act_bg">
                                <img src="https://www.gaserc.org/website_assets/assets/images/meeting_ico.png" alt="">
                                <p>Discussion Panels</p>
                            </div>
                        </a>
                    </div>
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
                            <p class="footer_title">Call Us
					
                            <p>
                                <img width="320px" src="https://www.gaserc.org/website_assets/assets/images/footer_logo.png" alt=""/>
                                <ul class="address">
                                    <li>
                                        <i class="fas fa-map-marked-alt"></i>
                                        Yousef Ibrahim Al-Ghanim Street, Block 3, Shamiya, Kuwait
No. 12580 - Shamiya 71656
                                    </li>
                                    <li>
                                        <i class="fas fa-paper-plane"></i>
                                        <a href="mailto:gaserc@gaserc.org" target="_blank">gaserc@gaserc.org</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-phone-alt right"></i>
                                        <div dir="ltr" class="phone">+965 24830428, +965 24830499 ,+965 24832677 </div>
                                    </li>
                                    <div class="clear"></div>
                                    <li>
                                        <i class="fas fa-fax right"></i>
                                        <div dir="ltr" class="phone">+965 24830571</div>
                                    </li>
                                </ul>
                            <div class="clear30x"></div>
                            <ul class="social_links">
                                <li>
                                    <a href="https://www.facebook.com/GASERCKUWAIT/" target="_blank">
                                        <i class="fa fa-facebook fa-lg"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/gaserckuwait" target="_blank">
                                        <i class="fab fa-twitter fa-lg"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/@gaserckuwait" target="_blank">
                                        <i class="fab fa-youtube fa-lg"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/GASERCKUWAIT/" target="_blank">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        <!-- Card -->
                        <div class="col-4 col-md-4 col-sm-6">
                            <p class="footer_title">Quick Links
					
                            <p>
                            <ul class="footer_links">
                                <li>
                                    <a href="/">Home</a>
                                </li>
                                <li>
                                    <a href="/about/establishment-of-gaserc">Establishment of GASERC</a>
                                </li>
                                <li>
                                    <a href="council-of-trustees">Council of Trustees</a>
                                </li>
                                <li>
                                    <a href="/announcement">Announcement</a>
                                </li>
                                <li>
                                    <a href="https://portal.gaserc.org/">Employee Portal</a>
                                </li>
                                <li>
                                    <a href="/contact-us">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Card -->
                        <div class="col-4 col-md-4 col-sm-6">
                            <p class="footer_title">Newsletter
					
                            <p>
                            <form method="POST" action="https://gaserc.org/newsletter/email">
                                <input type="hidden" name="_token" value="fD4otBiJZrr7NrAthK5g5D20qNla2negVhRsgGLo" autocomplete="off">
                                <input type="text" name="name" placeholder="Enter your name" onblur="this.placeholder='Enter your name'" onfocus="this.placeholder='Enter your name'" class="news_letter news_letter_width">
                                <input type="email" name="email" placeholder="Enter your email address" onblur="this.placeholder='Enter your email address'" onfocus="this.placeholder='Enter your email address'" class="news_letter">
                                <button class="news_button">
                                    <i class="fas fa-paper-plane fa-lg"></i>
                                </button>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6LeMueQUAAAAAJ-ZUe9ZqGK3pma9VwbeoaYDgJte"></div>
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
            All rights reserved © The Gulf Arab States Educational Research Center (GASERC) - Kuwait 2023
            <br />
            CARDI, Helwan University, Cairo, Egypt.
        </div>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <!--slick js-->
        <script type="text/javascript" charset="utf-8" src="https://www.gaserc.org/website_assets/assets/js/slick/slick.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/owl.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/custom.js?v-hash=936708f"></script>
        <script type="text/javascript">
            $(document).on('ready', function() {
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
    </body>
</html>