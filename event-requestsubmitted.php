<?php
session_start();
if (isset($_SESSION['username'])) {
    $organizer = $_SESSION['username'];
} else {
	echo '<script type="text/javascript"> alert("Aw, Snap! Something went wrong"); location="login.php"; </script>';
}

include 'php/database.php';

$event_name = $_POST["eventname"];
$event_date = $_POST["date"];
$event_desc = $_POST["description"];
$event_add_info = $_POST["add_info"];
$event_venue = $_POST["eventvenue"];
$latitude = floatval($_POST["latitude"]);
$longitude = floatval($_POST["longitude"]);
$event_type = $_POST["type"];
$event_website = $_POST["event_website"];
$event_twitter = $_POST["twitterlink"];
$event_facebook = $_POST["facebooklink"];
$event_amt = floatval($_POST["event_amt"]);
$unique_str_id = md5(date('Y-m-d-h-m-s').$event_name);
$tickets = $_POST["tickets"];

$event_query = "INSERT INTO events
(name, organizer, description, add_info, date, venue, latitude, longitude, type, event_website, twitter, facebook, event_amt, unique_str_id) VALUES
('$event_name', '$organizer', '$event_desc', '$event_add_info', '$event_date', '$event_venue', $latitude, $longitude, '$event_type', '$event_website', '$event_twitter', '$event_facebook', $event_amt, '$unique_str_id')";
sendQuery($event_query);

$event_id_query = "SELECT event_id FROM events WHERE unique_str_id = '$unique_str_id'";
$event_id_raw = sendQuery($event_id_query);
if ($event_id_raw) {
    $event_raw = ($event_id_raw->fetch_assoc());
    $event_id = $event_raw['event_id'];

    for ($i = 0; $i != count($tickets); ++$i) {
        $type = ucfirst($tickets[$i]['type']);
        $qty = intval($tickets[$i]['quantity']);
        $price = floatval($tickets[$i]['price']);
        $ticket_query = "INSERT INTO event_ticket (event_id, type, price, total_tickets) VALUES ($event_id, '$type', $price, $qty)";
        sendQuery($ticket_query);
    }

    if($_POST["featured"]) {
        sendQuery("INSERT INTO featured_events (event_id) VALUES ($event_id)");
    }
}

?>
