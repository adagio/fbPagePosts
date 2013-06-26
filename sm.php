<?php

// Provides access to app specific values such as your app id and app secret.
// Defined in 'AppInfo.php'
require_once('AppInfo.php');

// Enforce https on production
if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
	header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	exit();
}

// This provides access to helper functions defined in 'utils.php'
require_once('utils.php');
require_once('myutils.php');


/*****************************************************************************
 *
* The content below provides examples of how to fetch Facebook data using the
* Graph API and FQL.  It uses the helper functions defined in 'utils.php' to
* do so.  You should change this section so that it prepares all of the
* information that you want to display to the user.
*
****************************************************************************/

require_once('sdk/src/facebook.php');

$facebook = new Facebook(array(
		'appId'  => AppInfo::appID(),
		'secret' => AppInfo::appSecret(),
		'sharedSession' => true,
		'trustForwarded' => true,
));

/*
 * smashmag
 * webdesigntutsplus
 * thenextweb
 * InfoQ
 * */

$thenextweb_posts = idx($facebook->api('/thenextweb/feed?limit=30'), 'data', array());
$smashmag_posts = idx($facebook->api('/smashmag/feed?limit=30'), 'data', array());
$posts = array_merge($thenextweb_posts, $smashmag_posts);;
usort($posts, "cmp");

?>



<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type"
content="text/html;charset=utf-8">
  <title>Smash Magazine</title>
  <link rel="stylesheet" href="stylesheets/posts-screen.css" media="Screen" type="text/css" />
</head>
<body>

  <div id="fb-root"></div>
    <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=146533785539922";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    
<!--  
  <div id="header">
    
    <div class="fb-like" data-href="http://dctfb.com/sm.php" data-send="false" data-width="450" data-show-faces="true"></div>
  
    <div class="fb-send" data-href="http://dctfb.com/sm.php"></div>
  
  </div>
-->
  
  
  <div id="profile">
  
<!--
    
    <img src="https://graph.facebook.com/smashmag/picture" />
  
    <div class="fb-like-box" data-href="https://www.facebook.com/smashmag" data-width="292" data-height="550" data-show-faces="false" data-stream="true" data-show-border="true" data-header="false"></div>
  
    <div class="fb-comments" data-href="http://dctfb.com/smashmag.html" data-width="470" data-num-posts="10"></div>

-->
    
    
    <div class="list">
      <h2>Recent posts</h3>
      <ul class="posts">
        <?php

        foreach ($posts as $post) {
        // Extract the pieces of info we need from the requests above
          
          $id = idx($post, 'id');
          
          $from = idx($post, 'from');
          $from_name = $from['name'];
              
          $name = idx($post, 'name');
          $message = idx($post, 'message');
          $description = idx($post, 'description');

          /*
          $link = idx($post, 'link');*/
          $type = idx($post, 'type');
          /*$status_type = idx($post, 'status_type');
          $picture = idx($post, 'picture');
          $created_time = idx($post, 'created_time');
          $updated_time = idx($post, 'updated_time');
          $caption = idx($post, 'caption');
          $icon = idx($post, 'icon');
          */
          
          $likes = null;
          $shares = null;
          $shares_count = null;
          
          $likes = idx($post, 'likes');
          $likes_count = $likes['count'];
          
          $shares = idx($post, 'shares');
          
          if ( is_not_null($shares) )
            $shares_count = $shares['count'];
          
          $clean_message = str_remove_url($message);
          $clean_description = str_remove_url($description);
          
          if ( $type != "status") {
          
        ?>
        <li>
          <!-- <a href="https://www.facebook.com/<?php echo he($id); ?>" target="_top"> -->
            <?php
              
              if ($type == "photo") {
                
                echo "id: $id | <span style=\"color: red\">[ O ]</span> <b>$clean_message</b><br/>";
                
                echo "From: $from_name";
                
                if ( is_not_null($likes) )
                  echo " | Likes: $likes_count";
                
                if ( is_not_null($shares) ) {
                 
                  if ( is_not_null($likes) )
                    echo " | ";

                  echo "Shares: $shares_count";
                  
                }
                echo "<br/>";
                    
              } else {
              
                if ( is_not_null($name)  ) {
                  
                  echo "<b> $name</b><br/>";
                  
                  echo "From: $from_name";
                  
                  if ( is_not_null($likes) )
                    echo " | Likes: $likes_count";
                
                  if ( is_not_null($shares_count) ) {

                    if ( is_not_null($likes) )
                      echo " | ";

                    echo "Shares: $shares_count";
                    
                  }
                  
                  echo "<br/>";
                  
                } else
                  echo "<b>---</b><br/>";

                if (is_not_null($message))
                  echo "message: $clean_message<br/>";

                if (is_not_null($description))
                  echo "description: $clean_description<br/>";
                
              }
              
              /*
              echo "- link: " . $link . "</b><br/>";
              echo "- status_type: " . $status_type . "</b><br/>";
              echo "<b>" . $picture . "</b><br/>";
              echo "<b>" . $created_time . "</b><br/>";
              echo "<b>" . $updated_time . "</b><br/>";
              echo "<b>" . $caption . "</b><br/>";
              echo "<b>" . $icon . "</b><br/>";
              */
              
            ?>
          <!-- </a> -->
        </li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
    

  
  </div>
  
  
<!--  
  <div id="footer">
  
    <a href="#" 
      onclick="
        window.open(
          'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 
          'fb-share-dialog', 
          'width=626,height=436'); 
        return false;">
      Share on Facebook
    </a>
    
  </div>
-->
  
  
</body>
</html>
