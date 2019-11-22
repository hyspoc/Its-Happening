<?php
session_start();
if (isset($_SESSION['username'])) {
    if($_SESSION['username'] != 'admin') {
        echo '<script type="text/javascript"> alert("Sorry, you do not have access to this page."); location="login.php"; </script>';
    }
}

include 'php/database.php';

$query = "SELECT * FROM organizer WHERE status='pending'";

$eventsObj = sendQuery($query);
$events = array();

if ($eventsObj) {
    while($row = $eventsObj->fetch_assoc())  {
        $events[] = $row;
    }
}

$query1 = "SELECT * FROM organizer WHERE status='approved'";

$eventsObj1 = sendQuery($query1);
$approvedOrganizers = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $approvedOrganizers[] = $row1;
    }
}

//print_r( $approvedOrganizers); exit;

#Total events count
$query2 = "SELECT COUNT(*) as totaleventscount FROM events";

$eventsObj1 = sendQuery($query2);
$eventsCount = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $eventsCount = $row1;
    }
}
//print_r( $eventsCount); exit;

$query3 = "SELECT COUNT(*) as last30dayseventscount FROM events WHERE date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();";

$eventsObj1 = sendQuery($query3);
$last30DaysEventsCount = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $last30DaysEventsCount = $row1;
    }
}

$eventsInc = intval(( $last30DaysEventsCount["last30dayseventscount"]/($eventsCount["totaleventscount"] - $last30DaysEventsCount["last30dayseventscount"]))*100);
#Total Revenue
$query4 = "select sum(event_amt) as totalrevenue from events";

$eventsObj1 = sendQuery($query4);
$totalrevenue = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $totalrevenue = $row1;
    }
}

$query5 = "select sum(event_amt) as lastmonthrev from events where create_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();";

$eventsObj1 = sendQuery($query5);
$lastmonthrev = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $lastmonthrev = $row1;
    }
}

$revInc = intval(( $lastmonthrev["lastmonthrev"]/($totalrevenue["totalrevenue"] - $lastmonthrev["lastmonthrev"]))*100);

#Total registered users
$query6 = "SELECT count(username) as regusers from customer";

$eventsObj1 = sendQuery($query6);
$regusers = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $regusers = $row1;
    }
}

$query7 = "select count(*) as lastmonthusers from customer where create_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();";

$eventsObj1 = sendQuery($query7);
$lastmonthusers = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $lastmonthusers = $row1;
    }
}

$userInc = intval(( $lastmonthusers["lastmonthusers"]/($regusers["regusers"] - $lastmonthusers["lastmonthusers"]))*100);


#Registered organizers
$query8 = "SELECT count(*) as regorgs FROM organizer";

$eventsObj1 = sendQuery($query8);
$regorgs = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $regorgs = $row1;
    }
}

$query9 = "SELECT count(*) as lastmonthregorgs FROM organizer WHERE create_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();";

$eventsObj1 = sendQuery($query9);
$lastmonthregorgs = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $lastmonthregorgs = $row1;
    }
}


$orgInc = intval(( $lastmonthregorgs["lastmonthregorgs"]/($regorgs["regorgs"] - $lastmonthregorgs["lastmonthregorgs"]))*100);

#Admin revenue - Bar
$query9 = "SELECT monthname(create_date) AS month, sum(event_amt) AS 'totalrevenue' FROM events GROUP BY month(create_date);";

$eventsObj1 = sendQuery($query9);
$trevenue = array();

if ($eventsObj1) {
    while($row1 = $eventsObj1->fetch_assoc())  {
        $trevenue[] = $row1;
    }
}

?>


