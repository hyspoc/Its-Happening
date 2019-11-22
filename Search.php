<?php
include 'php/database.php';
include 'php/ChromePhp.php';
$event_query = "SELECT * FROM events WHERE organizer IN (SELECT username FROM organizer WHERE status='approved')";

if(isset($_POST["indicator"]) || isset($_POST["keyword"])) {
    if( $_POST["indicator"] != null){
        $indicator = $_POST["indicator"];
        $event_query = $event_query . " AND type='" . $indicator . "'";
    }
    else if( $_POST["keyword"] != null){
        $keyword = $_POST["keyword"];
        $event_query = $event_query . " AND (name LIKE '%$keyword%' OR description LIKE '%$keyword%')";
    }
}

else if(isset($_POST["orderfromtoday"])) {
    $event_query=$event_query. "AND date > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY) ORDER BY date";
}
else if(isset($_POST["eventdetails"])) {
    //For total number of tickets sold
    $event_query = "SELECT count(*) as cnt FROM events, event_ticket WHERE events.event_id = event_ticket.event_id and event_ticket.event_id = '" . $_POST["eventId"] . "'";

    $events = sendQuery($event_query);

    $events_count = 0;
    if ($events) {
        while($row = $events->fetch_assoc())  {
            $events_count = $row;
        }
    }

    $event_query = "SELECT sum(price) as revenue FROM event_ticket et, events e WHERE et.event_id = e.event_id and et.event_id = '" . $_POST["eventId"] . "' ";

    $events = sendQuery($event_query);
    $events_revenue = 0.00;

    if ($events) {
        while($row = $events->fetch_assoc())  {
            $events_revenue = $row;

        }
    }
    //echo var_dump($events_revenue);

    $myObj = (object) [
        'count' => $events_count["cnt"],
        'revenue' => $events_revenue["revenue"],
    ];
    echo json_encode($myObj);
    exit;

}

$events = sendQuery($event_query);
$events_array = array();

if ($events) {
    while($row = $events->fetch_assoc())  {
        // $formatted_date = date("D • M jS Y • g:i A", strtotime($event_date));

        $row['date'] = date("D • M jS Y", strtotime($row['date']));
        $events_array[] = $row;
        // ChromePhp::log($row['date']);
    }
}

echo json_encode($events_array);

?>
