<!DOCTYPE html>
<html>
    <head>
        <title>It's Happening!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="google-signin-client_id" content="1075942557799-kti11mkp3d7ntlsokhrd9mf8vi54s774.apps.googleusercontent.com">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <script src="js/signup_controller.js"></script>
        <!-- Custom Theme files -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/popup.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/font-awesome.css" rel="stylesheet">		<!-- font-awesome icons -->
        <!-- //Custom Theme files -->
        <!-- web font -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'><!--web font-->
        <!-- //web font -->
        <link href="css/login.css" rel="stylesheet">
        <link href="css/global-background.css" rel="stylesheet">
    </head>

    <body>
        <!-- main -->
        <div id = "mainContainer" class="main-agileits">
            <h1>It's Happening!</h1>
            <div class="main-agileinfo">
                <!-- login form -->
                <div id = "loginPage" class="login-form">
                    <div class="login-agileits-top">
                        <form action="auth.php" method="post">
                            <p>Username </p>
                            <input id="input1" type="text" class="name" name="username" placeholder="Username" required=""/>
                            <p>Password</p>
                            <input id="input2" type="password" class="password" name="password" placeholder=".........." required=""/>
                            <label class="anim">
                                <input type="checkbox" class="checkbox">
                                <span> Remember me ?</span>
                            </label>
                            <input type="submit" value="Login">
                        </form>
                    </div>
                    <div class="login-agileits-bottom">
                        <h6><a onClick="forgotPwdPopup()" style="cursor:pointer;">Forgot password?</a></h6>
                        <h6><a onClick = "openForm()" style="cursor:pointer;">Sign Up</a></h6>
                        <h6><a href="home.php" style="cursor:pointer;">Guest User?</a></h6>
                    </div>
                    <div class="social-lsicon">
<!--                        <a href="#" class="social-button google"><i class="fa fa-google-plus" data-onsuccess="onSignIn"></i></a>-->
<!--                        <a href="#" class="social-button twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="social-button facebook"><i class="fa fa-facebook"></i></a>
                        -->
                    </div>

                </div>
            </div>
        </div>
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
<!--  <svg viewBox="0 0 40 24" class="Cloud"><use xlink:href="#Cloud"></use></svg>-->
</div>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="40px" height="24px" viewBox="0 0 40 24" enable- xml:space="preserve">
  <defs>
    <path id="Cloud" d="M33.85,14.388c-0.176,0-0.343,0.034-0.513,0.054c0.184-0.587,0.279-1.208,0.279-1.853c0-3.463-2.809-6.271-6.272-6.271
	c-0.38,0-0.752,0.039-1.113,0.104C24.874,2.677,21.293,0,17.083,0c-5.379,0-9.739,4.361-9.739,9.738
	c0,0.418,0.035,0.826,0.084,1.229c-0.375-0.069-0.761-0.11-1.155-0.11C2.811,10.856,0,13.665,0,17.126
	c0,3.467,2.811,6.275,6.272,6.275c0.214,0,27.156,0.109,27.577,0.109c2.519,0,4.56-2.043,4.56-4.562
	C38.409,16.43,36.368,14.388,33.85,14.388z"/>
  </defs>
</svg>
        <div class="form-popup" id="myForm">

            <div id="tclose" onclick="closeForm()">X</div>
            <form  class="form-container"  method="post" action="register.php">
                
                <div style = "margin: 0 0 5px 39%;" class="g-signin2" data-onsuccess="onSignIn"></div>
                <div style = "margin: 0 0 0 48%; margin-top: 1em; margin-bottom: 1em;">OR</div>
                <div class="row mb-2">
                    <div class="cell-sm-10">
                        <select id="soflow" name="usertype" required>
                            <option value="">Select User Type</option>
                            <option value="organizer" name="organizer">Event Organizer</option>
                            <option value="attendee" name="attendee">Event Attendee</option>
                        </select>
                    </div>
                    <label class="cell-sm-2">Username</label>
                    <div class="cell-sm-10">
                        <input type="text" name="username" required="">
                    </div>
                    <label class="cell-sm-2">First Name</label>
                    <div class="cell-sm-10">
                        <input type="text"  name="fname" required="">
                    </div>
                    <label class="cell-sm-2">Last Name</label>
                    <div class="cell-sm-10">
                        <input type="text"  name="lname" required="">
                    </div>

                    <label class="cell-sm-2">Email</label>
                    <div class="cell-sm-10">
                        <input type="text"  name="email" required="">
                    </div>

                    <label class="cell-sm-2">Password</label>
                    <div class="cell-sm-10">
                        <input type="password"  name="password" required="">
                    </div>
                    <label class="cell-sm-2">Confirm Password</label>
                    <div class="cell-sm-10">
                        <input type="password"  name="cnfpassword" required="">
                    </div>

                </div>
                <input type="submit" value="Sign Up" action="register.php">
                

            </form>
        </div>

        <div class="resetpwd-popup" id="forgotPwd">
            <form class="form-container" method="post" action="passwordRecovery.php">
                <div>
                <div id="tclose" onclick="forgotPwdPopupClose()">X</div>
                <form  class="form-container"  method="post">

                    <div class="row.mb-3">
                        <label class="cell-sm-2">Username</label>
                        <div class="cell-sm-10">
                            <input type="text" name="username" required="">
                        </div>
                    </div>
                    <div class="row.mb-3">
                        <label class="cell-sm-2">Email</label>
                        <div class="cell-sm-10">
                            <input type="text"  name="email" required="">
                        </div>
                    </div>

                    <input type="submit" value="Reset Password">

                </form>
        </div>

        <!-- //main -->
        <!-- js -->
        <script src="js/superplaceholder.js"></script>

        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script>
                    superplaceholder({
                        el: input1,
                        sentences: ['name.surname', 'name.alias', 'example@name2'],
                        options: {
                            loop: true,
                            startOnFocus: false
                        }
                    })
                    superplaceholder({
                        el: input2,
                        sentences: ['.........', '.....', '.....'],
                        options: {
                            loop: true,
                            startOnFocus: false
                        }
                    })
        </script>
        <!-- //js -->

        <!-- LiveChat (www.livechatinc.com) -->
        <script type="text/javascript">
            window.__lc = window.__lc || {};
            window.__lc.license = 10377037;
            (function () {
                var lc = document.createElement('script');
                lc.type = 'text/javascript';
                lc.async = true;
                lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(lc, s);
            })();
        </script>

        <noscript>
        <a href="https://www.livechatinc.com/chat-with/10377037/">Chat with us</a>,
        powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener" target="_blank">LiveChat</a>
        </noscript>
        <!-- LiveChat End -->
    </body>
</html>
