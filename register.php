<?php
include 'php/database.php';

$firstname = filter_input(INPUT_POST, 'fname');
$lastname = filter_input(INPUT_POST, 'lname');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$confirmpassword = filter_input(INPUT_POST, 'cnfpassword');
$username = filter_input(INPUT_POST, 'username');
$usertype = filter_input(INPUT_POST, 'usertype');

$gid = filter_input(INPUT_GET, 'id');
$gname = filter_input(INPUT_GET, 'name');
$gmail = filter_input(INPUT_GET, 'mail');

$date = date('y-m-d h:i:s', time());

if ($gname == null and $gid == null and $gmail == null) {

    if ($password == $confirmpassword) {

        $createUser = sendQuery("SELECT username FROM customer where username = '$username'");

        if ($createUser) {
//            echo '<script type="text/javascript">alert("The username is already taken"); location="http://localhost/ItsHappening/login.php";</script>';
        
        } else {
            $password = md5($password);

            if ($usertype == 'organizer') {
                $usertype = 'O';
            } else if ($usertype == 'attendee') {
                $usertype = 'U';
            }

            echo(sendQuery("INSERT INTO customer
                (`username`, `password`, `email`, `first_name`, `last_name`, `create_date`, `ctype`) VALUES
                ('$username', '$password','$email', '$firstname', '$lastname','$date','$usertype')"));
            echo '<script type="text/javascript">alert("Registration Successful"); location="http://localhost/ItsHappening/login.php";</script>';
        }
    } else {
        echo '<script type="text/javascript">alert($Password does not match")</script>';
    }
} else {
    sendQuery("INSERT INTO customer(username, password, email, ctype) VALUES('$gname', '$gid', '$gmail', 'U')");
    
    echo '<script type="text/javascript">alert("Registration Successful"); location="login.php;</script>';
}
