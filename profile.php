<?php
session_start();
header("Access-Control-Allow-Origin: *");
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
}
require("php/database.php");

$user_query = sendQuery("select * from customer where username = '$username'");
if($user_query) {
    $user = $user_query->fetch_assoc();
    $email = $user['email'];
    $password = $user['password'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $phone_num = $user['phone_num'];
    $user_image = $user['user_image'];
} else {
    echo '<script type="text/javascript"> alert("Sorry, you do not have access to this page."); location="login.php"; </script>';
}

date_default_timezone_set('EST');

$upcoming_tickets = array();
$past_tickets = array();

$ticket_query = sendQuery("select * from event_registration where username = '$username'");
if($ticket_query) {
    while ($ticket = $ticket_query->fetch_assoc()) {
        $ticket_reg_id = $ticket['reg_id'];
        $ticket_id = $ticket['ticket_id'];
        $ticket_qty = $ticket['quantity'];
        $ticket_order_num = $ticket['order_number'];
        $ticket_info = sendQuery("select * from event_ticket where ticket_id = '$ticket_id'")->fetch_assoc();
        $ticket_type = $ticket_info['type'];
        $ticket_price = $ticket_info['price'];
        $event_id = $ticket_info['event_id'];
        $event_info = sendQuery("select * from events where event_id = '$event_id'")->fetch_assoc();
        $event_title = $event_info['name'];
        $event_date = $event_info['date'];
        $event_location = $event_info['venue'];
        $event_image = $event_info['image'];

        $today_dt = new DateTime(date("Y-m-d H:i:s"));
        $event_dt = new DateTime($event_info['date']);
        $interval = $today_dt->diff($event_dt);
        $interval_format = $interval->format('%R');

        $t = array(
            'reg_id' => $ticket_reg_id,
            'title' => $event_title,
            'type' => $ticket_type,
            'price' => $ticket_price,
            'date' => date("D • M jS Y • g:i A", strtotime($event_info['date'])),
            'location' => $event_location,
            'quantity' => $ticket_qty,
            'order_number' => $ticket_order_num,
            'image' => $event_image,
        );

        if($interval_format == '+') {
            array_push($upcoming_tickets, $t);
        } else {
            array_push($past_tickets, $t);
        }
    }
}

#upcoming events
$user_query = "select count(distinct(e.event_id)) as upevents from event_registration er, event_ticket et, events e where er.ticket_id = et.ticket_id and et.event_id = e.event_id and e.date >= CURDATE() and username ='" . $username . "' ";

$eventsObj1 = sendQuery($user_query);
$upevents = array();

if ($eventsObj1) {
    while($row = $eventsObj1->fetch_assoc())  {
        $upevents = $row;
    }
}
#past events =
$user_query1 = "select count(distinct(e.event_id)) as pastevents from event_registration er, event_ticket et, events e where er.ticket_id = et.ticket_id and et.event_id = e.event_id and e.date < CURDATE() and username ='" . $username . "' ";

$eventsObj2 = sendQuery($user_query1);
$pastevents = array();

if ($eventsObj1) {
    while($row = $eventsObj2->fetch_assoc())  {
        $pastevents = $row;
    }
}
#scheduled next week
$user_query2 = "select count(distinct(e.event_id)) as nextweek from event_registration er, event_ticket et, events e where er.ticket_id = et.ticket_id and et.event_id = e.event_id and (date between curdate() and curdate()+6) and username ='" . $username . "' ";

$eventsObj3 = sendQuery($user_query2);
$nextweek = array();

if ($eventsObj3) {
    while($row = $eventsObj3->fetch_assoc())  {
        $nextweek = $row;
    }
}

#scheduled last month
$user_query3 = "select count(distinct(e.event_id)) as lastmonth from event_registration er, event_ticket et, events e where er.ticket_id = et.ticket_id and et.event_id = e.event_id and e.date between date_sub(now(),INTERVAL 1 MONTH) and now() and username ='" . $username . "' ";

$eventsObj4 = sendQuery($user_query3);
$lastmonth = array();

if ($eventsObj4) {
    while($row = $eventsObj4->fetch_assoc())  {
        $lastmonth = $row;
    }
}


?>

<html>
    <head>
        <title>It's Happening!</title>
         <link href="css/profile.css" rel="stylesheet">
         <link href="css/login.css" rel="stylesheet">
        <link href="css/global-header.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/profile_controller.js"></script>
        <script src = "js/createEvent_controller.js"></script>
        <script src="js/uber.js"></script>
        <script src="js/image_resize.js"> </script>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Sans:600|Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>

        <body>
            <!-- global header -->
            <ul class='global-header'>
                <li class='global-header-list'><a href='logout.php'>Sign Out</a></li>
                <li class='global-header-list'><a href="browse.php">Browse</a></li>
                <li class='global-header-list'><a href="home.php">Home</a></li>
                <li class='global-header-list'><a href="home.php#aboutUs">About Us</a></li>
                <li class='global-header-list-left' style = "color: white; margin-top: 1.2%; margin-right: 15%;" align = center>
                    <?php echo "Welcome! ".ucfirst($first_name)?>
                </li>
            </ul>
            <!-- global header end -->

            <!--Clouds animation added -->
            <div id="Clouds">
                <div class="Cloud Foreground"></div>
                <div class="Cloud Background"></div>
                <div class="Cloud Foreground"></div>
                <div class="Cloud Background"></div>
                <div class="Cloud Foreground"></div>
                <div class="Cloud Background"></div>
                <div class="Cloud Background"></div>
                <div class="Cloud Foreground"></div>
                <div class="Cloud Background"></div>
                <div class="Cloud Background"></div>
                <!--  <svg viewBox="0 0 40 24" class="Cloud"><use xlink:href="#Cloud"></use></svg>-->
            </div>

            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="40px" height="24px" viewBox="0 0 40 24" enable- xml:space="preserve">
            <defs>
                <path id="Cloud" d="M33.85,14.388c-0.176,0-0.343,0.034-0.513,0.054c0.184-0.587,0.279-1.208,0.279-1.853c0-3.463-2.809-6.271-6.272-6.271
                c-0.38,0-0.752,0.039-1.113,0.104C24.874,2.677,21.293,0,17.083,0c-5.379,0-9.739,4.361-9.739,9.738
                c0,0.418,0.035,0.826,0.084,1.229c-0.375-0.069-0.761-0.11-1.155-0.11C2.811,10.856,0,13.665,0,17.126
                c0,3.467,2.811,6.275,6.272,6.275c0.214,0,27.156,0.109,27.577,0.109c2.519,0,4.56-2.043,4.56-4.562
                C38.409,16.43,36.368,14.388,33.85,14.388z"/>
            </defs>
        </svg>
        <!--Profile page UI-->

        <div class="container">
            <section id="Profile">
                <form action="profileUpdate.php" method = "post">
                <div id="user" class="text-center">
                    <!-- <div id="img" alt="your image"></div> -->
                    <div class="profile-image">
                        <?php $defaultImage ="http://placehold.it/200"; ?>
                        <img id="profile"  src=<?php  echo $user_image ?> onerror=<?php echo $defaultImage ?> alt="your_image" style="max-width:100px; " />
                        <h6><input type='file' name="user_image" onchange="readURL(this , 'profile','200px');" /></h6>
                    </div>
                    <div id="name">
                        <h3><?php echo ucfirst($first_name) ?> <?php echo ucfirst($last_name) ?></h3>
                        <!-- <h5><?php echo $email ?> | <?php echo $username ?></h5> -->
                        <h5><i class="fa fa-envelope"></i> <?php echo $email ?></h5>
                    </div >
                    <!--<div id="social"><a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a><a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook-f fa-stack-1x"></i></span></a><a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-dribbble fa-stack-1x"></i></span></a><a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-behance fa-stack-1x"></i></span></a></div>-->
                </div>
                    <button type="submit" class="btn btn-default btn-lg">Upload Picture</button>
                </form>
                <div id="content">
                    <div id="navigation">
                        <ul role="tablist" class="nav nav-tabs nav-justified">
                            <div class="profileNav">
                                <i id="password-nav-icon" class="fa fa-key fa-3x password-nav" style="transform: rotate(-45deg);">
                                    <span id="password-nav-text" class="text-overlay" style="transform: rotate(45deg);" onclick="window.location='#password-tab';">Password</span>
                                </i>
                            </div>
                            <div class="profileNav">
                                <i id="profile-nav-icon" class="fa fa-user fa-3x profile-nav">
                                    <span id="profile-nav-text" class="text-overlay" onclick="window.location='#profile-tab';">Profile</span>
                                </i>
                            </div>
                            <div class="profileNav">
                                <i id="tickets-nav-icon" class="fa fa-ticket fa-3x tickets-nav" style="transform: rotate(45deg);">
                                    <span id="tickets-nav-text" class="text-overlay" style="transform: rotate(-45deg);" onclick="window.location='#tickets-tab';">Tickets</span>
                                </i>
                            </div>

                            <!-- <div id="password-nav password-nav-text" class="profileNav text-overlay" style="right: 1%">
                                <p href="#password-tab">Password</p>
                            </div>
                            <div id="profile-nav profile-nav-text" class="profileNav text-overlay" style="right: 21%">
                                <p href="#profile-tab">Profile</p>
                            </div>
                            <div id="tickets-nav tickets-nav-text" class="profileNav text-overlay" style="right: 41%">
                                <p href="#tickets-tab">Tickets</p>
                            </div> -->

                        </ul>
                        <div class="tab-content">
                            <div id="tickets-tab" role="tabpanel" class="tab-pane fade">
                                <h3>Tickets</h3>
                                <div id="stats" role="tabpanel">
                                    <div class="row">
                                        <div class="col s10" style="width:100%">
                                            <div id="card-stats">
                                                <div class="row">
                                                    <div class="col s12 m6 l3" style = "width:50%;">
                                                        <div class="card">
                                                            <div class="card-content cyan white-text">
                                                                <p class="card-stats-title">
                                                                    <i class="material-icons"></i>Upcoming Events</p>
                                                                <h4 class="card-stats-number"><?php echo $upevents["upevents"]; ?>

                                                                </h4>
                                                                <p class="card-stats-compare">
                                                                    <i class="material-icons"></i> <?php echo $nextweek["nextweek"]; ?>
                                                                    <span class="cyan text text-lighten-5">scheduled next week</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6 l3" style = "width:50%;">
                                                        <div class="card">
                                                            <div class="card-content teal white-text">
                                                                <p class="card-stats-title">
                                                                    <i class="material-icons"></i>Past events</p>
                                                                <h4 class="card-stats-number"><?php echo $pastevents["pastevents"]; ?></h4>
                                                                <p class="card-stats-compare">
                                                                    <i class="material-icons"></i> <?php echo $lastmonth["lastmonth"]; ?>
                                                                    <span class="teal text text-lighten-5">in the last month</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label id='upcoming-events'><p class="ticket-label" onclick="displayUpcomingEvents();"> Upcoming Events </p></label>
                                <label id='past-events'><p class="ticket-label" onclick="displayPastEvents()"> Past Events </p></label>
                                <p style="visibility: hidden; line-height:0;">tickets</p>
                                <div id="tickets">
                                    <!-- <div class="ticket">
                                        <div class="ticket-image-container">

                                        </div>
                                        <div class="ticket-info-container">
                                            <h5>Title</h5>
                                            <p>date</p>
                                            <p>location</p>
                                            <p>order_number</p>
                                            <div class="ticket-btn"> View Ticket </div>
                                        </div>
                                    </div> -->
                                </div>
                                <script type="text/javascript">
                                var upcoming_tickets = <?php echo json_encode($upcoming_tickets); ?>;
                                var past_tickets = <?php echo json_encode($past_tickets); ?>;
                                displayUpcomingEvents();
                                window.location = "#tickets-tab";
                                </script>
                            </div>
                            <div id="profile-tab" role="tabpanel" class="tab-pane fade">
                                <h3>Edit Profile</h3>
                                <form action="profileUpdate.php" method = "post">
                                    <div class="form-group">
                                        <!-- <label for="nameMessage">First Name</label> -->
                                        <input name ="firstName" type="text" placeholder="First Name" class="form-control input-lg"/>
                                        <!-- <label for="nameMessage">Last Name</label> -->
                                        <input name ="lastName" type="text" placeholder="Last Name" class="form-control input-lg"/>
                                        <!-- <label for="email">Email</label> -->
                                        <input type="email" name ="email" placeholder="Email Address" class="form-control input-lg"/>
                                         <!-- <label for="email">Username</label> -->
                                        <input type="text" name ="username" placeholder="Username" class="form-control input-lg"/>
                                        <button type="submit" class="btn btn-default btn-lg">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                            <div id="password-tab" role="tabpanel" class="tab-pane fade">
                                <h3>Reset Password</h3>
                                <form action="profileUpdate.php" method = "post">
                                    <div class="form-group">
                                        <!-- <label for="nameMessage">Current Password</label> -->
                                        <input name ="current_password" type="password" placeholder="Current Password" class="form-control input-lg"/>
                                        <!-- <label for="nameMessage">New Password</label> -->
                                        <input name ="new_password" type="password" placeholder="New Password" class="form-control input-lg"/>
                                        <!-- <label for="email">Verify Passwordl</label> -->
                                        <input name ="verify_password" type="password" placeholder="Verify Password" class="form-control input-lg"/>
                                        <button type="submit" class="btn btn-default btn-lg">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        <div id="ticket-popup" class="overlay">
            <div class="popup-container">
                <a class="popup-close" onclick="removeTicketDetailDisplay()" href="#tickets-tab">&times;</a>
                <h5> Ticket Detail </h5>
                <div class="popup-line"></div>
                <div id="ticket-popup-content"></div>
                <input target= "_blank" type="image" class="approve" img style= "width:160px; height:40px; margin-top:10px" src="./images/uber_image/UBER_API_Button_1x_Black_12px_round.png">
                <!-- <div class="ticket-btn"> Cancel Ticket </div> -->
                <script>
                    $(".approve").click(function(event){
	// Redirect to Uber API via deep-linking to the mobile web-app
	var uberURL = "https://m.uber.com/sign-up?";
      //var uberURL = "https://login.uber.com/oauth/v2/authorize?response_type=code&";

	// Add parameters
	uberURL += "client_id=" + uberClientId;
	if (typeof userLatitude != typeof undefined) uberURL += "&" + "pickup_latitude=" + userLatitude;
	if (typeof userLongitude != typeof undefined) uberURL += "&" + "pickup_longitude=" + userLongitude;
	uberURL += "&" + "dropoff_latitude=" + partyLatitude;
	uberURL += "&" + "dropoff_longitude=" + partyLongitude;
	uberURL += "&" + "dropoff_nickname=" + "Thinkful";

	// Redirect to Uber
	window.open(uberURL);
});
                    </script>
            </div>
        </div>



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
