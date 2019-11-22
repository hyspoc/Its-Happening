<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
if (isset($_GET["event_id"])) {
    $event_id = $_GET["event_id"];
} else {
    $_SESSION['event_id'] = "";
    session_abort();
}
require("php/database.php");

$user_email = '';
$is_customer = false;
$is_organizer = false;
if(isset($username)) {
    $customer_query = sendQuery("select email from customer where username = '$username'");
    if($customer_query) {
        $user_email = $customer_query->fetch_assoc()['email'];
        $is_customer = true;
        $is_organizer = false;
    } else {
        $organizer_query = sendQuery("select * from organizer where username = '$username'");
        $is_organizer = boolval($organizer_query);
    }
}

sendQuery("UPDATE events SET view=view+1 WHERE event_id=$event_id;");
$event = sendQuery("select * from events where event_id = '$event_id'")->fetch_assoc();
$name = $event['name'];
$organizer_username = $event['organizer'];
$description = $event['description'];
$event_date = $event['date'];
$venue = $event['venue'];
$latitude = $event['latitude'];
$longitude = $event['longitude'];
$type = $event['type'];
$primary_image = $event['image'];
$facebook = $event['facebook'];
$twitter = $event['twitter'];
$viewed = $event['view'];

$organizer = sendQuery("select * from organizer where username = '$organizer_username'");
if ($organizer) {
    $organizer = $organizer->fetch_assoc();
    if ($organizer['status'] != 'approved') {
        http_response_code(404);
        header("Location: 404NotFound.php");
        die();
    }
    $organizer_company_name = $organizer['company_name'];
};

$images = sendQuery("select image from event_image where event_id = '$event_id'");
$tickets_raw = sendQuery("select * from event_ticket where event_id = '$event_id'");

$tickets = array();
while($tickets_raw && $ticket = $tickets_raw->fetch_assoc()) {
    array_push($tickets, $ticket);
}

$coupon_raw = sendQuery("select * from coupon");
$coupons = array();
$discounts = array();
while ($coupon_raw && $coupon = $coupon_raw->fetch_assoc()) {
    array_push($coupons, $coupon['coupon']);
    array_push($discounts, $coupon['discount']);
}

$coupons = json_encode($coupons);
$discounts = json_encode($discounts);
?>

