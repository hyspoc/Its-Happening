<?php
include 'php/database.php';

if( $_POST["action"] == "approve"){
	$query = "UPDATE organizer SET status = 'approved' WHERE org_id=" . $_POST["org_id"];
}
else if( $_POST["action"] == "reject"){
	$query = "UPDATE organizer SET status = 'rejected' WHERE org_id=" . $_POST["org_id"];
}

$result = sendQuery( $query);
print_r( $result);

?>