<?php

//uses the PHP SDK.  Download from https://github.com/facebook/facebook-php-sdk
require 'facebookphp/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '358797270908365',
  'secret' => '8b5ad4ac3c4a166d0717c91f85c99cd6',
));

$userId = $facebook->getUser();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>clapp</title>
    <link rel="stylesheet" href="stylesheets/styles.css" type="text/css">
    <link rel="Shortcut Icon" href="images/favicon.ico">
    <link type='text/css' rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lobster'/>
    <link type='text/css' rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'/>

    <script type="text/javascript" src="javascript/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
  </head>
  
  <body>

      <script>

       window.fbAsyncInit = function() {
            FB.init({
              appId      : '358797270908365', // App ID
              channelUrl : '//blooming-reef-3850.herokuapp.com/channel.html', // Channel File
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });


            FB.Event.subscribe('auth.login', function(response) {
            window.location.reload();
          });

          };

          // Load the SDK Asynchronously
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/all.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
      </script>

                    <p>
                        Mutual Likes (MuLi): Search for friends with the most common interests.
                    </p>
                      <?php
                        $fql = "SELECT page_id, name FROM page WHERE page_id IN (SELECT page_id FROM page_fan WHERE uid=me())";
                       
                              $userResponse = $facebook->api(array(
                                'method' => 'fql.query',
                                'query' =>$fql,
                              ));

                      $fql = "SELECT uid1 from friend where uid2=me()";
                       $friendids = $facebook->api(array(
                                'method' => 'fql.query',
                                'query' =>$fql,
                              ));
                    foreach ($friendids as &$friendid) {
                      $specificUid=$friendid['uid1'];
                    echo $specificUid;
                    echo "<br>";

                $fql = "SELECT page_id, name FROM page WHERE page_id IN (SELECT page_id FROM page_fan WHERE uid=$specificUid)";
                              $response = $facebook->api(array(
                                'method' => 'fql.query',
                                'query' =>$fql,
                              ));
                              /*
                                foreach ($response as &$like) {
                                $likeId=$like['page_id'];
                                $likeName=$like['name'];
                      
                                echo $likeName;
                                echo "<br>";  
                             
                          }
                          */
                          echo count(array_intersect ($userResponse , $response));
                      }

                      ?>
</body>
</html>
