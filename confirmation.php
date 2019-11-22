<?php
$pass = '1234';
// $ticket_detail = '<p> 2 VIP Tickets </p>';

echo "<html>
    <head>
        <title>Order Confirmation</title>
    </head>
    <body style='text-align: center; font-size: 140%; color:black;'>
        <h2 style='font-family: fantasy; '>It's Happening!</h2>
        <p>Your temperory password is <span style='font-weight: bold;'>"
        . $pass .
        "</span></p>" .
        "<a href='http://http://ec2-13-58-75-14.us-east-2.compute.amazonaws.com/ItsHappening/profile.php' target='_blank' style='text-decoration: none; color:black;'>
        <div style='border:solid black 1px; height:40px; width: 200px; line-height:40px; cursor:pointer; margin: 20px auto;'>
        Reset My Password
        </div>
        </a>
    </body>
</html>"
 ?>
