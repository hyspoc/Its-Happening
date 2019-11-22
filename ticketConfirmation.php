<?php
require("php/database.php");
require("php/email/email.php");

$order_num = md5(uniqid(rand(), TRUE));
sendTicketConfirmation($_POST["dest_addr"], $_POST['event_title'], $_POST['order_detail'], $order_num);

$username = $_POST['username'];
$email = $_POST['dest_addr'];
$ids = $_POST['ticket_ids'];
$qtys = $_POST['ticket_qtys'];

for ($i = 0; $i != min(count($ids), count($qtys)); ++$i) {
    $id = intval($ids[$i]);
    $qty = intval($qtys[$i]);
    sendQuery("INSERT INTO event_registration (order_number, ticket_id, username, email, quantity) VALUES ('$order_num', $id, '$username', '$email', $qty)");
}
