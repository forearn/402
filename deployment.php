<?php 
    include "twitteroauth.php"; 
    session_start();
    if (!$_SESSION["username"]) {
        header("Location: http://localhost/GCaaS-3/index.php");
        exit(0);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My map</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <!--&lt;!&ndash; Custom CSS &ndash;&gt;-->
    <!--<link href="css/grayscale.css" rel="stylesheet">-->

    <link rel="stylesheet" href="css/skin-blue.min.css">

    <!-- CUSTOM STYLE CSS -->
    <link href="css/style.css" rel="stylesheet"/>
    <style>
        #map {
            width: 100%;
            height: 600px;
            /*margin-top: 100px;*/
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=AIzaSyChsKVqmyv9qxepQVE9qlnUj8sXbsuQrhs&signed_in=true&libraries=drawing"></script>
    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="navbar navbar-inverse navbar-fixed-top " id="menu">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img class="logo-custom" src="img/logo.png" alt="" height="50"
                                                  width="150"/></a>
        </div>
        <div class="navbar-collapse collapse move-me">
            <ul class="nav navbar-nav navbar-right">
                <li><?php
                    if ($_SESSION["username"]) {
                    ?>
                    <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <button type="button" class="btn btn-default btn-lg" data-toggle="modal"
                                data-target="#modal-logout"
                                style="font-size:14px;"> <?php echo $_SESSION["username"] ?> </button>
                        <br>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="img/default-user.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $_SESSION["username"] ?> - <?php echo $_SESSION['roleID'] ?>  <!--Username and Role-->
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
                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#login"
                            style="font-size:14px;">Log in
                    </button><br>
                    <?php
                }
                ?>
                </li>
            </ul>
        </div>

    </div>

    <!-- Main Header -->
    <header class="main-header">
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Navbar Right Menu -->

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" class="sidebar-toggle" data-toggle="control-sidebar" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header> <!-- ./Main Header END-->
</div>
<!--NAVBAR SECTION-->




<!-- Content Wrapper. Contains page content -->
<!--Map content-->
<div id="map"></div>

<!-- Footer -->
<footer id="footer">

</footer>
<!-- FOOTER SECTION END-->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Control manage</h3>
            <div class="input-group" style="margin: 10px">
                <input type="text" class="form-control" id="search" placeholder="Search location...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="search-btn"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
            </div><!-- /input-group -->
             <h4 class="control-sidebar-heading">Dynamic data layers</h4>
             <form role="form">
                <div class="checkbox">
                    <label><input type="checkbox" id="twitter" value="checked" onclick="dynamicTwitter()"><img src="img/marker/twitter.png">Twitter</label>
                </div>
             </form>
            <h4 class="control-sidebar-heading">Static data layers</h4>
            <form role="form">
                <div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="hospital" value="checked" onclick="staticHospital()"><img src="img/marker/hospital.png">Hospitals</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="school" value="checked" onclick="staticSchool()"><img src="img/marker/school.png">Schools</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="police" value="checked" onclick="staticPolice()"><img src="img/marker/police.png">Police stations</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="fire" value="checked" onclick="staticFire()"><img src="img/marker/fire.png">Fire stations</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="temple" value="checked" onclick="staticTemple()"><img src="img/marker/temple.png">Temples</label>
                    </div>
                </div>
                <?php
                $connect = pg_connect("host=localhost port=5432 dbname=GCaaS user=postgres password=1234");
                if (!$connect) {
                    print("Connection Failed.");
                    exit;
                } else {
                    $myresult = pg_exec($connect, "SELECT \"staticDataLayer_Name\" FROM \"table_staticDataLayer\"");
                    $rows = pg_numrows($myresult);
                    echo $myresult;
                    if ($rows != 0) {
                        for ($i = 0; $i < $rows; $i++) {
                            $result = pg_result($myresult, $i, 0);
                            ?>
                            <option><?php echo $result; ?></option>
                        <?php }
                    } else {
                        echo "Static data layer is empty.";
                    }

                }
                ?>
            </form>
        </div><!-- /.tab-pane -->

        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->

        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>
                <div class="input-group">
                    <h4><a data-toggle="collapse" href="#layer-menu"><img src="img/layer.png"> Static data layer</a></h4>
                    <div class="collapse" id="layer-menu">
                        <label class="control-label">Add Static data layer</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="add-layer" placeholder="upload shape file">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="open"><span class="glyphicon glyphicon-folder-open"></span></button>
                            </span>
                        </div>
                    </div>
                </div><!-- /input-group -->
                <div class="input-group">
                    <h4><a data-toggle="collapse" href="#twitter-menu"><img src="img/twitter.png"> Twitter</a></h4>
                    <div class="collapse" id="twitter-menu">
                        <label class="control-label">Add Hashtag (#)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="add-hash" placeholder="Ex.#floodTH ...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="ok"><span class="glyphicon glyphicon-triangle-right"></span></button>
                            </span>
                        </div>
                    </div>
                </div><!-- /input-group -->
                <h4><a data-toggle="collapse" href="" ><img src="img/facebook.png"> Facebook</a></h4>
                <h4><a data-toggle="collapse" href="" ><img src="img/youtube.png"> Youtube</a></h4>
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
<!--</div>&lt;!&ndash; ./wrapper &ndash;&gt;-->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>

<script>
    var map;
    var markerHos=[];
    var markerSch=[];
    var markerPol=[];
    var markerFir=[];
    var markerTem=[];
    var lat=null;
    var lng=null;
    var temple = 'img/marker/temple.png';
    var hospital = 'img/marker/hospital.png';
    var police = 'img/marker/police.png';
    var fire = 'img/marker/fire.png';
    var school = 'img/marker/school.png';
    var twitter = 'img/marker/twitter.png';

    setInterval( function(){
        
        if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }
        else {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
          {
            // console.log(xmlhttp.responseText);
            // var obj = JSON.parse(xmlhttp.responseText);
            // console.log(obj);
          }
        }
        xmlhttp.open("GET","http://localhost/GCaaS-3/fetchTW.php",true);
        xmlhttp.send();
    },3000);


    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 13, lng: 100},
            zoom: 8
        });
    }

    function staticHospital(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerHos.length; i++) {
          markerHos[i].setMap(null);
        }

        if (document.getElementById('hospital').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerHos.length; i++) {
                  markerHos[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerHos[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: hospital,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerHos[i].info;
                        google.maps.event.addListener(markerHos[i], 'click', function() {
                          for(var i =0;i<=markerHos.length-1;i++){
                            markerHos[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerHos[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: hospital,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerHos[i].info;
                        google.maps.event.addListener(markerHos[i], 'click', function() {
                          for(var i =0;i<=markerHos.length-1;i++){
                            markerHos[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/staticData.py?typeStatic=Hospital",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerHos.length; i++) {
              markerHos[i].setMap(null);
            }
        };
    }

    function staticSchool(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerSch.length; i++) {
          markerSch[i].setMap(null);
        }

        if (document.getElementById('school').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerSch.length; i++) {
                  markerSch[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerSch[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: school,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerSch[i].info;
                        google.maps.event.addListener(markerSch[i], 'click', function() {
                          for(var i =0;i<=markerSch.length-1;i++){
                            markerSch[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerSch[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: school,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerSch[i].info;
                        google.maps.event.addListener(markerSch[i], 'click', function() {
                          for(var i =0;i<=markerSch.length-1;i++){
                            markerSch[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/staticData.py?typeStatic=School",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerSch.length; i++) {
              markerSch[i].setMap(null);
            }
        };
    }

    function staticPolice(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerPol.length; i++) {
          markerPol[i].setMap(null);
        }

        if (document.getElementById('police').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerPol.length; i++) {
                  markerPol[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerPol[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: police,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerPol[i].info;
                        google.maps.event.addListener(markerPol[i], 'click', function() {
                          for(var i =0;i<=markerPol.length-1;i++){
                            markerPol[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerPol[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: police,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerPol[i].info;
                        google.maps.event.addListener(markerPol[i], 'click', function() {
                          for(var i =0;i<=markerPol.length-1;i++){
                            markerPol[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/staticData.py?typeStatic=Police station",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerPol.length; i++) {
              markerPol[i].setMap(null);
            }
        };
    }

    function staticFire(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerFir.length; i++) {
          markerFir[i].setMap(null);
        }

        if (document.getElementById('fire').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerFir.length; i++) {
                  markerFir[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerFir[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: fire,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerFir[i].info;
                        google.maps.event.addListener(markerFir[i], 'click', function() {
                          for(var i =0;i<=markerFir.length-1;i++){
                            markerFir[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerFir[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: fire,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerFir[i].info;
                        google.maps.event.addListener(markerFir[i], 'click', function() {
                          for(var i =0;i<=markerFir.length-1;i++){
                            markerFir[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/staticData.py?typeStatic=Fire station",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerFir.length; i++) {
              markerFir[i].setMap(null);
            }
        };
    }

    function staticTemple(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerTem.length; i++) {
          markerTem[i].setMap(null);
        }

        if (document.getElementById('temple').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerTem.length; i++) {
                  markerTem[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerTem[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: temple,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerTem[i].info;
                        google.maps.event.addListener(markerTem[i], 'click', function() {
                          for(var i =0;i<=markerTem.length-1;i++){
                            markerTem[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerTem[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: temple,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerTem[i].info;
                        google.maps.event.addListener(markerTem[i], 'click', function() {
                          for(var i =0;i<=markerTem.length-1;i++){
                            markerTem[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/staticData.py?typeStatic=Temple",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerTem.length; i++) {
              markerTem[i].setMap(null);
            }
        };
    }

    function dynamicTwitter(){
        var xmlhttp;
        var myLatlng;

        for (var i = 0; i < markerTem.length; i++) {
          markerTem[i].setMap(null);
        }

        if (document.getElementById('twitter').checked == true) {
            if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)//200=status ok!
              {
                for (var i = 0; i < markerTem.length; i++) {
                  markerTem[i].setMap(null);
                }
                var infowindow;
                myLatlng = JSON.parse(xmlhttp.responseText);
                for (var i = 0; i < myLatlng.length; i++) {
                    var contentStr = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading">'+ myLatlng[i].name +'</h3>'+
                    '<div id="bodyContent">'+
                    '<p>ละติจูด: '+ myLatlng[i].lat_itude +' ลองจิจูด: '+ myLatlng[i].long_itude +'</p>'+
                    '</div>';

                    if (i == myLatlng.length-1) {
                        var latlng = new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude);
                        markerTem[i] = new google.maps.Marker({
                          position: latlng,
                          map: map,
                          icon: twitter,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                           content: contentStr
                          })
                        });

                        infowindow = markerTem[i].info;
                        google.maps.event.addListener(markerTem[i], 'click', function() {
                          for(var i =0;i<=markerTem.length-1;i++){
                            markerTem[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                        map.setCenter(latlng);
                        map.setZoom(10);
                      }
                      else{
                        markerTem[i] = new google.maps.Marker({
                          position: new google.maps.LatLng(myLatlng[i].lat_itude,myLatlng[i].long_itude),
                          map: map,
                          icon: twitter,
                          title: myLatlng[i].name,
                          info: new google.maps.InfoWindow({
                          content: contentStr
                          })
                        });

                        infowindow = markerTem[i].info;
                        google.maps.event.addListener(markerTem[i], 'click', function() {
                          for(var i =0;i<=markerTem.length-1;i++){
                            markerTem[i].info.close();
                          }
                          this.info.open(map,this);
                        });
                      }
                    }
                }
            }
            xmlhttp.open("GET","http://localhost/cgi-bin/dynamicData.py",true);
            xmlhttp.send();
        } 
        else{
            for (var i = 0; i < markerTem.length; i++) {
              markerTem[i].setMap(null);
            }
        };
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChsKVqmyv9qxepQVE9qlnUj8sXbsuQrhs&callback=initMap"
        async defer></script>

</body>
</html>
