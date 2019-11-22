<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

require("php/database.php");
?>

<html>
    <head>
        <title>
            It's Happening!
        </title>
        <link href="css/global-header.css" rel="stylesheet">
        <link href="css/global-background.css" rel="stylesheet">
        <link href="css/home.css" rel="stylesheet">
        <link href="css/slides.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/search-filter.css" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/card.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script src="js/scroll_home.js"></script>
        <script src="js/home_controller.js"></script>
        <script src="js/slides.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-1100848476206437",
                enable_page_level_ads: true
            });
        </script>

    </head>
    <body>
        <ul class='global-header'>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<li class='global-header-list'><a href='logout.php'>Sign Out</a></li>";
                if (sendQuery("select * from customer where username = '$username'")) {
                    echo "<li class='global-header-list'><a href='profile.php'>Profile</a></li>";

                } else if (sendQuery("select * from organizer where username = '$username'")) {
                    echo "<li class='global-header-list'><a href='index.php'>Organizer</a></li>";
                }
            } else {
                echo "<li class='global-header-list'><a href='login.php'>Sign In / Sign Up</a></li>";
            }
            ?>
            <li class='global-header-list'><a href="browse.php">Browse</a></li>
            <li class='global-header-list'><a href="home.php#aboutUs">About Us</a></li>
            <li class='global-header-list-left' style = "color: white; margin-top: 1.2%;" align = center>
                <?php if (isset($_SESSION['username'])) {
                    $user_query = sendQuery("SELECT first_name FROM organizer WHERE username='$username' UNION SELECT first_name FROM customer WHERE username='$username'");
                    if($user_query) {
                        $first_name = $user_query->fetch_assoc()['first_name'];
                    }
                    echo "Welcome! ".ucfirst($first_name);
                }?>
            </li>
        </ul>
        <!-- banner -->
        <div id='banner-container'>
            <div class='slides slides-fade'>
                <div class='slides-outer-center'>
                    <div class='slides-inner-center'>
                        <img src='images/banner/BestLiveMusic.gif' alt='' />
                    </div>
                </div>
            </div>
            <?php
            $featured_events = sendQuery("select * from featured_events");
            $counter = 1;

            while ($featured_events && $event = $featured_events->fetch_assoc()) {
                $event_id = $event['event_id'];
                $featured_image_query = sendQuery("SELECT image FROM events WHERE event_id=$event_id");
                if ($featured_image_query && $featured_image = $featured_image_query->fetch_assoc()) {
                    $image = $featured_image['image'];
                    echo "
                        <a href='event.php?event_id=$event_id'>
                        <div class='slides slides-fade'>
                        <div class='slides-outer-center'>
                        <div class='slides-inner-center'>
                        <img src='$image' alt='' />
                        </div></div></div></a>";
                    $counter++;
                }
            }
            ?>
        </div>
        <script> showSlides();</script>
        <!-- banner end -->
        <div class="searchFilter" id="searchFilter-box" >
            <form action="browse.php" method="GET">
                <div class="col-sm-12">
                    <div class="input-group" >
                        <input id="table_filter" name = "keyword" type="text" class="form-control" aria-label="Text input with segmented button dropdown" placeholder="    Search For Events ..."/>
                        <!-- <div class="input-group-btn" id = "searchbutton" /> -->
                        <input type="date" name="datepicker" id = "datepicker">
                        <button type="button" id="dropdown" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <span class="label-icon" >Category</span>
                            <span class="caret" >&nbsp;</span>
                        </button>
                        <button id="searchBtn" type="submit" class="btn btn-secondary btn-search" >
                            <span class="glyphicon glyphicon-search" >&nbsp;</span>
                            <span class="label-icon" >Search</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" id="dropdownlist" >
                            <ul class="category_filters" >
                                <li >
                                    <input class="cat_type category-input" data-label="All" id="all" value="" name="category" type="radio" ><label for="all" >All</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Music" value="Music" ><label class="category-label" for="Music" >Music</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Arts" value="Arts" ><label class="category-label" for="Arts" >Arts</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Party" value="Party" ><label class="category-label" for="Party" >Party</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Sports" value="Sports" ><label class="category-label" for="Sports" >Sales</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Food" value="Food and Drinks" ><label class="category-label" for="Food" >Food and Drinks</label>
                                </li>
                                <li >
                                    <input type="radio" name="category" id="Business" value="Business" ><label class="category-label" for="Business" >Business</label>
                                </li>
                            </ul>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </form>
        </div>
                 <!--search bar end -->

        <!-- Upcoming Events -->
        <div style="background: #acd9e2; padding-top:2%; padding-bottom:5%;">

            <div class="titlerow" align="center">Upcoming Events</div>
            <div class="upcoming-events-row">
                <div class="col sm_dashboard">
                    <div class="sm_shelf_renderer">
                        <div class="sm_horizontal_list_renderer" id="sm_scroll_container">
                            <a id="sm_left_arrow" class="btn-floating waves-effect waves-light red"><i class="material-icons">navigate_before</i></a>
                            <div class="sm_horizontal_list_renderer" id="items" style="transform:translateX(0px)" c_translate="0">      </div>
                            <a id="sm_right_arrow" class="btn-floating waves-effect waves-light red"><i class="material-icons">navigate_next</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upcoming Events End -->
        <div class="titlerow2" align="center">Explore the Event Categories</div>
        <div class='eventCategories'>

            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Party">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="https://mandalatickets.com/blog/wp-content/uploads/2018/08/party-in-cancun2.jpg" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">PARTY</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio"> Explore parties around Bloomington</p>
                        </div>

                    </div>
                    <!-- <p align='center' style="top: 1%;">PARTY</p> -->
                </a>
                <!-- END: card -->

            </section>
            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Music">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="https://www.bucketlist127.com/uploads/images/7c60cb41b4012484a0e55ce2fe8fcf45.jpg" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">MUSIC</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio"> Explore music fests,concerts and lot more!!</p>
                        </div>
                    </div>
                    <!-- <p align='center'  style="top: 1%;">MUSIC</p> -->
                </a>

                <!-- END: card -->

            </section>
            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Arts">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="https://static1.squarespace.com/static/58c9c6e69f74567f6f50dfba/t/58fe99e45016e163f2ffbe3c/1493080579013/?format=1500w" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">ARTS</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio"> Put on your thinking caps.. be creative!</p>
                        </div>

                    </div>
                    <!-- <p align='center'  style="top: 1%;">ARTS</p> -->
                </a>
                <!-- END: card -->

            </section>
        </div>
        <div class='eventCategories'>
            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Sports">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="https://www.insidethehall.com/wp-content/uploads/2015/07/IURut0017.jpg" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">SPORTS</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio">Go Hoosier!</p>
                        </div>

                    </div>
                    <!-- <p align='center' style="top: 1%;">SPORTS</p> -->
                </a>
                <!-- END: card -->

            </section>
            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Food">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="https://i0.wp.com/www.healthline.com/hlcmsresource/images/AN_images/paleo-diet-meal-plan-and-menu-1296x728-feature.jpg?w=1155&h=1528" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">FOOD</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio">Experience world class food festivals!</p>
                        </div>

                    </div>
                    <!-- <p align='center' style="top: 1%;">FOOD</p> -->
                </a>
                <!-- END: card -->

            </section>
            <section class="wrapper">
                <!-- BEGIN: card -->
                <a href="browse.php?category=Business" style="background:transparent">
                    <div class="cardlayout" data-effect="zoom">

                        <figure  class="card__image">
                            <img src="http://www.rafichowdhury.com/wp-content/uploads/2018/05/what-you-need-start-new-business.png" alt="Short description">
                        </figure>

                        <div class="card__body">
                            <h3 class="card__name">BUSINESS</h3>
                            <p class="card__job">BLOOMINGTON</p>
                            <p class="card__bio">Click to find out more... !</p>
                        </div>

                    </div>

                    <!-- END: card -->
                    <!-- <p align='center'  style="top: 1%;">BUSINESS</p> -->
                </a>
            </section>

        </div>
        <!-- About Us -->
        <div class="aboutUs">
            <section id="aboutUs"> </section>
            <img class = "aboutUs-logo" src='images/logo.JPG' alt="" style="max-height: 180px; bottom:5px; left: 1%; border-radius:50%;"/>
            <div class = "aboutUs-Container">
                <p style="font-size: 2.5em">It's Happening</p>
                <ul>
                    <li> Arpit Bansal</li>
                    <li> Arpit Bhatnagar</li>
                    <li> Jing Huang</li>
                    <li> Roja Raman</li>
                </ul>
                <div class="social-lsicon">
                    <a href="#" class="social-button google"><i class="fa fa-google-plus" ></i></a>
                    <a href="#" class="social-button twitter"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.facebook.com/itsHappeningBloomington" target="_blank" class="social-button facebook"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
        <!-- About Us End -->

        <!-- LiveChat (www.livechatinc.com) -->
        <script type="text/javascript">
            window.__lc = window.__lc || {};
            window.__lc.license = 10377037;
            (function () {
                var lc = document.createElement('script');
                lc.type = 'text/javascript';
                lc.async = true;
                lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(lc, s);
            })();
        </script>

        <noscript>
        <a href="https://www.livechatinc.com/chat-with/10377037/">Chat with us</a>,
        powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener" target="_blank">LiveChat</a>
        </noscript>
        <!-- LiveChat End -->
    </body>
    <script>
        var s = $('input'),
                f = $('form'),
                a = $('.after'),
                m = $('h4');

        s.focus(function () {
            if (f.hasClass('open'))
                return;
            f.addClass('in');
            setTimeout(function () {
                f.addClass('open');
                f.removeClass('in');
            }, 1300);
        });

        a.on('click', function (e) {
            e.preventDefault();
            if (!f.hasClass('open'))
                return;
            s.val('');
            f.addClass('close');
            f.removeClass('open');
            setTimeout(function () {
                f.removeClass('close');
            }, 1300);
        });
    </script>
</html>