<html>
    <head>
        <title>It's Happening!</title>
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/event.css" rel="stylesheet">
        <link href="css/global-header.css" rel="stylesheet">
        <link href="css/slides.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/slides.js"></script>
        <script src="js/map.js"></script>
        <script src="js/event_controller.js"></script>
        <script src="js/image_resize.js"> </script>
    </head>

    <body>
        <script type="text/javascript">
            var username = <?php echo json_encode($username); ?>;
            var event_id = <?php echo json_encode($event_id); ?>;
            var lat = <?php echo json_encode($latitude); ?>;
            var lng = <?php echo json_encode($longitude); ?>;
            var name = <?php echo json_encode($name); ?>;
            var type = <?php echo json_encode($type); ?>;
            var user_email = <?php echo json_encode($user_email); ?>;
            var tickets = <?php echo json_encode($tickets) ?>;
            var viewd = <?php echo json_encode($view) ?>;
            var coupons = JSON.parse(<?php echo json_encode($coupons); ?>);
            var discounts = JSON.parse(<?php echo json_encode($discounts); ?>).map(parseFloat);
            var is_organizer = <?php echo json_encode($is_organizer); ?>;
            var is_customer = <?php echo json_encode($is_customer); ?>;
        </script>

        <!-- global header -->
        <ul class='global-header'>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<li class='global-header-list'><a href='logout.php?'>Sign Out</a></li>";
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
            <li class='global-header-list'><a href="home.php">Home</a></li>
            <li class='global-header-list'><a href="home.php#aboutUs">About Us</a></li>
            <li class='global-header-list-left' style = "color: white; margin-top: 1.2%; margin-right: 15%;" align = center>
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


        <!-- <div class="banner-map-container"> -->
        <!-- banner -->
        <div id="banner-container">
            <?php
            echo "
            <div class='slides slides-fade'>
            <img src='" . $primary_image . "'/>
            <script> resizeImage('banner-container', 0); </script>
            </div>
            ";

            if ($images) {
                $counter = 1;

                while($images && $image = $images->fetch_assoc()['image']) {
                    echo "<div class='slides slides-fade'>
                    <img src='" . $image . "'/>
                    <script> resizeImage('banner-container', $counter); </script>
                    </div>";
                    $counter++;
                }

                if ($counter>1) {
                    echo "<div class='slides-dot-container'>";

                    for($i = 0; $i != $counter; $i++) {
                        echo "<span class='slides-dot' onclick='slideSet(" . $i . ")'></span>";
                    }

                    echo "</div>";
                }
            }
            ?>
            <script>showSlides();</script>
    </div>
        <!-- banner end -->

        <div class="event-info-container">
            <div class='bookTickets-btn' onclick="showBookTickets()"> Book Tickets</div>
            <div class="viewed"> Views: <?php echo $viewed; ?> </div>
            <div class="event-info" style="padding-top:5px; width: auto;">
                <?php echo "<h4>$name</h4>"; ?>
            </div>
            <div class="event-info" style="width:80%;">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <?php
                    $formatted_date = date("D • M jS Y • g:i A", strtotime($event_date));
                    echo " $formatted_date ";
                ?>
            </div>
            <div class="event-info">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <?php echo " $venue "; ?>
            </div>
            <div class="event-info">
                <h6>
                    <span style="padding-right: 30px;">
                        <?php echo "Created by: $organizer_company_name  "; ?>
                    </span>
                    <?php
                        if ($facebook != null) {
                            echo "<span> <a href='$facebook' target='_blank'><i class='fa fa-facebook' style='padding-left: 4px; line-height:20px; background: #3B5998;'></i></a></span>";
                        }
                        if ($twitter != null) {
                            echo "<span> <a href='$twitter' target='_blank'><i class='fa fa-twitter' style='padding-left: 3px; line-height:20px; background: #55ACEE;'></i></a></span>";
                        }
                    ?>
                </h6>
            </div>
            <div class="event-info">
                <?php echo "<p>$description</p>"; ?>
            </div>

            <!-- map -->
            <div id="map"></div>
            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuMrO8-BJdTVOPdTA_uxS5tlIsW3alQX0&callback=initMap">
            </script>
            <!-- map end -->

            <div style="height:13px"></div>

        </div>

        <div id='bookTicketsPopup' class="overlay">
            <div class='popup-container'>
                <a class="popup-close" href="#">&times;</a>
                <h5 class="popup-title"> Tickets </h5>
                <table class='ticket-table'>
                    <tr>
                        <th>Section</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                    <?php
                        for ($i = 0; $i != count($tickets); ++$i) {
                            $ticket_type = $tickets[$i]['type'];
                            $ticket_price = "$" . $tickets[$i]['price'];

                            echo "<tr>
                                <td id='ticket-type$i'>$ticket_type</td>
                                <td id='ticket-price$i'>$ticket_price</td>
                                <td class=>
                                    <p>
                                        <span class='ticket-quantity-setter ticket-quantity-setter-left' onclick='updateTicketQuantity($i, -1)'> &minus; </span>
                                        <span class='ticket-quantity' id='ticket-quantity$i'> 0 </span>
                                        <span class='ticket-quantity-setter ticket-quantity-setter-right' onclick='updateTicketQuantity($i, 1)'> &plus; </span>
                                    </p>
                                </td>
                            ";
                        }
                    ?>
                </table>

                <div class='coupon-container'>
                    <input id='coupon' class='coupon' type='text' placeholder='Coupon    ' required=''/>
                </div>

                <div class='price-container'>
                    <p> Subtotal: $ <span id='subtotal'>0.00 </span></p>
                </div>

                <div class='checkout-btn' onclick='getOrderDetailsPopUp()'> Check Out </div>
            </div>
        </div>

        <div id="checkoutPopup" class="overlay">
            <div class="popup-container checkoutPopup-container">
                <a class="popup-back" onclick="removeOrderDetails()" href="#bookTicketsPopup"> &larr; </a>
                <a class="popup-close" onclick="removeOrderDetails()" href="#">&times;</a>
                <h5 class="popup-title"> Your Order </h5>
                <div class="popup-line"></div>
                <div id="checkoutPopup-content"></div>
                <div class="checkoutPopup-line"></div>
                <p id="checkout-subtotal"> Subtotal: </p>
                <p id="checkout-coupon" style="display:none"> Coupon: </p>
                <p id="checkout-discount" style="display:none"> Discount: </p>
                <p id="checkout-tax"> Tax: </p>
                <p id="checkout-total"> Total: </p>
                <div class="paypal-button-container">
                    <div id="paypal-button"></div>
                    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                    <script> paypalCheckout(); </script>
                </div>
            </div>
        </div>

        <div id='guestPopup' class="overlay">
            <div class="popup-container">
                <a class="popup-back" href="#bookTicketsPopup"> &larr; </a>
                <a class="popup-close" href="#">&times;</a>
                <div class="guestPopup-container">
                    <?php
                    if ($is_organizer) {
                        echo "<p> Your organizer account doesn't have access to booking tickets, please </p>";
                    }
                    ?>
                    <div class="guest-btn" onclick="window.open('login.php', '_blank')"> Sign In / Sign Up </div>
                    <p> OR </p>
                    <div>
                        <input id='guestEmail' type='text' placeholder="Email: " required=''/>
                        <div class="guest-btn" onclick="setGuestEmail();"> Guest Checkout </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="related-events-container">
            <h5 style="padding-left:50px"> Events You May Like ... </h5>
            <?php
                $related_events = array();
                $today = date('Y-m-d h:i:s');

                /* retrieve events hosted by this organizer */
                $org_events = sendQuery("select * from events where organizer='$organizer_username' and event_id!='$event_id' and date(date)>date('$today') ORDER BY date ASC");
                while (sizeof($related_events)<4 && $org_events && $org_event=$org_events->fetch_assoc()) {
                    array_push($related_events, $org_event);
                }

                $categ_events = sendQuery("select * from events where type='$type' and event_id!='$event_id' and date(date)>date($today) ORDER BY date ASC");
                while (sizeof($related_events)<4 && $categ_events && $categ_event=$categ_events->fetch_assoc()) {
                    array_push($related_events, $categ_event);
                }

                for($i = 0; $i != sizeof($related_events); $i++) {
                    $rel_id = $related_events[$i]['event_id'];
                    $rel_image = $related_events[$i]['image'];
                    $rel_name = $related_events[$i]['name'];
                    $rel_date = $related_events[$i]['date'];
                    // echo "<script> console.log($rel_date); </script>";
                    $rel_day = date("j", strtotime($rel_date));
                    $rel_month = date("M", strtotime($rel_date));
                    $rel_year = date("Y", strtotime($rel_date));

                    echo "
                    <div class='related_events card'>
                       <div class='wrapper'>
                          <div class='date'>
                            <span class='day'>$rel_day</span>
                            <span class='month'>$rel_month</span>
                            <span class='year'>$rel_year</span>
                          </div>
                          <div class='img' id='related-event-img$i'>
                                <img src = '$rel_image'/>
                                <script> resizeImage('related-event-img$i', 0) </script>
                          </div>
                          <div class='data'>
                            <div class='content'>
                              <span class='author'><a href='event.php?event_id=$rel_id'>$rel_name</a></span>
                           </div>
                            <input type='checkbox' id='show-menu' />
                          </div>

                        </div>
                    </div>
                    ";
                }
            ?>
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
