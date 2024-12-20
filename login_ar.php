<?php

session_start(); // Start the session
$error = '';
// Set the default language
$_SESSION['lang'] = 'ar';

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
            $dbpassword = "m1o2h3@45";
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
                echo $password;
                echo '<br />';
                echo $hashedPassword;
                if ($password == $hashedPassword) {
                    // Set session variables upon successful login
                    $_SESSION['email'] = $email;
                    $_SESSION['userID'] = $userID;
                    $_SESSION['job'] = $jobID;

                    // Redirect the user to the dashboard
                    header("Location: followup_ar.php");
                    exit();
                } else {
                    $error = "كلمة السر غير صحيحة";
                }
            } else {
                $error = "لا يوجد حساب بهذا البريد الالكتروني";
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            $error = "البريد الالكتروني او كلمة السر غير صحيح";
        }
    } else {
        $error = "رمز CSRF غير صالح";
    }
}
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
	</style>
	<script>
		document.querySelector('[data-target="#homemodalbox"]').click()
	</script>
        <header>
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
																											<a href="login.php"><img title="English" width="34px" height="38px"
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
                    <div class="news_title">تسجيل الدخول</div>
                    <div class="title_line"></div>
                    <div class="title_dot"></div>
                    <div class="clear30x"></div>
					<?php
                            if (!empty($error)) {
                                echo '
                                <div class="alert alert-danger" role="alert">
                                    <strong>خطأ!</strong><br />' . htmlspecialchars($error) . '
                                </div>
                                <div class="clear30x"></div>';
                            }
                        ?>
                    <div class="row news-row text-center">
                        <form method="POST" action="login_ar.php">
                            <input type="hidden" name="ms_csrf_token" value="<?php if(isset($_SESSION['ms_csrf_token'])) {echo htmlspecialchars($_SESSION['ms_csrf_token']); } ?>" autocomplete="off">
                            <input type="email" name="email" placeholder="أدخل بريدك الالكتروني"
							onblur="this.placeholder='أدخل بريدك الالكتروني'"
							onfocus="this.placeholder='أدخل بريدك الالكتروني'" class="news_letter news_letter_width" required>
                            <input type="password" name="password" placeholder="أدخل كلمة السر"
							onblur="this.placeholder='أدخل كلمة السر'"
							onfocus="this.placeholder='أدخل كلمة السر'" class="news_letter news_letter_width" required>
                            <button type="submit" class="news_letter ">ادخل</button>
                        </form>
                    </div>
                    <div class="clear20x"></div>
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
						<input type="hidden" name="_token" value="8Fcwr9JvvULwZbW4oGWRIClTFOOtKykTGUUTQmXZ" autocomplete="off">						<input type="text" name="name" placeholder="أدخل اسمك"
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
<script type="text/javascript" charset="utf-8" src="https://www.gaserc.org/website_assets/assets/js/slick/slick.js?v-hash=0e3598a"></script>
<script src="https://www.gaserc.org/website_assets/assets/js/slider/owl.js?v-hash=0e3598a"></script>
<script src="https://www.gaserc.org/website_assets/assets/js/slider/custom.js?v-hash=0e3598a"></script>

<script type="text/javascript">
	$(document).on('ready', function() {
		$('.responsive').slick({
			dots: false,
			infinite: false,
			rtl: true,
			speed: 300,
			slidesToShow: 5,
			slidesToScroll: 1,
			responsive: [{
					breakpoint: 1024,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 1,
					}
				},
				{
					breakpoint: 800,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				},
				{
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

	const elementInView = (el, dividend = 1) => {
		const elementTop = el.getBoundingClientRect().top;

		return (
			elementTop <=
			(window.innerHeight || document.documentElement.clientHeight) / dividend);

	};

	const elementOutofView = el => {
		const elementTop = el.getBoundingClientRect().top;

		return (
			elementTop > (window.innerHeight || document.documentElement.clientHeight));

	};

	const displayScrollElement = element => {
		element.classList.add("scrolled");
	};

	const hideScrollElement = element => {
		element.classList.remove("scrolled");
	};

	const handleScrollAnimation = () => {
		scrollElements.forEach(el => {
			if (elementInView(el, 1.25)) {
				displayScrollElement(el);
			} else if (elementOutofView(el)) {
				hideScrollElement(el);
			}
		});
	};

	window.addEventListener("scroll", () => {
		handleScrollAnimation();
	});
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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-213489498-1');
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H4339YK1ZB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H4339YK1ZB');
</script>    </body>

</html>