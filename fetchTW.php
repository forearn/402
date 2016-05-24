<?php include "twitteroauth.php"; ?>
<?php 
    $consumer="cbyagg294ICwg4SwvVdTDOnAk";
    $consumersecret="k3GeVHy21yoTMjCTgLcjQMFZvDj5Mf1T4QSGRrxK9iZNiuSax9";
    $accesstoken="131746690-9c1O8LTHonwN5i7C8aXmNrUNV7ui9LwLAPCEfKWV";
    $accesstokensecret="AtXEXhPTraD7lglCG6oB0Sdi2RFBNxADIu2bGwIRPiO31";
   
    $connect = pg_connect("host=localhost port=5432 dbname=DB_test user=postgres password=1234");
    if (!$connect) {
        print("Connection Failed.");
        exit;
    } else {
        $twitter = new TwitterOAuth($consumer,$consumersecret,$accesstoken,$accesstokensecret);
        $tweets = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=%23GCaaS&result_type=th&count=50');

        foreach ($tweets as $tweet){         
            foreach($tweet as $t){
                $sql = "INSERT INTO \"table_postTWH\"(\"post_Name\", \"post_GeomIncident\", \"post_Date\", \"post_Status\", \"post_Message\", \"post_Hashtag\") VALUES ('" . $t->user->name ."', ST_GeomFromText('POINT(" . $t->geo->coordinates[1] . " " . $t->geo->coordinates[0] . ")',4326), '" . $t->created_at . "', 'New' , '" . $t->text . "', 'GCaaS');"
                $myresult = pg_exec($connect, "INSERT INTO \"table_postTWH\"(\"post_Name\", \"post_GeomIncident\", \"post_Date\", \"post_Status\", \"post_Message\", \"post_Hashtag\") VALUES ('" . $t->user->name ."', ST_GeomFromText('POINT(" . $t->geo->coordinates[1] . " " . $t->geo->coordinates[0] . ")',4326), '" . $t->created_at . "', 'New' , '" . $t->text . "', 'GCaaS');");
                // echo $sql
                // echo "</br>"."<img src =".$t->user->profile_image_url." >";
                // echo "&nbsp&nbsp&nbsp ".$t->user->name."</br>";
                // echo $t->text;
                // echo " ";
                // echo $t->geo->coordinates[0]."&nbsp&nbsp ".$t->geo->coordinates[1]."&nbsp&nbsp ";
                // echo $t->place->full_name." &nbsp&nbsp";
                // echo $t->created_at." &nbsp&nbsp";
                // echo "</br>";
            }
        }
    } 
?> 
<!-- ST_GeomFromText('POINT(100.643198665018 13.8314282714434)',4326) -->