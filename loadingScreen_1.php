<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
?>
<html>
    <head>
        <title>It's Happening!</title>
        <link href="css/loadindindicator.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="js/eventinfo_controller.js"></script>
        <meta http-equiv="refresh" content="0.5;url=home.php"/>
    </head>
    <body>
        <div id="Clouds">
  <div class="Cloud Foreground"></div>
  <div class="Cloud Background"></div>
  <div class="Cloud Foreground"></div>
  <div class="Cloud Background"></div>
  <div class="Cloud Foreground"></div>
  <div class="Cloud Background"></div>
  <div class="Cloud Background"></div>
  <div class="Cloud Foreground"></div>
  <div class="Cloud Background"></div>
  <div class="Cloud Background"></div>
        <div class="loader">Loading...</div>
    </body>
</html>
