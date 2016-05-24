<?php
session_start();
if (!$_SESSION["username"]) {
    header("Location: http://localhost/GCaaS-3/index.php");
    exit(0);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Create Deployment</title>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKMYDj7Tvbn-yijtKrluHSJU7hnY_dvVQ&libraries=drawing"></script>

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
</div>
<!--NAVBAR SECTION-->

<div id="configuration" style="margin-top: 100px">
    <div class="container">
        <h2>Configuration</h2>

        <div class="container">
            <div class="row" style="margin-top: -35px;">
                <section>
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">

                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="deployment profile">
                            <span class="round-tab">
                                <i class=" ">1</i>
                            </span>
                                    </a>
                                </li>

                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="deployment area">
                            <span class="round-tab">
                                <i class=" ">2</i>
                            </span>
                                    </a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Static data layers">
                            <span class="round-tab">
                                <i class=" ">3</i>
                            </span>
                                    </a>
                                </li>

                                <li role="presentation" class="disabled">
                                    <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab"
                                       title="Complete">
                            <span class="round-tab">
                                <i class="fa fa-check"></i>
                            </span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- ./wizard inner END-->

                        <div class="container" > <!-- Form Configuration -->

                            <div class="tab-content">
                                <!--step 1-->
                                <div id="step1" class="tab-pane fade in active">
                                    <h3>Deployment Profile</h3>
                                    <p>Specifies about information deployment.</p>
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label for="deployName" class="col-sm-3 control-label">Deployment Name <r class="require">** : </r></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" id="deployName" type="text"
                                                       placeholder="Please input your name of deployment here..." onchange="pullName(this);">
                                                <p class="box">: Deployment name that will be database name of deployment.</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="url" class="col-sm-3 control-label">Deployment URL <r class="require">** : </r></label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">https://GCaaS.com/</span>
                                                    <input type="text" class="form-control" id="url"
                                                           aria-describedby="basic-addon3"
                                                           placeholder="Please input your url name of deployment here..." onchange="pullUrl(this);">
                                                </div>
                                                <p class="box">: Deployment url that will use to be url name of deployment when you want to go to website of deployment.</p>
                                            </div>
                                        </div>

                                        <fieldset>
                                            <div class="form-group">
                                                <label for="typeDeploy" class="col-sm-3 control-label">Type of Deployment <r class="require">** : </r></label>
                                                <div class="col-sm-8" id="typeDeploy" onchange="pullType(this);">
                                                    <select id="select" class="form-control">
                                                        <option>Please select type of deployment...</option>
                                                        <?php
                                                        $connect = pg_connect("host=localhost port=5432 dbname=GCaaS user=postgres password=1234");
                                                        if (!$connect) {
                                                            print("Connection Failed.");
                                                            exit;
                                                        } else {
                                                            $myresult = pg_exec($connect, "SELECT \"type_Name\" FROM \"table_type\"");
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
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Description : </label>
                                            <div class="col-sm-8">
                                                <!--<input class="form-control" id="description" type="text" >-->
                    <textarea class="form-control" rows="5" id="description"
                              placeholder="Input description of deployment..." onchange="pullDesc(this);"></textarea>
                                            </div>
                                        </div>

                                        <ul class="list-inline pull-right">
                                            <li>
                                                <button type="button" class="btn btn-primary next-step">Continue</button>
                                            </li>
                                        </ul>
                                    </form>
                                </div> <!--./step 1 END-->

                                <!--step 2-->
                                <div id="step2" class="tab-pane fade">
                                    <h3>Deployment Area</h3>
                                    <p>Specifies about coverage area your deployment.</p>
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label for="area" class="col-sm-3 control-label">Area of Deployment :</label>
                                            <div class="col-sm-8">
                                                <a href="#" data-toggle="tooltip" data-placement="top"
                                                   title="static data layer cover this area is hospital,police station,fire station,..."><input
                                                        class="form-control" id="area" type="text"
                                                        placeholder="Please draw polygon on map for deployment area..."
                                                        disabled onchange="pullArea(this);"></a>
                                            </div>
                                            <br><br><br> <!--เว้นบรรทัดแผนที่ ไปแก้ที่ grayscale.js ดู margin-top-->
                                            <div id="map"></div>
                                        </div>

                                        <!--Map Section-->
                                        <!--<div id="map"></div>-->

                                    </form>
                                    <ul class="list-inline pull-right">
                                        <li>
                                            <button type="button" class="btn btn-default prev-step">Previous</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-primary next-step">Continue</button>
                                        </li>
                                    </ul>
                                </div> <!--./step 2 END-->

                                <!--step 3-->
                                <div id="step3" class="tab-pane fade">
                                    <h3>Dynamic data layers : </h3>
                                    <p>Specifies sort of static data layer for your deployment.</p>
                                    <form class="form-horizontal" role="form">
                                        <div class="panel panel-default" style="color: #333333">
                                            <div class="panel-body">
                                                <div class="col-sm-4">
                                                    <ul class="nav nav-pills nav-stacked">
                                                        <li class="active"><a href="#social-list">Social network</a>
                                                        </li>
                                                        <li class="disabled"><a href="#">Native apps</a></li>
                                                        <li class="disabled"><a href="#">Hardware</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="form-group fade in" id="social-list"
                                                         style="margin-left: 20px">
                                                        <label>Select information available in cover by area of
                                                            deployment</label>
                                                        <form role="form">
                                                            <div>
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" value=""
                                                                                  data-toggle="collapse"
                                                                                  data-target="#twitter-list" name="selected">Twitter</label>
                                                                </div>
                                                                <div class="panel-collapse collapse" id="twitter-list"
                                                                     style="margin-left: 10px">
                                                                    <ul>
                                                                        <form role="form">
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="optradio"
                                                                                       id="basic"
                                                                                       value="Twitter-basic"
                                                                                       onclick="cusToBasic()" checked>Basic
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="optradio"
                                                                                       id="customize"
                                                                                       value="Twitter-customize"
                                                                                       onclick="basicToCus()">Customize
                                                                            </label>
                                                                        </form>
                                                                    </ul>

                                                                    <ul>
                                                                        <form role="form" >
                                                                            <label>type of data :</label><br>
                                                                            <label class="radio-inline" style="margin-left: 50px">
                                                                                <input type="radio" name="optradio"
                                                                                       id="point"
                                                                                       value="Twitter-point" checked
                                                                                       disabled>Point
                                                                            </label>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="optradio"
                                                                                       id="layer"
                                                                                       value="Twitter-layer" disabled>Layer
                                                                            </label>
                                                                        </form>
                                                                        <p class="box">: - Point = data will be marker you can click on point that will show data in each point.
                                                                                        <br>&nbsp;&nbsp;- Layer = you can't do everything on point and infomation of point will show on sidebar.</p>
                                                                    </ul>

                                                                    <ul >
                                                                        <form role="form">
                                                                            <label>information you want to show in info or sidebar :</label><br>
                                                                            <div class="row" style="margin-left: 50px">
                                                                                <div class="col-sm-4">
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item1"
                                                                                               value="item1"
                                                                                               checked
                                                                                               disabled>Picture of User
                                                                                    </label>
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item2"
                                                                                               value="item2"
                                                                                               checked
                                                                                               disabled>Name of User
                                                                                    </label>

                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item3"
                                                                                               value="item3"
                                                                                               checked
                                                                                               disabled>Date of tweet
                                                                                    </label>
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item4"
                                                                                               value="item4"
                                                                                               checked
                                                                                               disabled>Picture in post
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item5"
                                                                                               value="item5"
                                                                                               checked
                                                                                               disabled>Message
                                                                                    </label>
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               name="selected"
                                                                                               id="item6"
                                                                                               value="item6"
                                                                                               checked
                                                                                               disabled>Latitude-Longitude
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </ul>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" value="" disabled>Facebook</label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" value="" disabled>Youtube</label>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <ul class="list-inline pull-right">
                                        <li>
                                            <button type="button" class="btn btn-default prev-step">Previous</button>
                                        </li>
<!--                                        <li>-->
<!--                                            <button type="button" class="btn btn-default next-step">Skip</button>-->
<!--                                        </li>-->
                                        <li>
                                            <button type="button" class="btn btn-primary btn-info-full next-step">Continue</button>
                                        </li>
                                    </ul>
                                </div> <!--./step 3 END-->

                                <!--complete-->
                                <div class="tab-pane" role="tabpanel" id="complete" style="text-align: center">
                                    <div style="background-color: #65d15c">
                                    <h3>Complete</h3>
                                    <p>You have successfully completed all steps.</p>
                                </div>

                                    <div id="config">
                                        <div class="container">
                                            <form class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label for="config-name" class="col-sm-3 control-label">Deployment Name : </label>
                                                    <div class="col-sm-8">
                                                        <input id="config-name" class="form-control" disabled>
                                                        <script>
                                                            function pullName(obj){
                                                                document.getElementById("config-name").value = obj.value ;
                                                            }
                                                        </script>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="config-url" class="col-sm-3 control-label">Deployment URL : </label>
                                                    <div class="col-sm-8">
                                                        <input id="config-url" class="form-control" disabled>
                                                        <script>
                                                            function pullUrl(obj){
                                                                document.getElementById("config-url").value = "https://GCaaS.com/"+obj.value ;
                                                            }
                                                        </script>
                                                    </div>
                                                </div>

                                                <fieldset>
                                                    <div class="form-group">
                                                        <label for="config-type" class="col-sm-3 control-label">Type of Deployment :</label>
                                                        <div class="col-sm-8">
                                                            <input id="config-type" class="form-control" disabled>
                                                            <script>
                                                                function pullType(obj){
                                                                    document.getElementById("config-type").value = obj.value ;
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="form-group">
                                                    <label for="config-desc" class="col-sm-3 control-label">Description : </label>
                                                    <div class="col-sm-8">
                                                        <input id="config-desc" class="form-control" disabled>
                                                        <script>
                                                            function pullDesc(obj){
                                                                document.getElementById("config-desc").value = obj.value ;
                                                            }
                                                        </script>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="config-area" class="col-sm-3 control-label">Area of Deployment : </label>
                                                    <div class="col-sm-8">
                                                        <input id="config-area" class="form-control" disabled>
                                                        <script>
                                                            function pullArea(obj){
                                                                document.getElementById("config-area").value = obj.value ;
                                                            }
                                                        </script>
                                                    </div>
                                                    <br><br><br>
                                                    <div id="map"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="area" class="col-sm-3 control-label">Dynamic data layer : </label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="area" type="text" disabled>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div> <!--intro-body END-->


                                    <button type="button" id="submit" class="btn btn-success btn-lg" onclick="submit()">Create your deployment</button>
                                </div> <!-- ./complete END-->

                                <div class="clearfix"></div>

                            </div> <!-- tab content END-->
                        </div> <!-- ./container tab pane END-->
                    </div> <!-- ./wizard END-->
            </div> <!--./ row END-->
            </section>
        </div> <!--./container obj END-->
    </div> <!--./container step progress-->


</div>


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

<script src="js/createDeploy.js"></script>
</body>

</body>
</html>