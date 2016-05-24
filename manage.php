<?php
session_start();
if (!$_SESSION["username"]) {
    header("Location: http://localhost/GCaaS/index.php");
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8"> <!-- For display webpage is correct -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Protect IE display error -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- In case of different screen will be display suitable -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Management</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTable);

        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name Deployment');
            data.addColumn('string', 'Account Type');
            data.addColumn('boolean', 'Autentication');
            data.addColumn('string', 'Create / Activated'); //date of create and last activated
            data.addColumn('string', 'Status');
            data.addRows([
                ['floodTH', 'Admin' , true , '10/01/15' , 'enable'],
                ['RoadCondition', 'Admin' ,  false , '08/04/16', 'enable'],
                ['HurricaneChina', 'Admin' , true , '27/06/15' , 'enable'],
                ['fireForest', 'Admin' ,  true , '15/12/15' , 'enable']
            ]);

            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
        }
    </script>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php" style="text-shadow: 2px 2px 2px grey;">
                   GCaaS
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <?php
                        if($_SESSION["username"]) {
                        ?>
                        <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#modal-logout" style="font-size:14px;"> <?php echo $_SESSION["username"] ?> </button><br>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="img/default-user.png" class="img-circle" alt="User Image">
                                <p>
                                    <?php echo $_SESSION["username"] ?> - Admin  <!--Username and Role-->
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
                    ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro-table">
        <div class="intro-body">
            <div class="container" style="color: #333333" >
                <a href="createDeploy.php" class="btn btn-default">+ Create Deployment</a>
                <!--<button type="button" class="btn btn-default">Delete</button>-->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1>Manage User Account</h1>
                        <!--table-->
                        <div id="table_div" style="color: #080808"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <!--<p>Copyright &copy; Your Website 2014</p>-->
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>
