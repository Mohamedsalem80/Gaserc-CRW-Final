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
                bottom: -86px;
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
        </style>
        <script>
            document.querySelector('[data-target="#homemodalbox"]').click()
        </script>
        <header>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Subject</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addSubForm">
                                <div class="form-group">
                                    <label for="subject-name" class="col-form-label">Subject Name:</label>
                                    <input type="text" class="form-control" id="subject-name">
                                </div>
                                <div class="form-group">
                                    <label for="subject-name-ar" class="col-form-label">Subject Name (Arabic):</label>
                                    <input type="text" class="form-control" id="subject-name-ar">
                                </div>
                                
                                <!-- Grades 1-6 in a single row -->
                                <div class="form-group">
                                    <label class="col-form-label">Subject Annual Hours for Grades 7-9:</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" placeholder="Grade 7" id="grade7">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" placeholder="Grade 8" id="grade8">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" placeholder="Grade 9" id="grade9">
                                        </div>
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <label for="min-hours" class="col-form-label">Subject Minimum Hours:</label>
                                    <input type="text" class="form-control" id="min-hours">
                                </div>
                                <div class="form-group">
                                    <label for="max-hours" class="col-form-label">Subject Maximum Hours:</label>
                                    <input type="text" class="form-control" id="max-hours">
                                </div>
                                <div class="form-group">
                                    <label for="avg-hours" class="col-form-label">Subject Average Hours:</label>
                                    <input type="text" class="form-control" id="avg-hours">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addSub();">Add Subject</button>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <a href="https://www.gaserc.org/locale/ar">
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
                        <div class="news_title">Classic Ratio-Weights</div>
                        <div class="title_line"></div>
                        <div class="title_dot"></div>
                        <div class="clear30x"></div>
                        <div class="control_panel panel_up">
                            <div class="panel_btn">
                                <i class="fa fa-arrow-down"></i>
                            </div>
                            <div class="container mt-2">
                                <div class="form-group row mb-1">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Change</label>
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-danger" onclick="spinButton2SpinDown();" style="width: 32px;">-</button>
                                        <button type="button" class="btn btn-danger" onclick="spinButton2SpinUp();" style="width: 32px;">+</button>
                                        <button type="button" class="btn btn-secondary ml-5" onclick="ButtonToNeutraliseAnomalies_Click();" style="width: 180px;">Compensation</button>
                                        <button type="button" class="btn btn-success" onclick="downloadPDF2();" style="width: 132px;">Print</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="width: 150px;" onclick="addSub();">Add Subject</button>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 0;">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Auto-Change</label>
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-primary" onclick="spinButton1SpinDown();" style="width: 32px;">-</button>
                                        <button type="button" class="btn btn-primary" onclick="spinButton1SpinUp();" style="width: 32px;">+</button>
                                        <button type="button" class="btn btn-warning ml-5" onclick="reset();" style="width: 180px;">Reset</button>
                                        <button type="button" class="btn btn-success" onclick="publish();" style="width: 132px;">Publish</button>
                                        <button type="button" class="btn btn-danger" onclick="removeSub();" style="width: 150px;">Remove Subject</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="images_holder">
                        <img src="./images/logo_en.png" width="100" id="country_flag" class="right">
                        <img src="./images/logo_en.png" width="400" class="left">
                    </div>
                    <div id="printable">
                        <div class="container mt-4">
                            <h1>
                                Main
                            </h1>
                            <div class="table-responsive">
                                <table class="table" id="IncrementPeriodsPerClick">
                                    <tbody>
                                        <tr>
                                            <th>number of Weeks</th>
                                            <td class="numVal" id="noWeeks">38</td>
                                        </tr>
                                        <tr>
                                            <th>Class Time (min)</th>
                                            <td class="numVal" id="classMints">45</td>
                                        </tr>
                                        <tr>
                                            <th>hours / year</th>
                                            <td class="numVal" id="incrementPeriodsPerClick">29</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table" id="historicalTableHead">
                                    <thead>
                                        <tr>
                                            <th>Cycle</th>
                                            <th>Cy3</th>
                                            <th>Cy3</th>
                                            <th>Cy3</th>
                                            <th rowspan="2" style="width: 75px;">Hrs Tot</th>
                                            <th rowspan="2" style="width: 75px;">%</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 330px;">Grade</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table" id="historicalTable">
                                    <tbody>
                                        <tr>
                                            <td class="subname">Islamic education</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numValt">174</td>
                                            <td class="numValp">8%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Arabic</td>
                                            <td class="numVal">175</td>
                                            <td class="numVal">175</td>
                                            <td class="numVal">175</td>
                                            <td class="numValt">525</td>
                                            <td class="numValp">25%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">English</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">12%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Mathematics</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">18%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Sciences</td>
                                            <td class="numVal">117</td>
                                            <td class="numVal">117</td>
                                            <td class="numVal">117</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">11%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Social studies</td>
                                            <td class="numVal">88</td>
                                            <td class="numVal">88</td>
                                            <td class="numVal">88</td>
                                            <td class="numValt">264</td>
                                            <td class="numValp">9%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Physical education</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numValt">174</td>
                                            <td class="numValp">7%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Art & music</td>
                                            <td class="numVal">29</td>
                                            <td class="numVal">29</td>
                                            <td class="numVal">29</td>
                                            <td class="numValt">87</td>
                                            <td class="numValp">8%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Practical skills</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">2%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Additional support</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Choise by school</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Optional subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">New subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Integrated subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Theme-subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Projects & interdisc</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Combined subject</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 1</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 2</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 3</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <h1>
                                Under Planning
                            </h1>
                            <div class="table-responsive">
                                <table class="table" id="HypotheticalTableHead">
                                    <thead>
                                        <tr>
                                            <th>Cycle</th>
                                            <th>Cy3</th>
                                            <th>Cy3</th>
                                            <th>Cy3</th>
                                            <th rowspan="2" style="width: 75px;">Tot</th>
                                            <th rowspan="2" style="width: 75px;">%</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 330px;">Grade</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table" id="totalYearlyHours">
                                    <tbody>
                                        <tr>
                                            <td style="width: 330px;">Total Instruct Time</td>
                                            <td class="numVal">875</td>
                                            <td class="numVal">875</td>
                                            <td class="numVal">875</td>
                                            <td class="numValt" style="width: 75px;">2625</td>
                                            <td class="numValp" style="width: 75px;">100%</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table" id="HypotheticalTable">
                                    <tbody>
                                        <tr>
                                            <td class="subname">Islamic education</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numValt">174</td>
                                            <td class="numValp">8%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Arabic</td>
                                            <td class="numVal">175</td>
                                            <td class="numVal">175</td>
                                            <td class="numVal">175</td>
                                            <td class="numValt">525</td>
                                            <td class="numValp">25%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">English</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">12%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Mathematics</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numVal">146</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">18%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Sciences</td>
                                            <td class="numVal">117</td>
                                            <td class="numVal">117</td>
                                            <td class="numVal">117</td>
                                            <td class="numValt">438</td>
                                            <td class="numValp">11%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Social studies</td>
                                            <td class="numVal">88</td>
                                            <td class="numVal">88</td>
                                            <td class="numVal">88</td>
                                            <td class="numValt">264</td>
                                            <td class="numValp">9%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Physical education</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numVal">58</td>
                                            <td class="numValt">174</td>
                                            <td class="numValp">7%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Art & music</td>
                                            <td class="numVal">29</td>
                                            <td class="numVal">29</td>
                                            <td class="numVal">29</td>
                                            <td class="numValt">87</td>
                                            <td class="numValp">8%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Practical skills</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">2%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Additional support</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Choise by school</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Optional subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">New subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Integrated subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Theme-subjects</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Projects & interdisc</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Combined subject</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 1</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 2</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                        <tr>
                                            <td class="subname">Special subject 3</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numVal">0</td>
                                            <td class="numValt">0</td>
                                            <td class="numValp">0%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <h1>
                            Changes
                        </h1>
                        <div class="table-responsive">
                            <table class="table" id="changesHead">
                                <thead>
                                    <tr>
                                        <th>Cycle</th>
                                        <th>Cy3</th>
                                        <th>Cy3</th>
                                        <th>Cy3</th>
                                        <th rowspan="2" style="width: 75px;">Tot</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 330px;">Grade</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="table" id="ChangesTable">
                                <tbody>
                                    <tr>
                                        <td class="subname">Islamic education</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Arabic</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">English</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Mathematics</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Sciences</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Social studies</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Physical education</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Art & music</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Practical skills</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Additional support</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Choise by school</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Optional subjects</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">New subjects</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Integrated subjects</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Theme-subjects</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Projects & interdisc</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Combined subject</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Special subject 1</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Special subject 2</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                    <tr>
                                        <td class="subname">Special subject 3</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numVal">0</td>
                                        <td class="numValt">0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" id="totalAnomaly">
                                <tbody>
                                    <tr>
                                        <td style="width: 330px;">Total anomaly</td>
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
                        <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 20px;">
                            <button class="btn btn-primary custom-btn mx-2" id="btn0" onclick="updatePieChart(0)">7</button>
                            <button class="btn btn-primary custom-btn mx-2" id="btn1" onclick="updatePieChart(1)">8</button>
                            <button class="btn btn-primary custom-btn mx-2" id="btn2" onclick="updatePieChart(2)">9</button>
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
                        <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 4px;">
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Islamic Education')">Islamic Education</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Arabic Language')">Arabic Language</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('English Language')">English Language</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Mathematics')">Mathematics</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Science')">Science</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Social Studies')">Social Studies</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Physical Education')">Physical Education</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="updateCountryPieChart('Art & Music')">Art & music</button>
                        </div>
                        <div class="btn-group d-flex justify-content-center" role="group" style="margin-top: 4px;">
                            <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(7)">7</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(8)">8</button>
                            <button class="btn btn-primary custom-btn mx-1" onclick="setPYear(9)">9</button>
                        </div>
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
        <div class="copyright">All rights reserved © The Gulf Arab States Educational Research Center (GASERC) - Kuwait 2023</div>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <!--slick js-->
        <script type="text/javascript" charset="utf-8" src="https://www.gaserc.org/website_assets/assets/js/slick/slick.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/owl.js?v-hash=936708f"></script>
        <script src="https://www.gaserc.org/website_assets/assets/js/slider/custom.js?v-hash=936708f"></script>
        <script type="text/javascript">
            $(document).on('ready', function() {
                const _URL_currentUrl = window.location.href;
                const _URL_urlObj = new URL(_URL_currentUrl);
                const _URL_country = _URL_urlObj.searchParams.get('country');
                const _URL_grade = _URL_urlObj.searchParams.get('grade');
                const _URL_year = _URL_urlObj.searchParams.get('year');

                const _URL_img = document.getElementById("country_flag");
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
            const totalSchoolYears = 3;
            const totalSchoolSubjects = 20;
            var HistoricalHours = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
            var HistoricalHoursMin = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
            var HistoricalHoursMax = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
            var HITV = document.querySelectorAll("#historicalTable .numVal");
            var indx = 0;
            for (let i = 0; i < totalSchoolSubjects; i++) {
                for (let j = 0; j < totalSchoolYears; j++) {
                    HistoricalHours[i][j] = parseInt(HITV[indx++].innerText);
                }
            }
            var AnomaliesEachYear = [0, 0, 0, 0, 0, 0]; 
            var DesiredTotInstrucTimeEachYear = [875, 875, 875]; 
            var HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);
            var HypotheticalHours = HypotheticalWeeklyPeriods;
            var totals = [875, 875, 875];
            var totals_c = 2625;
            var diff = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
        </script>
        <script src="./js/extra-script-16.js"></script>
        <script>
            var pyear = 7;
            var psubject = 'Islamic Education';
            // Pie chart datasets
            let pieDatasets = [
                [12, 19, 3, 5, 2, 3, 1, 5],
                [8, 12, 6, 10, 4, 9, 2, 4],
                [10, 7, 12, 4, 5, 6, 3, 6]
            ];
            let transh = transposeMatrix(HypotheticalHours);
            for (let i = 0; i < totalSchoolYears; i++) {
                for (let j = 0; j < 8; j++) {
                    pieDatasets[i][j] = transh[i][j];
                }
            }
            const sublabels = [
                "Islamic education",
                "Arabic",
                "English",
                "Mathematics",
                "Sciences",
                "Social studies",
                "Physical education",
                "Art & music"
            ];

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
                    labels: ['Grade 7', 'Grade 8', 'Grade 9'],
                    datasets: [{
                        label: 'Anomalies',
                        data: [0, 0, 0],
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
                for (let i = 0; i < totalSchoolYears; i++) {
                    for (let j = 0; j < 8; j++) {
                        pieDatasets[i][j] = transh[i][j];
                    }
                }
                pieChart.data.datasets[0].data = pieDatasets[index];
                pieChart.update();
            }

            const countryDatasets = {
                7: {
                    'Islamic Education': [12, 18, 25, 30, 50, 70, 80],
                    'Arabic Language': [14, 23, 37, 45, 55, 65, 75],
                    'English Language': [22, 29, 33, 48, 55, 60, 73],
                    'Mathematics': [10, 15, 35, 45, 52, 64, 76],
                    'Science': [25, 32, 41, 50, 65, 70, 80],
                    'Social Studies': [18, 28, 35, 42, 59, 68, 72],
                    'Physical Education': [5, 15, 25, 35, 55, 63, 75],
                    'Art & Music': [15, 11, 5, 13, 15, 16, 17]
                },
                8: {
                    'Islamic Education': [14, 20, 30, 35, 55, 72, 82],
                    'Arabic Language': [16, 26, 40, 50, 60, 68, 78],
                    'English Language': [24, 31, 36, 50, 58, 63, 75],
                    'Mathematics': [12, 17, 37, 47, 55, 66, 78],
                    'Science': [27, 34, 44, 53, 68, 73, 83],
                    'Social Studies': [20, 30, 38, 45, 62, 71, 74],
                    'Physical Education': [7, 17, 27, 37, 58, 65, 77],
                    'Art & Music': [16, 13, 7, 15, 17, 18, 19]
                },
                9: {
                    'Islamic Education': [13, 19, 28, 32, 52, 71, 81],
                    'Arabic Language': [15, 25, 38, 47, 57, 66, 77],
                    'English Language': [23, 30, 34, 49, 57, 62, 74],
                    'Mathematics': [11, 16, 36, 46, 54, 65, 77],
                    'Science': [26, 33, 43, 52, 67, 72, 82],
                    'Social Studies': [19, 29, 37, 44, 61, 70, 73],
                    'Physical Education': [6, 16, 26, 36, 57, 64, 76],
                    'Art & Music': [15, 12, 6, 14, 16, 17, 18]
                }
            };

            // Labels for the country datasets (same for all)
            const countryLabels = [
                'Bahrain',
                'Kuwait',
                'Oman',
                'Qatar',
                'Saudi Arabia',
                'United Arab Emirates',
                'Yemen'
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
                        data: countryDatasets[pyear][psubject], // Default dataset
                        backgroundColor: colors,  // Reuse the color array
                        borderColor: colors.map(color => color.replace(/0.8/, '1')), // Reuse the border colors
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        
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
            
        </script>            
    </body>
</html>