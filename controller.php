<?php

function get_posts() {

  $use_cache = false;
  
  if ($use_cache) {
    $posts_cache = unserialize(file_get_contents('cache/posts_cache.bin'));;
    $posts= $posts_cache;
  } else {

    // Provides access to app specific values such as your app id and app secret.
    // Defined in 'AppInfo.php'
    require_once('AppInfo.php');

    // Enforce https on production
    if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
      header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      exit();
    }

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
     * https://www.facebook.com/thenextweb
     * https://www.facebook.com/techcrunch
     * https://www.facebook.com/ReadWrite
     * https://www.facebook.com/mashable
     * 
     * https://www.facebook.com/gizmodo
     * https://www.facebook.com/Engadget
     * 
     * https://www.facebook.com/ThisIsTheVerge
     * https://www.facebook.com/venturebeat
     * https://www.facebook.com/businessinsider
     * 
     * https://www.facebook.com/lifehacker
     * 
     * https://www.facebook.com/alt1040
     * https://www.facebook.com/wwwhatsnew
     * https://www.facebook.com/fayerwayer
     * https://www.facebook.com/bitelia
     * https://www.facebook.com/Omicrono
     * 
     */
    
    
    /*
    $thenextweb_posts = idx($facebook->api('/thenextweb/feed?limit=30'), 'data', array());
    $mashable_posts = idx($facebook->api('/mashable/feed?limit=30'), 'data', array());
    $posts = array_merge($thenextweb_posts, $mashable_posts);
    */
    
    /*
    $techcrunch_posts = idx($facebook->api('/techcrunch/feed?limit=30'), 'data', array());
    $ReadWrite_posts = idx($facebook->api('/ReadWrite/feed?limit=30'), 'data', array());
    $posts = array_merge($techcrunch_posts, $ReadWrite_posts);
    */
    
    /*
    #$fayerwayer_posts = idx($facebook->api('/fayerwayer/feed?limit=30'), 'data', array());
    $alt1040_posts = idx($facebook->api('/alt1040/feed?limit=30'), 'data', array());
    $wwwhatsnew_posts = idx($facebook->api('/wwwhatsnew/feed?limit=30'), 'data', array());
    $bitelia_posts = idx($facebook->api('/bitelia/feed?limit=30'), 'data', array());
    $Omicrono_posts = idx($facebook->api('/Omicrono/feed?limit=30'), 'data', array());
    $posts = array_merge($alt1040_posts, $wwwhatsnew_posts, $bitelia_posts, $Omicrono_posts);
    */
    
    #https://www.facebook.com/drupalizeme
    #https://www.facebook.com/pages/7sabores/321743567939661
    $drupalizeme_posts = idx($facebook->api('/drupalizeme/feed?limit=30'), 'data', array());
    $_7sabores_posts = idx($facebook->api('/321743567939661/feed?limit=30'), 'data', array());
    $posts = array_merge($drupalizeme_posts, $_7sabores_posts );
    
    usort($posts, "posts_likes_count_cmp");
    //$InfoQ_posts = idx($facebook->api('/InfoQ/feed?limit=30'), 'data', array());

    $posts_cache = serialize($posts);
    file_put_contents('cache/posts_cache.bin', $posts_cache);
  }

  $first_30 = array_slice($posts, 0, 30);
  
  return $first_30;
  
}

