<?php
session_start();

$_SESSION['lang'] = 'ar';

if (empty($_SESSION['ms_csrf_token_2'])) {
    $_SESSION['ms_csrf_token_2'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['userID']) || 
    !isset($_SESSION['job']) || 
    !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionToken = $_SESSION['ms_csrf_token_2'] ?? '';
    $formToken = $_POST['ms_csrf_token_2'] ?? '';
    if ($sessionToken == $formToken) {
        unset($_SESSION['ms_csrf_token_2']);
        $country = isset($_POST['country']) ? $_POST['country'] : '';
        $grade = isset($_POST['stage']) ? $_POST['stage'] : '';

        if (!empty($country) && !empty($grade)) {
            $_SESSION['country'] = $country;
            $_SESSION['stage'] = (int)$grade;
            $lang = ($_SESSION['lang'] == 'en') ? '' : '_ar';
            $dashboard = ($grade == 1) ? 'dashboard16' : 'dashboard79';
            header("Location: {$dashboard}{$lang}.php");
        }
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
    <style>
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
    </style>
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
    </style>
    <style>
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
    .none {
        display: none;
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
																											<a href="followup.php"><img title="English" width="34px" height="38px"
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
                    <div class="news_title">متابعة</div>
                    <div class="title_line"></div>
                    <div class="title_dot"></div>
                    <div class="clear30x"></div>
    
                    <!-- Stepper -->
                    <div class="stepper text-center">
                        <div class="step actived" data-step="1"> <i class="fa fa-globe" aria-hidden="true"></i> </div>
                        <div class="line"></div>
                        <div class="step" data-step="3"> <i class="fa fa-users" aria-hidden="true"></i> </div>
                    </div>
    
                    <!-- Form Steps -->
                    <form id="multiStepForm" method="POST" action="followup_ar.php">     
                    <input type="hidden" name="ms_csrf_token_2" value="<?php if(isset($_SESSION['ms_csrf_token_2'])) {echo htmlspecialchars($_SESSION['ms_csrf_token_2']); } ?>" autocomplete="off">
                        <!-- Step 1 -->
                        <div class="col-centered center col-9 col-md-9 col-sm-9 form-step actived" data-step="1">
                            <div class="col-centered center col-9 col-md-9 col-sm-9 h4 p-2">
                                اختر الدولة
                            </div>
                            <div id="map-container">
                                <svg id="map" baseprofile="tiny" fill="#ececec" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width=".2" viewBox="1050 225 150 300" xmlns="http://www.w3.org/2000/svg">
                                <a class="country_holder" xlink:title="United Arab Emirates" xlink:href="#\unitedarabemirates">
                                    <path class="green" d="M1296.2 336.7l1.3 5.1-2.8 0 0 4.2 1.1 0.9-2.4 1.3 0.2 2.6-1.3 2.6 0 2.6-1 1.4-16.9-3.2-2.7-6.6-0.3-1.4 0.9-0.4 0.4 1.8 4.2-1 4.6 0.2 3.4 0.2 3.3-4.4 3.7-4.1 3-4 1.3 2.2z" id="AE" name="United Arab Emirates">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Kuwait" xlink:href="#kuwait">
                                    <path class="green" d="M1247.5 309.4l1.5 2.8-0.3 1.5 2.4 4.8-3.9 0.2-1.7-3.1-5-0.6 3.3-6.2 3.7 0.6z" id="KW" name="Kuwait">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Oman" xlink:href="#oman">
                                    <path class="green" d="M 1283.8 394.9 1281.6 390.4 1276.4 379.8 1292.7 373.4 1295.3 360.6 1292.3 356 1292.3 353.4 1293.6 350.8 1293.4 348.2 1295.8 346.9 1294.7 346 1294.7 341.8 1297.5 341.8 1300.5 346.2 1303.8 348.5 1307.9 349.4 1311.3 350.5 1314.2 354.2 1315.9 356.3 1317.9 357.2 1318.1 358.6 1316.4 362.4 1315.7 364.2 1313.5 366.3 1311.8 370.7 1309.3 370.3 1308.3 371.9 1307.6 375.1 1308.7 379.4 1308.2 380.2 1305.7 380.2 1302.4 382.6 1302.1 385.7 1300.9 387.1 1297.4 387 1295.4 388.6 1295.6 391.2 1293 393 1289.9 392.4 1286.3 394.6 1283.8 394.9 Z" name="Oman">
                                    </path>
                                    <path class="green" d="M 1296.2 336.7 1294.9 334.5 1296.3 332.4 1297 332.9 1296.8 335.6 1296.2 336.7 Z" name="Oman">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Qatar" xlink:href="#qatar">
                                    <path class="green" d="M1270.1 343.7l-1.5 0.5-1.8-1.3-0.8-4.7 1.1-3.3 1.5-0.7 1.8 2 0.5 3.7-0.8 3.8z" id="QA" name="Qatar">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Saudi Arabia" xlink:href="#saudiarabia">
                                    <path class="green" d="M1240.5 315l5 0.6 1.7 3.1 3.9-0.2 2.7 5.6 2.9 1.4 1.2 2.3 4 2.7 0.7 2.6-0.4 2.2 0.9 2.1 1.8 1.8 0.9 2.1 1 1.6 1.8 1.3 1.5-0.5 1.3 2.5 0.3 1.4 2.7 6.6 16.9 3.2 1-1.4 3 4.6-2.6 12.8-16.3 6.4-15.9 2.5-5 2.9-3.5 6.7-2.6 1.1-1.5-2.1-2.1 0.3-5.5-0.7-1.1-0.6-6.4 0.1-1.5 0.6-2.4-1.6-1.3 3.1 0.8 2.7-2.4 2.1-0.9-2.8-1.8-1.9-0.5-2.6-3.1-2.3-3.3-5.4-1.9-5.2-4.1-4.4-2.5-1.1-4.1-6.1-0.9-4.4 0-3.8-3.6-7.2-2.8-2.5-3-1.3-2.1-3.7 0.2-1.4-1.8-3.4-1.7-1.4-2.5-4.8-3.8-5.1-3.1-4.4-2.7 0 0.5-3.5 0.1-2.3 0.4-2.6 6.2 1.1 2.1-2 1.1-2.3 4.1-0.9 0.7-2.2 1.6-1-6-6.5 10.4-3.2 0.9-1 6.8 1.8 8.6 4.5 16.8 12.9 10.2 0.5z" id="SA" name="Saudi Arabia">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Yemen" xlink:href="#yemen">
                                    <path class="green" d="M1283.8 394.9l-4 1.7-0.9 2.9 0 2.2-5.4 2.7-8.8 3-4.7 4.5-2.5 0.4-1.7-0.4-3.2 2.7-3.5 1.2-4.7 0.3-1.4 0.4-1.1 1.7-1.5 0.5-0.8 1.6-2.8-0.2-1.7 0.9-4-0.3-1.6-3.8 0-3.5-1-1.9-1.3-4.7-1.8-2.6 1.1-0.4-0.7-2.9 0.6-1.2-0.4-2.8 2.4-2.1-0.8-2.7 1.3-3.1 2.4 1.6 1.5-0.6 6.4-0.1 1.1 0.6 5.5 0.7 2.1-0.3 1.5 2.1 2.6-1.1 3.5-6.7 5-2.9 15.9-2.5 5.2 10.6 2.2 4.5z" id="YE" name="Yemen">
                                    </path>
                                </a>
                                <a class="country_holder" xlink:title="Bahrain" xlink:href="#bahrain">
                                    <path class="green" d="M1264.1 333.3l0.3 0.1 0.2-0.1 0.4 0.7-0.1 0.2 0.1 0.9 0 0.7-0.2 0.4-0.1-0.4-0.6-0.8 0.1-0.4-0.2-0.7 0-0.4 0.1-0.2z" id="BH" name="Bahrain">
                                    </path>
                                </a>
                                </svg>
                                <div class="tooltip" id="tooltip"></div>
                                <div class="button-container">
                                    <button id="zoomInBtn" type="button">+</button>
                                    <button id="zoomOutBtn" type="button">-</button>
                                    <button id="resetBtn" type="button">إعادة</button>
                                </div>
                            </div>
                            <select class="custom-select col-centered center col-9 col-md-9 col-sm-9" name="country" id="country_select">
                                <option disabled selected value=""> اختر بلدك </option>
                                <option value="Bahrain" id="Bahrain"> البحرين </option>
                                <option value="Kuwait" id="Kuwait"> الكويت </option>
                                <option value="Oman" id="Oman"> عمان </option>
                                <option value="Qatar" id="Qatar"> قطر </option>
                                <option value="Saudi Arabia" id="SaudiArabia"> السعودية </option>
                                <option value="United Arab Emirates" id="UnitedArabEmirates"> الامارات </option>
                                <option value="Yemen" id="Yemen"> اليمن </option>
                            </select>
                            <div class="navigation-buttons col-centered center col-9 col-md-9 col-sm-9">
                                <button type="button" class="prev-step col-4 col-md-4 col-sm-4">إلغاء</button>
                                <button type="button" class="next-step bg-primary col-4 col-md-4 col-sm-4">التالي</button>
                            </div>
                        </div>
    
                        <!-- Step 2 -->
                        <div class="col-centered center col-9 col-md-9 col-sm-9 form-step" data-step="3">
                            <div class="col-centered center col-9 col-md-9 col-sm-9 h4 p-2">
                                اهتر المرحلة
                            </div>
                            <img src="./images/undraw_Small_town_re_7mcn.png" alt="" class="prog-img">
                            <select class="custom-select col-centered center col-9 col-md-9 col-sm-9" name="stage" id="stage">
                                <option disabled selected value=""> اختر المرحلة الدراسية </option>
                                <option value="1"> الابتدائية </option>
                                <option value="2"> المتوسطة </option>
                            </select>
                            <div class="navigation-buttons col-centered center col-9 col-md-9 col-sm-9">
                                <button type="button" class="prev-step">السابق</button>
                                <button type="button" class="next-step bg-primary">حساب</button>
                            </div>
                        </div>
                    </form>
    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H4339YK1ZB');
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.form-step');
        const stepIndicators = document.querySelectorAll('.step');
        let currentStep = 0;

        function showStep(step) {
            steps.forEach((stepDiv, index) => {
                stepDiv.classList.toggle('actived', index === step);
            });
            stepIndicators.forEach((indicator, index) => {
                indicator.classList.toggle('actived', index === step);
                indicator.classList.toggle('completed', index < step);
            });
        }

        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', () => {
                console.log(currentStep);
                switch (currentStep) {
                    case 0:
                        if (document.querySelector("[name='country']").value === "") {
                            $.notify("من فضلك اختر البلد قبل الاكمال", { className: "error", position: "top left" });
                            return;
                        }
                        break;
                    case 1:
                        if (document.querySelector("[name='stage']").value === "") {
                            $.notify("من فضلك اختر المرحلة الدراسية قبل الاكمال", { className: "error", position: "top left" });
                            return;
                        } else {
                            document.getElementById('multiStepForm').submit();
                        }
                        break;
                
                    default:
                        break;
                }
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        showStep(currentStep);
    });
</script>
<script>
    let isPanning = false;
    let startX, startY, initialX = 0, initialY = 0;
    let scale = 1;
    const scaleIncrement = 0.1;
    const minScale = 0.5;
    const maxScale = 5;

    const svg = document.querySelector("svg");
    const container = document.querySelector("#map-container");
    const viewBox = svg.viewBox.baseVal;

    const initialViewBox = {
        x: 1105,
        y: 280,
        width: 277,
        height: 155
    };

    if (!viewBox.width) viewBox.width = svg.clientWidth;
    if (!viewBox.height) viewBox.height = svg.clientHeight;
    if (!viewBox.x) viewBox.x = 0;
    if (!viewBox.y) viewBox.y = 0;

    function updateViewBox() {
        svg.setAttribute('viewBox', `${viewBox.x} ${viewBox.y} ${viewBox.width} ${viewBox.height}`);
    }

    container.addEventListener("mousedown", (e) => {
        isPanning = true;
        startX = e.clientX;
        startY = e.clientY;
    });

    container.addEventListener("mousemove", (e) => {
        if (!isPanning) return;

        const dx = (startX - e.clientX) / scale;
        const dy = (startY - e.clientY) / scale;

        viewBox.x += dx;
        viewBox.y += dy;

        updateViewBox();

        startX = e.clientX;
        startY = e.clientY;
    });

    container.addEventListener("mouseup", () => {
        isPanning = false;
    });

    container.addEventListener("wheel", (e) => {
        e.preventDefault();

        const zoomFactor = (e.deltaY > 0) ? (1 + scaleIncrement) : (1 - scaleIncrement);
        const newScale = scale * zoomFactor;

        if (newScale >= minScale && newScale <= maxScale) {
            const mouseX = e.clientX - container.getBoundingClientRect().left;
            const mouseY = e.clientY - container.getBoundingClientRect().top;

            viewBox.x += (mouseX / scale) * (1 - zoomFactor);
            viewBox.y += (mouseY / scale) * (1 - zoomFactor);
            viewBox.width *= zoomFactor;
            viewBox.height *= zoomFactor;

            scale = newScale;
            updateViewBox();
        }
    });

    function resetZoom() {
        // Reset to initial viewBox values without resizing the SVG
        viewBox.x = initialViewBox.x;
        viewBox.y = initialViewBox.y;
        viewBox.width = initialViewBox.width;
        viewBox.height = initialViewBox.height;
        scale = 1;
        updateViewBox();
    }

    // Zoom in
    function zoomIn() {
        if (scale < maxScale) {
            const zoomFactor = 1 - scaleIncrement;
            viewBox.width *= zoomFactor;
            viewBox.height *= zoomFactor;
            scale /= zoomFactor;
            updateViewBox();
        }
    }

    function zoomOut() {
        if (scale > minScale) {
            const zoomFactor = 1 + scaleIncrement;
            viewBox.width *= zoomFactor;
            viewBox.height *= zoomFactor;
            scale /= zoomFactor;
            updateViewBox();
        }
    }

    document.querySelector("#resetBtn").addEventListener("click", resetZoom);
    document.querySelector("#zoomInBtn").addEventListener("click", zoomIn);
    document.querySelector("#zoomOutBtn").addEventListener("click", zoomOut);
</script>
<script>
    let country_holder = document.querySelectorAll(".country_holder");
        country_holder.forEach(function(ele){
            ele.addEventListener("click", function(event){
                event.preventDefault();
                let countryName = event.target.getAttribute('name');
                document.querySelectorAll(".red").forEach(function(ele){
                    ele.classList.remove("red");
                    ele.classList.add("green");
                });
                console.log("svg");
                event.target.classList.remove("green");
                event.target.classList.add("red");
                const selectElement = document.getElementById('country_select');
                const optionToSelect = selectElement.querySelector(`option[value="${countryName}"]`);

                if (optionToSelect) {
                    // Set the selected attribute of the option
                    optionToSelect.selected = true;

                    // Optionally trigger change event if needed
                    selectElement.dispatchEvent(new Event('change'));
                } else {
                    console.log(`Option for ${countryName} not found in the select dropdown.`);
                }
            });
        });
    let selectElement = document.getElementById('country_select');
        selectElement.addEventListener("click", function(event) {
            const countryName = this.value;

            // Remove previous selections (red class) and apply new selection (green class)
            document.querySelectorAll(".red").forEach(function(path) {
                path.classList.remove("red");
                path.classList.add("green");
            });

            // Highlight the selected country in the SVG (add red class)
            const pathToHighlight = document.querySelector(`path[name="${countryName}"]`);
            if (pathToHighlight) {
                pathToHighlight.classList.add("red");
            } else {
                console.log(`Path for ${countryName} not found in the SVG.`);
            }
        });
        viewBox.x = 1105;
        viewBox.y = 280;
        viewBox.width = 277;
        viewBox.height = 155;
        scale = 1;
        updateViewBox();
        let mulForm = document.getElementById("multiStepForm");
        let  opt_e = document.querySelectorAll(".opt-e");
        document.getElementById("resetButton").onclick = function() {
            document.getElementById("country_select").selectedIndex = 0; // Reset country selection
            document.getElementById("stage").selectedIndex = 0; // Reset stage selection
        };
        // document.getElementById("grade").addEventListener("change", function(e){
        //     if (e.target.value == "1") {
        //         mulForm.action = "dashboard16_ar.html";
        //         opt_e.forEach(function(ele){
        //             ele.classList.remove("none");
        //         });
        //     } else if (e.target.value == "2") {
        //         mulForm.action = "dashboard79_ar.html";
        //         opt_e.forEach(function(ele){
        //             ele.classList.add("none");
        //         });
        //     }
        // });
</script>
</body>

</html>