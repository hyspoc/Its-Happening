<?php
/*
 * SEND-GRID
 */
require('sendgrid-php/sendgrid-php.php');

$sendgrid = new \SendGrid('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');
$email = new \SendGrid\Mail\Mail();

function sendPasswordRecoveryEmail($destAddr, $pass) {
    global $sendgrid, $email;

    $email->setFrom("itshappening.cs@gmail.com", "Customer Service, It's Happening");
    $email->setSubject("Password Recovery");
    $email->addTo($destAddr);
    $email->addContent("text/html",
    "<html>
        <head>
            <title>Order Confirmation</title>
        </head>
        <body style='text-align: center; font-size: 140%; color:black;'>
            <h2 style='font-family: fantasy; '>It's Happening!</h2>
            <p>Your temperory password is <span style='font-weight: bold;'>"
            . $pass .
            "</span></p>" .
            "<a href='http://ec2-13-58-75-14.us-east-2.compute.amazonaws.com/ItsHappening/profile.php' target='_blank' style='text-decoration: none; color:black;'>
            <div style='border:solid black 1px; height:40px; width: 200px; line-height:40px; cursor:pointer; margin: 20px auto;'>
            Reset My Password
            </div>
            </a>
        </body>
    </html>");
    // $email->addContent("text/plain", "Your temperory password is: " . $pass);

    try {
        $response = $sendgrid->send($email);
        //print $response->statusCode() . "\n";
        //print_r($response->headers());
        //print $response->body() . "\n";
    } catch (Exception $ex) {
        //echo 'Caught exception: '. $ex->getMessage() ."\n";
    }
}

function sendTicketConfirmation($destAddr, $eventTitle, $ticket_detail, $order_num) {
    global $sendgrid, $email;

    $email->setFrom("itshappening.cs@gmail.com", "It's Happening!");
    $email->setSubject("Order Confirmation");
    $email->addTo($destAddr);
    $email->addContent("text/html",
    "<html>
        <head>
            <title>Order Confirmation</title>
        </head>
        <body style='text-align: center; font-size: 140%; color:black;'>
            <h2 style='font-family: fantasy; '>It's Happening!</h2>
            <p>Congratulations! Your payment for: </br> <span style='font-weight: bold;'>"
            . $eventTitle .
            "</span> </br> has been processed!</p>"
            . $ticket_detail .
            "<p> Order # " . $order_num . " </p>" .
            "<a href='http://ec2-13-58-75-14.us-east-2.compute.amazonaws.com/ItsHappening/profile.php' target='_blank' style='text-decoration: none; color:black;'>
                <div style='border:solid black 1px; height:40px; width: 200px; line-height:40px; cursor:pointer; margin: 20px auto;'>
                    View Tickets
                </div>
            </a>
        </body>
    </html>");
    try {
        $response = $sendgrid->send($email);
    } catch (Exception $ex) {}
}

/*
 * PHP SMTP
 *
function sendPasswordRecoveryEmail($destAddr, $pass) {
    $subject = "Password Recovery Testing";
    //$txt = "Your temperory password is: " . $pass;
    $txt = "temp pass: " . $pass;
    $headers = "From: no-reply@itshappening.com";

    mail($destAddr, $subject, $txt, $headers);
}
 *
 */
