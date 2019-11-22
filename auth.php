<?php
session_start();
include 'php/database.php';
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// This is a very ugly and stupid way to handle admin account, but is the easiest - JH
if ($username=='admin' && $password=='admin') {
    $_SESSION['username'] = 'admin';
    header("Location: admin.php");
    return;
}

$passwordEnc = md5($password);

$customerQuery = sendQuery("SELECT password FROM customer  where username = '$username'");// and password = '$passwordEnc' ");
$organzierQuery = sendQuery("SELECT password FROM organizer  where username = '$username'");

function password_auth($authQuery) {
    global $passwordEnc, $username;

    $result = $authQuery->fetch_assoc();
    $passwordRetr = $result['password'];

    if ($passwordEnc == $passwordRetr) {
        $_SESSION['username'] = $username;
        return true;
    } else {
        echo '<script type="text/javascript">alert("Incorrect Password"); location="logout.php";</script>';
    }
}

if ($customerQuery && password_auth($customerQuery)) {
    header("Location: home.php");
} else if ($organzierQuery && password_auth($organzierQuery)) {
    header("Location: loadingScreen.php");
} else {
    echo '<script type="text/javascript">alert("Unknown User"); location="login.php";</script>';
}
