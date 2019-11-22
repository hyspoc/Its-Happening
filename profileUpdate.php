<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
}

include 'php/database.php';

$new_username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
$first_name = filter_input(INPUT_POST, 'firstName');
$last_name = filter_input(INPUT_POST, 'lastName');
//$user_image = $_FILES['user_image'];
$user_image = filter_input(INPUT_POST, 'user_image');
$current_password = filter_input(INPUT_POST, 'current_password');
$new_password = filter_input(INPUT_POST, 'new_password');
$verify_password = filter_input(INPUT_POST, 'verify_password');

$profileQuery = sendQuery("SELECT * FROM customer where username = '$username'");
$base64 = base64_encode($user_image);
$base64String = 'data:image/jpeg;base64,'.$base64;

if ($profileQuery) {
    if ($new_username || $email || $first_name || $last_name) {
        if ($new_username) {
            $exists = sendQuery("SELECT 1 FROM customer WHERE username = '$new_username'");
            if (sendQuery("SELECT 1 FROM customer WHERE username = '$new_username'")) {
                // username already exists
                echo '<script type="text/javascript">alert("Sorry, the password your entered already exists, please try anther one."); </script>';
            } else {
                // update username
                sendQuery("UPDATE customer SET username='$new_username' WHERE username = '$username'");
            }
        }
        if ($email) {
            sendQuery("UPDATE customer SET email='$email' WHERE username = '$username'");
        }
        if ($first_name) {
            sendQuery("UPDATE customer SET first_name='$first_name' WHERE username = '$username'");
        }
        if ($last_name) {
            sendQuery("UPDATE customer SET last_name='$last_name' WHERE username = '$username'");
        }
        echo '<script type="text/javascript">alert("Update Successful."); location="profile.php";</script>';
    } else if ($current_password) {
        if ($new_password==$verify_password) {
            $current_password = md5($current_password);
            $new_password = md5($new_password);
            $verify_password = md5($verify_password);

            if (sendQuery("SELECT 1 FROM customer WHERE username = '$username' AND password='$current_password'")) {
                sendQuery("UPDATE customer SET password='$new_password' WHERE username = '$username'");
                echo '<script type="text/javascript">alert("Password update Successful."); location="login.php";</script>';
            } else {
                echo '<script type="text/javascript">alert("The password you entered doesn\'t match our records, please try again."); location="profile.php";</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("The new passwords you entered doesn\'t match, please try again."); location="profile.php";</script>';
        }
    }else if($base64){
        $profilepic = "data:image/jpeg;base64,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";
        sendQuery("UPDATE customer SET user_image='$profilepic' WHERE username = '$username'");
    }

} else {
    echo '<script type="text/javascript">alert("Oops, something went wrong with our server."); location="profile.php";</script>';
}
echo '<script type="text/javascript">location="profile.php";</script>';
