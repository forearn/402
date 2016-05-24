<?php
session_start();
$message = "";
$username = "";
if (isset($_POST['signin'])) {
    $connection = pg_connect("host=localhost port=5432 dbname=GCaaS user=postgres password=1234");
    if (!$connection) {
        print("Connection Failed.");
        exit;
    }
    if (empty($_POST['lg_username']) || empty($_POST['lg_password'])) {
        $message = "Invalid Username or Password!";
    } else {
        // $myresult = pg_exec($connection, "SELECT * FROM table_user, table_role WHERE table_user.\"roleUserID\" = table_role.\"roleID\" AND table_user.\"user_Username\" = '" . $_POST["lg_username"] . "' AND table_user.\"user_Password\" = md5('" . $_POST["lg_password"]."')");
        $myresult = pg_exec($connection, "SELECT * FROM table_user WHERE \"user_Username\" = '" . $_POST["lg_username"] . "' AND \"user_Password\" = md5('" . $_POST["lg_password"] . "')");
        $field_count = pg_numfields($myresult);
        $rows = pg_numrows($myresult);
        if ($rows != 0) {
            for ($i = 0; $i < $rows; $i++) {
                // traverse each field
                for ($j = 0; $j < $field_count; $j++) {
                    $field = pg_fieldname($myresult, $j);
                    if ($j == 5) {
                        $_SESSION["username"] = pg_result($myresult, $i, $j);
                        $username = pg_result($myresult, $i, $j);
                    } 
                    else if ($j == 8) {
                        $role = pg_result($myresult,$i,$j);
                    }
                }
            }
            $myresult = pg_exec($connection, "SELECT \"role_Name\" FROM table_role WHERE \"roleID\" = " . $role );
            $field_count = pg_numfields($myresult);
            $rows = pg_numrows($myresult);
            for ($i = 0; $i < $rows; $i++) {
                $_SESSION['roleID'] = pg_result($myresult, $i, 0);
            }
        } else {
            $message = "Invalid Username or Password!";
        }

        if (isset($_SESSION['username'])) {
            if (!strcmp($role, "Super Admin")) {
                # code...
                header("Location: http://localhost/GCaaS-3/manageYourself.php");
            } else {
                # code...
                header("Location: http://localhost/GCaaS-3/index.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>GCaaS</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <!-- FONT AWESOME CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet"/>
    <!-- FLEXSLIDER CSS -->
    <link href="css/flexslider.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE CSS -->
    <link href="css/style.css" rel="stylesheet"/>
    <!-- Google	Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'/>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top " id="menu">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#index.php"><img class="logo-custom" src="img/logo.png" alt="" height="50"
                                                  width="150"/></a>
        </div>
        <div class="navbar-collapse collapse move-me">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#home">HOME</a></li>
                <li><a href="#features-sec">FEATURES</a></li>
                <li><a href="#about-sec">ABOUT</a></li>
                <li><a href="#contact-sec">CONTACT</a></li>
                <li>
                    <?php
                    if($_SESSION["username"]) {
                    ?>
                    <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal-logout" style="font-size:14px;"> <?php echo $_SESSION["username"] ?> </button><br>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="img/default-user.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $_SESSION["username"] ?> - <?php echo $_SESSION["roleID"] ?>  <!--Username and Role-->
                                <small>Member since Nov. 2015</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="manage.php" class="btn btn-default btn-flat">Manage</a>
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-danger btn-flat" onclick="alertFn()">Sign out</a>
                                <script>
                                    function alertFn() {
                                        var x;
                                        if (confirm("Do you want to log out?") == true) {
                                            x = "You pressed OK!";

                                        } else {
                                            x = "You pressed Cancel!";
                                        }
                                        document.getElementById("demo").innerHTML = x;
                                    }
                                </script>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php
                }
                else {
                    ?>
<!--                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#login" style="font-size:14px;">Log in</button><br>-->
                    <?php
                }
                ?>
                </li>
            </ul>
        </div>

    </div>
</div>
<!--NAVBAR SECTION END-->
<div class="home-sec" id="home">
    <div class="overlay">
        <div class="container">
            <div class="row text-center ">

                <div class="col-lg-12  col-md-12 col-sm-12">

                    <div class="flexslider set-flexi" id="main-section">
                        <!-- HEADER -->
                        <h1>GCaaS</h1>
                        <h4>GIS with Crowdsourcing as a Service</h4>
                        <p>Service that help you create websites for managing incidents.
                            <br>Experiencing simple and effortless way to have your GIS websites ready in just a few seconds.</p>
                        <a href="createDeploy.php" class="btn btn-default btn-lg" data-toggle="tooltip"
                           title="Create your deployment">
                            CREATE DEPLOYMENT
                        </a>
<!--                        <a href="#" class="btn btn-success btn-lg">-->
<!--                            LOG IN-->
<!--                        </a>-->
                        <button id="login-btn" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#login">LOG IN</button>
                        <!-- End HEADER -->
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!--HOME SECTION END-->
<div class="tag-line">
    <div class="container">
        <div class="row text-center">

            <div class="col-lg-12  col-md-12 col-sm-12">

                <!-- <h2 data-scroll-reveal="enter from the bottom after 0.1s" ><i class="fa fa-circle-o-notch"></i> WELCOME <i class="fa fa-circle-o-notch"></i> </h2> -->
            </div>
        </div>
    </div>

</div>
<!--HOME SECTION TAG LINE END-->
<div id="features-sec" class="container set-pad">
    <div class="row text-center">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
            <h1 data-scroll-reveal="enter from the bottom after 0.2s" class="header-line">FEATURES</h1>
            <p data-scroll-reveal="enter from the bottom after 0.3s">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                Aenean commodo.
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                Aenean commodo.
            </p>
        </div>

    </div>
    <!--/.HEADER LINE END-->


    <div class="row text-center">


        <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.4s">
            <div class="about-div">
                <i class="fa fa-sort-numeric-asc fa-4x icon-round-border"></i>
                <h3>DATA COLLECTION </h3>
                <hr/>
                <hr/>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo .

                </p>
            </div>
        </div>
        <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.5s">
            <div class="about-div">
                <i class="fa fa-laptop fa-4x icon-round-border"></i>
                <h3>DATA MANAGE </h3>
                <hr/>
                <hr/>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo .

                </p>
            </div>
        </div>
        <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.6s">
            <div class="about-div">
                <i class="fa fa-map-marker fa-4x icon-round-border"></i>
                <h3>DATA VISUALIZATION </h3>
                <hr/>
                <hr/>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo .

                </p>
            </div>
        </div>


    </div>
</div>
<!-- FEATURES SECTION END-->
<div id="about-sec">
    <div class="container set-pad">
        <div class="row text-center">
            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">ABOUT US</h1>
                <p data-scroll-reveal="enter from the bottom after 0.3s">
                    Disasters always bring loss to both life and property. Mostly, we can’t avoid disaster that happened
                    neither naturally nor by human therefore, we should know how to handle the disaster situation while
                    it’s happening and how to recover after it passed.
                    <br>GCaaS Project is the practical program on website for anyone who would like to help disaster
                    victims or people who encounter the disasters by created the webpage for helping and recovering
                    after disaster happened.
                </p>
            </div>
        </div>
        <!--/.HEADER LINE END-->
    </div>
</div>
<!-- ABOUT SECTION END-->
<div id="contact-sec" class="container set-pad">
    <div class="row text-center">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
            <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">CONTACT US </h1>
            <p data-scroll-reveal="enter from the bottom after 0.3s">
                Feel free to email us to provide some feedback on our project, give us suggestions for new project, or
                to just say hello!
            </p>
        </div>
        <div data-scroll-reveal="enter from the bottom after 0.5s">


            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span
                                class="network-name">Twitter</span></a>
                    </li>
                    <li>
                        <a href="" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span
                                class="network-name">Github</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/.HEADER LINE END-->

</div>
<!-- CONTACT SECTION END-->

<!-- Modal Login form-->
<div class="modal fade" id="login" tabindex="-1" data-focus-on="input:first" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="text-center" style="padding:50px 30px 50px 30px;color: #333333">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1>Log in</h1>
                </div>
                <!-- Main Form -->
                <div class="modal-body login-form-1">

                    <form name="frmUser" id="login-form" class="text-left" method="post" >
                        <div class="login-form-main-message"></div>
                        <div class="main-login-form">
                            <div class="login-group">
                                <div class="form-group">
                                    <label for="lg_username" class="sr-only">Username</label>
                                    <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="lg_password" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="password" required>
                                </div>
                                <!--<div class="form-group login-group-checkbox">-->
                                <!--<input type="checkbox" id="lg_remember" name="lg_remember">-->
                                <!--<label for="lg_remember">remember</label>-->
                                <!--</div>-->
                            </div>

                            <span id="errorNoti"><?php echo $message; ?></span>
                            <input type="submit" class="btn btn-default btn-block" value="Submit" name="signin" onclick="hideBtn()">
                            <script>
                                function hideBtn(){
                                        document.getElementById('login-btn').style.visibility = 'hidden';
                                }
                            </script>
                            <!-- <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button> -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a data-toggle="modal" href="#forgot"><br>forgot your password?</a>
                    <a data-toggle="modal" href="#register"><br>create new account.</a>
                </div>
                <!-- end:Main Form -->
            </div>
        </div>
    </div>
</div> <!-- Modal Login form END-->

<!--Modal Forgot form-->
<div class="modal fade" id="forgot" tabindex="-1" data-focus-on="input:first" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="text-center" style="padding:50px 30px 50px 30px;color: #333333">
                <!-- FORGOT PASSWORD FORM -->
                <div class="text-center">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1>forgot password</h1>
                    </div>
                    <!-- Main Form -->
                    <div class="modal-body login-form-1">
                        <form id="forgot-password-form" class="text-left">
                            <div class="etc-login-form">
                                <p>When you fill in your registered email address, you will be sent instructions on how to reset your password.</p>
                            </div>
                            <div class="login-form-main-message"></div>
                            <div class="main-login-form">
                                <div class="login-group">
                                    <div class="form-group">
                                        <label for="fp_email" class="sr-only">Email address</label>
                                        <input type="text" class="form-control" id="fp_email" name="fp_email" placeholder="email address">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-default btn-block" value="Submit">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!--<p>already have an account? <a href="#">login here</a></p>-->
                        <a data-toggle="modal" href="#register">create new account.</a>
                    </div>
                    <!-- end:Main Form -->
                </div>
            </div>
        </div>
    </div>
</div> <!--Modal Forgot form END-->

<!--Modal Register form-->
<div class="modal fade" id="register" tabindex="-1" data-focus-on="input:first" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="text-center" style="padding:50px 30px 50px 30px;color: #333333">
                <!--REGISTRATION FORM -->
                <div class="text-center">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1>register</h1>
                    </div>
                    <!-- Main Form -->
                    <div class="modal-body login-form-1">
                        <form id="register-form" class="text-left">
                            <div class="login-form-main-message"></div>
                            <div class="main-login-form">
                                <div class="login-group">
                                    <div class="form-group">
                                        <label for="reg_username" class="sr-only">Email address</label>
                                        <input type="text" class="form-control" id="reg_username" name="reg_username" placeholder="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_password" class="sr-only">Password</label>
                                        <input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_password_confirm" class="sr-only">Password Confirm</label>
                                        <input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" placeholder="confirm password">
                                    </div>

                                    <div class="form-group">
                                        <label for="reg_firstname" class="sr-only">First Name</label>
                                        <input type="text" class="form-control" id="reg_firstname" name="reg_firstname" placeholder="first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_lastname" class="sr-only">Last Name</label>
                                        <input type="text" class="form-control" id="reg_lastname" name="reg_lastname" placeholder="last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_email" class="sr-only">Email</label>
                                        <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="e-mail">
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_tel" class="sr-only">Email</label>
                                        <input type="text" class="form-control" id="reg_tel" name="reg_tel" placeholder="tel.">
                                    </div>
<!--                                    <div class="form-group login-group-checkbox">-->
<!--                                        <input type="checkbox" class="" id="reg_agree" name="reg_agree" disabled>-->
<!--                                        <label for="reg_agree">i agree with <a href="#">terms</a></label>-->
<!--                                    </div>-->
                                </div>
                                <input type="submit" class="btn btn-default btn-block" value="Submit">
                            </div>
                        </form>
                    </div>
                    <!-- /.Main form -->
                </div>
            </div>
        </div>
    </div>
</div> <!--Modal Register form END-->

<div id="footer">

</div>
<!-- FOOTER SECTION END-->

<!--  Jquery Core Script -->
<script src="js/jquery-1.10.2.js"></script>
<!--  Core Bootstrap Script -->
<script src="js/bootstrap.js"></script>
<!--  Flexslider Scripts -->
<script src="js/jquery.flexslider.js"></script>
<!--  Scrolling Reveal Script -->
<script src="js/scrollReveal.js"></script>
<!--  Scroll Scripts -->
<script src="js/jquery.easing.min.js"></script>
<!--  Custom Scripts -->
<script src="js/custom.js"></script>
</body>
</html>
