<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
if (isset($_GET["category"])) {
    $indicator = $_GET["category"];
} else
$indicator = null;
if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
} else
$keyword = null;

include 'php/database.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link href="css/global-header.css" rel="stylesheet">
    <link href="css/global-background.css" rel="stylesheet">
    <link href="css/slides.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
    <link href="css/eventcard.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/browse.css" rel="stylesheet">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="js/map.js"></script>
    <script src="js/slides.js"></script>
    <script src ="js/browse_controller.js"></script>
</head>
<body>
    <!-- global header -->
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
        <li class='global-header-list'><a href="home.php">Home</a></li>
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

    <!-- global header end -->

    <!-- search bar -->

    <!-- search bar end -->

    <!-- category choice -->
    <input type="hidden" id="indicator" value="<?php echo $indicator; ?>"/>
    <input type="hidden" id="keyword" value="<?php echo $keyword; ?>"/>
    <div class="category">
        <a href="browse.php"><div class="chip" id='All'>All</div></a>
        <a href="browse.php?category=Music"><div class="chip" id='Music'>Music</div></a>
        <a href="browse.php?category=Arts"><div class="chip" id='Arts'>Arts</div></a>
        <a href="browse.php?category=Party"><div class="chip" id='Party'>Party</div></a>
        <a href="browse.php?category=Sports"><div class="chip" id='Sports'>Sports</div></a>
        <a href="browse.php?category=Food"><div class="chip" id='Food'>Food</div></a>
        <a href="browse.php?category=Business"><div class="chip" id='Business'>Business</div></a>
    </div>

    <?php if (isset($_GET["category"])) { ?>
        <h5 class="selected">Selected: <?php echo $indicator; ?></h5>
    <?php } else if (isset($_GET["keyword"])) { ?>
        <h5 class="selected">Selected: <?php echo $keyword; ?></h5>
    <?php } ?>
    <!-- category choice end  -->

    <div class="right-side-container">
        <div id="map"></div>
        <div class="ad-container">
            <div class="slides slides-fade">
                <a href='https://www.surveyjunkie.com/'><img src="images/ads/ad1.jpg" alt=""/></a>
            </div>
            <div class="slides slides-fade">
                <a href='https://www.cub.com/'><img src="images/ads/ad2.jpg" alt=""/></a>
            </div>
            <div class="slides slides-fade">
                <a href='https://braizefood.com/'><img src="images/ads/ad3.jpg" alt=""/></a>
            </div>
            <div class="slides slides-fade">
                <a href='https://www.niceincontact.com/'><img src="images/ads/ad4.jpg" alt=""/></a>
            </div>
            <div class="slides slides-fade">
                <a href='https://www.airconditioningandplumbing.net/'><img src="images/ads/ad5.jpg" alt=""/></a>
            </div>
            <div class="slides slides-fade">
                <a href='https://1stcallplumbingservices.com/'><img src="images/ads/ad6.jpg" alt=""/></a>
            </div>
        </div>
    </div>
    <script> showSlides(); </script>
    <div id="adplaceholder"></div>
    <div class = "searchResult"> </div>

    <!-- Google Map -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuMrO8-BJdTVOPdTA_uxS5tlIsW3alQX0&callback=initMap">
    </script>
    <!-- Google Map End -->

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
</html>
