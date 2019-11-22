<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
}

require("php/database.php");

$user_query = sendQuery("SELECT * FROM organizer WHERE username='$username'");
if($user_query) {
    $user = $user_query->fetch_assoc();
    $approved = $user['status'];
    if ($user['status'] != 'approved') {
        echo '<script type="text/javascript"> alert("You have not been approved to create event."); location="index.php"; </script>';
    }
    $first_name = $user['first_name'];
} else {
    echo '<script type="text/javascript"> alert("You are not loggd in as organizer."); location="login.php"; </script>';
}
?>

<html>
    <head>
        <title>It's Happening!</title>
        <link href="css/global-header.css" rel="stylesheet">
        <link href="css/create-event.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src = "js/createEvent_controller.js"></script>

        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWSGjbWVPrgs4vUmHdwF2g3BESzF_E0G8"></script> -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuMrO8-BJdTVOPdTA_uxS5tlIsW3alQX0"></script>
    </head>
    <body>
        <ul class='global-header'>
            <li class='global-header-list'><a href='logout.php'>Sign Out</a></li>
            <li class='global-header-list'><a href="index.php">Dashboard</a></li>
            <li class='global-header-list'><a href="home.php#aboutUs">About Us</a></li>
            <li class='global-header-list-left' style = "color: white; margin-top: 1.2%; margin-right: 15%;" align = center>
                <?php if (isset($username)) {echo "Welcome! ".ucfirst($first_name);}?>
            </li>
        </ul>

        <div id='eventForm'>
            <h1 align='center'> Event Creation Form </h1>
            <div class="form-style-5">
                <form >
                    <fieldset>
                        <legend><span class="number">1</span> Event Info</legend>
                        <input type="text" id="eventname" placeholder="Event Name *" onkeyup='saveValue(this);'/>
                        <input type="text" id="eventvenue" placeholder="Venue *" onkeyup='saveValue(this);'/>
                        <input type="date" id="date" placeholder="Date *" onchange='saveValue(this);'/>
                        <input type="time" id="time" placeholder="Time" onkeyup='saveValue(this);'/>
                        <input type="text" id="twitterlink" placeholder="Twitter Link " onkeyup='saveValue(this);'/>
                        <input type="text" id="facebooklink" placeholder="Facebook Link " onkeyup='saveValue(this);'/>
                        <input type="text" id="event_website" placeholder="Website Link " onkeyup='saveValue(this);'/>
                        <textarea id="description" placeholder="Event Description" onkeyup='saveValue(this);'></textarea>
                        <label for="job">Event Category:</label>
                        <select id="job" name="type" onchange='saveValue(this);'>
                            <option value="">Select</option>
                            <option value="Music">Music</option>
                            <option value="Arts">Arts</option>
                            <option value="Food">Food & Drinks</option>
                            <option value="Party">Party</option>
                            <option value="Sports">Sports</option>
                            <option value="Business">Business</option>
                        </select>
                    </fieldset>
                    <fieldset>
                        <legend><span class="number">2</span>Ticket Info</legend>

                        <div style="display: flex;">
                            <input type="checkbox" id="general" onchange='saveValue(this);'>
                            <label for="general">General</label>
                            <input style="width: 15%; margin-left: 2%; "type="text" id="general-price" placeholder="$0.00" onkeyup='saveValue(this);'/>
                            <input style="width: 35%; margin-left: 2%; "type="text" id="general-avail" placeholder="Tickets Available" onkeyup='saveValue(this);'/>
                        </div>
                        <div style="display: flex;">
                            <input type="checkbox" id="vip" onchange='saveValue(this);'>
                            <label for="vip">VIP</label>
                            <input style="width: 15%; margin-left: 2%; " type="text" id="vip-price" placeholder="$0.00" onkeyup='saveValue(this);'/>
                            <input style="width: 35%; margin-left: 2%; "type="text" id="vip-avail" placeholder="Tickets Available" onkeyup='saveValue(this);'/>

                        </div>
                        <div style="display: flex;">
                            <input type="checkbox" id="student" onchange='saveValue(this);'>
                            <label for="vip">Student</label>
                            <input style="width: 15%; margin-left: 2%; " type="text" id="student-price" placeholder="$0.00" onkeyup='saveValue(this);'/>
                            <input style="width: 35%; margin-left: 2%; "type="text" id="student-avail" placeholder="Tickets Available" onkeyup='saveValue(this);'/>

                        </div>
                        <div style="display: flex;">
                            <input type="checkbox" id="featured" onchange='set_featured(this);'>
                            <label for="vip">Featured Event</label>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend><span class="number">3</span> Additional Info</legend>
                        <textarea id="add_info" placeholder="Additional information about event" onkeyup='saveValue(this);'></textarea>
                    </fieldset>
                    <fieldset>
                        <legend><span class="number">4</span>Event Images</legend>
                        <p> Primary Image *</p>
                        <input type='file' onchange="readURL(this , 'primary');" />
                        <img id="primary" src="http://placehold.it/100" alt="your image" style="max-width:100px;" />
                        <p> Additional Image </p>
                        <input type='file' onchange="readURL(this , 'eventimg2','100px');" />
                        <img id="eventimg2" src="http://placehold.it/100" alt="your image" style="max-width:100px;"/>
                        <input type='file' onchange="readURL(this , 'eventimg3' ,'100px'); " />
                        <img id="eventimg3" src="http://placehold.it/100" alt="your image" style="max-width:100px;" />
                    </fieldset>
                    <!-- <input type="submit" onclick="setValues();" value="Test Button" /> -->
                    <input type="submit" onclick="setValues();" value="Create Event" />
                </form>
            </div>
        </div>

          <div id="organizerPayPopup" class="overlay">
            <div class="popup-container checkoutPopup-container">
                <a class="popup-close"  href="#" onclick="clearValues()">&times;</a>
                <h3 class="popup-title"> Your Order </h3>
                <div class="popup-line"></div>
                <div id="checkoutPopup-content">
                    <p>Subtotal:  <span id="checkout-subtotal"> $100.00 </span></p>
                    <!-- <p id="checkout-coupon" style="display:none"> Coupon: </p> -->
                    <!-- <p id="checkout-discount" style="display:none"> Discount: </p> -->
                    <p>Tax:  <span id="checkout-tax"> $7.00 </span></p>
                    <p>Total:  <span id="checkout-total"> $107.00 </span></p>
                    <!-- <p id="checkout-tax"> Tax: $7.00 </p> -->
                    <!-- <p id="checkout-total"> Total: $107.00 </p> -->
                </div>
                <div class="paypal-button-container">
                    <div id="paypal-button"></div>
                </div>
            </div>
        </div>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <script> paypalCheckoutOrganizer(); </script>

        <script type="text/javascript">
        document.getElementById("eventname").value = getSavedValue("eventname");
        document.getElementById("eventvenue").value = getSavedValue("eventvenue");
        document.getElementById("date").value = getSavedValue("date");
        document.getElementById("time").value = getSavedValue("time");
        document.getElementById("twitterlink").value = getSavedValue("twitterlink");
        document.getElementById("facebooklink").value = getSavedValue("facebooklink");
        document.getElementById("event_website").value = getSavedValue("event_website");
        document.getElementById("description").value = getSavedValue("description");
        document.getElementById("job").value = getSavedValue("job");
        document.getElementById("general").checked = getSavedValue("general");
        document.getElementById("general-price").value = getSavedValue("general-price");
        document.getElementById("general-avail").value = getSavedValue("general-avail");
        document.getElementById("vip").checked = getSavedValue("vip");
        document.getElementById("vip-price").value = getSavedValue("vip-price");
        document.getElementById("vip-avail").value = getSavedValue("vip-avail");
        document.getElementById("student").checked = getSavedValue("student");
        document.getElementById("student-price").value = getSavedValue("student-price");
        document.getElementById("student-avail").value = getSavedValue("student-avail");
        document.getElementById("featured").checked = getSavedValue("featured");
        document.getElementById("add_info").value = getSavedValue("add_info");
        checkoutValues();
        </script>

        <!-- LiveChat (www.livechatinc.com) -->
        <!-- <script type="text/javascript">
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
        </noscript> -->
        <!-- LiveChat End -->
    </body>

</html>
