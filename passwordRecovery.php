<?php
require('php/database.php');
require('php/email/email.php');

$username = filter_input(INPUT_POST, 'username');
$userEnteredEmail = filter_input(INPUT_POST, 'email');

function generateRandomPassword() {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $pass = "";
            
    for($i = 0; $i < 8; $i++) {
        $pass = $pass . $chars[rand(0, strlen($chars)-1)];
    }
    
    return $pass;
}

function resetPassword($pass) {
    global $username;
    $encryptedPass = md5($pass);
    $updatePass = sendQuery("UPDATE customer SET password='$encryptedPass' WHERE username='$username'");
}

$emailQuery = sendQuery("SELECT email FROM customer WHERE username='$username'"); // database.php

if ($emailQuery) {
    $emailAddr = $emailQuery->fetch_assoc()['email'];
    
    if($emailAddr==$userEnteredEmail) {
        $pass = generateRandomPassword();
        sendPasswordRecoveryEmail($emailAddr, $pass); // email.php
        resetPassword($pass);
        echo '<script type="text/javascript">alert("Password Recovery Email Sent"); location="login.php";</script>';
    } else {
        echo '<script type="text/javascript">alert("Invalid email address"); location="login.php";</script>';
    }
} else {
    echo '<script type="text/javascript">alert("Unknown username"); location="login.php";</script>';
}