<html>
    <head>
        <title>It's Happening!</title>
        <link href="css/global-header.css" rel="stylesheet">
        <link href="css/bargraph.css" rel="stylesheet">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src = "js/createEvent_controller.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script src="js/dashboarddata.js"></script>
        <link href="css/home.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
    </head>
    <body style="background: white;">
        <ul class='global-header'>
            <li class='global-header-list'><a href='logout.php'>Sign Out</a></li>
        </ul>

        <div class="row">
          <div class="col s1"></div>
          <div class="col s10">
            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content cyan white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">person_outline</i>Registered users</p>
                      <h4 class="card-stats-number">
                        <?php echo $regusers["regusers"]; ?>
                      </h4>
                      <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_up</i> <?php echo $userInc; ?>%
                        <span class="cyan text text-lighten-5">from last month</span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content teal white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">person_outline</i>Registered organizers</p>
                      <h4 class="card-stats-number"><?php echo $regorgs["regorgs"]; ?></h4>
                      <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_up</i> <?php echo $orgInc; ?>%
                        <span class="teal text text-lighten-5">from last month</span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content red accent-2 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">attach_money</i>Revenue generated</p>
                      <h4 class="card-stats-number"><?php echo $totalrevenue["totalrevenue"]; ?></h4>
                      <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_up</i> <?php echo $revInc; ?>%
                        <span class="red-text text-lighten-5">from last month</span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content deep-orange accent-2 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">content_copy</i> Number of events</p>
                      <h4 class="card-stats-number">
                        <?php echo $eventsCount["totaleventscount"]; ?>
                      </h4>
                      <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_up</i> <?php echo $eventsInc; ?>%
                        <span class="deep-orange-text text-lighten-5">in the last month</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class = "row">
            <
            <div class="col s2">
            </div>

            <div class="col s8">
              <div align = "center" style="font-size:180%"><p style = "font-size: 30px;"> Revenue Generated by month </p></div>
              <ul class="chart col s10" style="height:500px;">

                <li class="axis">
                    <div class="label">100%</div>
                    <div class="label">80%</div>
                    <div class="label">60%</div>
                    <div class="label">40%</div>
                    <div class="label">20%</div>
                    <div class="label" style="margin:0;">0</div></li>
                <?php
                //echo json_encode($events_array7);
                    $totalCost = 0;
                    foreach( $trevenue as $event){
                        $totalCost = (int)$totalCost + (int)($event["totalrevenue"]);

                    }
                    //echo $totalCost;
                    $color = ["salmon","peach","lime","grape"];
                    $count = 0;
                    foreach( $trevenue as $event){
                      $percent = ceil((float)($event["totalrevenue"]/$totalCost) *100);

                    //echo $percent;
                    //$classper = "percentage-"+(string)$percent;
                    ?>

                <li class="bar <?php echo $color[$count]?>" style="height: <?php echo $percent?>%;" title="95">
                    <div class="skill"><?php echo $event["month"]." : $".$event["totalrevenue"];?></div>
                    <div class="percent" style="margin-top: 15%; font-size: 24px;"><?php echo $percent?><span>%</span></div>

                </li>
                <?php
                $count = $count+1;
                    }
                   ?>
