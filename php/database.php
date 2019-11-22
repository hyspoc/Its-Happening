<?php
/*
 * Caution: Need to call $conn->close() after including this file
 */

$db_server = 'itshappening.cirqh9bougik.us-east-2.rds.amazonaws.com';
$db_username = 'admin';
$db_password = "it'shappening123";
$db_name = 'itshappening';
$conn = new mysqli($db_server, $db_username, $db_password, $db_name) or die('Unable to connect to Database');

function sendQuery($cmd) {
    global $conn;

    $conn->set_charset('utf8');
    // $result = $conn->query(strtolower($cmd));
    $result = $conn->query($cmd);

    // if result has 0 rows
    /* SELECT:
     *  result has multiple rows -> return obj
     *  result has 0 rows -> return false
     *
     * INSERT/DELETE/UPDATE/...
     *  successful -> return true
     *  unsuccessful -> return false
     */
    if (gettype($result)=="boolean" or $result->num_rows > 0) {
        return $result; // to read: $result->fetch_assoc()["$column_name"]
    } else {
        return false;
    }

    $conn->close();
}
