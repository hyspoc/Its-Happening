<?php
require("php/database.php");
$reg = $_POST['reg_id'];
sendQuery("DELETE FROM event_registration WHERE reg_id = '$reg'");