<!--                <li class="bar salmon" style="height: 90%;" title="90">
                    <div class="percent">90<span>%</span></div>
                    <div class="skill">September 18</div>
                </li>
                <li class="bar peach" style="height: 80%;" title="80">
                    <div class="percent">80<span>%</span></div>
                    <div class="skill">October 18</div>
                </li>
                <li class="bar lime" style="height: 75%;" title="75">
                    <div class="percent">75<span>%</span></div>
                    <div class="skill">November 18</div>
                </li>
                <li class="bar grape" style="height: 40%;" title="40">
                    <div class="percent">40<span>%</span></div>
                    <div class="skill">December 18</div>
                </li>-->

            <hr style="margin: -4px 0 0 0; border: 1px solid #efefef;" />
            </ul>
          </div>
        </div>

        </div>
        <div class="row">

            <div class="col s1">
            </div>

            <div class="col s10">

        		<h3>List of organizers pending approval</h3>
                <ul class="collapsible">
                	<?php
                	for( $i=0; $i < count($events); $i++){
                	?>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">filter_drama</i><?php echo $events[$i]["username"]; ?></div>
                      	<div class="collapsible-body">
                      		<div class="row">
                      			<div class="col s2">Organization Name:</div>
                      			<div class="col s9"><?php echo $events[$i]["org_name"]; ?></div>

                      			<div class="col s2">Create time:</div>
                      			<div class="col s9"><?php echo $events[$i]["create_time"]; ?></div>

                                        <div class="col s2">Company Name:</div>
                      			<div class="col s9"><?php echo $events[$i]["company_name"]; ?></div>

                                        <div class="col s2">Email:</div>
                      			<div class="col s9"><?php echo $events[$i]["email"]; ?></div>

                                        <div class="col s2">Phone Number:</div>
                      			<div class="col s9"><?php echo $events[$i]["ph_num"]; ?></div>
                      		</div>
                      		<hr/>
                      		<div class="row">
                      			<div class="col s9"></div>
                      			<div class="col s3 action-buttons">
                      				<a class="waves-effect waves-light btn approve" data-orgid="<?php echo $events[$i]["org_id"]; ?>">Approve</a>
                      				<a class="waves-effect waves-light btn reject red" data-orgid="<?php echo $events[$i]["org_id"]; ?>">Reject</a>
                      			</div>
                      			<div class="s3 approved hide">
                      				<a class="btn disabled">Organizer approved</a>
                      			</div>
                      			<div class="s3 rejected hide">
                      				<a class="btn disabled">Organizer rejected</a>
                      			</div>
                      	</div>
                    </li>
                    <?php
                	}
                	?>

              </ul>
          </div>

        </div>
        <div class="row">

            <div class="col s1">
            </div>

            <div class="col s10">

        		<h3>List of approved organizers</h3>
                <ul class="collapsible">
                	<?php
                	for( $i=0; $i < count($approvedOrganizers); $i++){
                	?>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">filter_drama</i><?php echo $approvedOrganizers[$i]["username"]; ?></div>
                      	<div class="collapsible-body">
                      		<div class="row">
                      			<div class="col s2">Organization Name:</div>
                      			<div class="col s9"><?php echo $approvedOrganizers[$i]["org_name"]; ?></div>

                      			<div class="col s2">Create time:</div>

                      			<div class="col s9"><?php echo $approvedOrganizers[$i]["create_time"]; ?></div>

                                        <div class="col s2">Company Name:</div>
                      			<div class="col s9"><?php echo $approvedOrganizers[$i]["company_name"]; ?></div>

                                         <div class="col s2">Email:</div>
                      			<div class="col s9"><?php echo $approvedOrganizers[$i]["email"]; ?></div>

                                        <div class="col s2">Phone Number:</div>
                      			<div class="col s9"><?php echo $approvedOrganizers[$i]["ph_num"]; ?></div>

                      		</div>
                      		<hr/>
                      		<div class="row">
                      			<div class="col s9"></div>
                      			<div class="col s3 action-buttons">
                      				<!-- <a class="waves-effect waves-light btn approve" data-orgid="<?php echo $approvedOrganizers[$i]["org_id"]; ?>">Approve</a> -->
                      				<a class="waves-effect waves-light btn reject red" data-orgid="<?php echo $approvedOrganizers[$i]["org_id"]; ?>">Reject</a>
                      			</div>
                      			<div class="s3 approved hide">
                      				<a class="btn disabled">Organizer approved</a>
                      			</div>
                      			<div class="s3 rejected hide">
                      				<a class="btn disabled">Organizer rejected</a>
                      			</div>
                      	</div>
                    </li>
                    <?php
                	}
                	?>

              </ul>
          </div>

        </div>
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
    </body>
    <script>
    $(".approve").click( function(){
    	takeAction( $(this), $(this).data("orgid"), "approve");
    });

    $(".reject").click( function(){
    	takeAction( $(this), $(this).data("orgid"), "reject");
    });

    function takeAction( element, orgId, action){
    	$.ajax({
            method:"POST",
            url: "event-action.php",
            data: { org_id: orgId, action:action }
        }).done(function( data) {
        	console.log( data);
            var result = $.parseJSON( data);
            if( result == true){
            	if( action == "approve"){
            		element.parent().parent().children(".approved").removeClass("hide");
            		element.parent().addClass("hide");
            	}
            	if( action == "reject"){
            		element.parent().parent().children(".rejected").removeClass("hide");
            		element.parent().addClass("hide");
            	}
            }
        });
    }
	</script>
</html>
