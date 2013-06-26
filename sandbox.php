<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type"
content="text/html;charset=utf-8">
  <title>Debugging</title>
  <link rel="stylesheet" href="stylesheets/posts-screen.css" media="Screen" type="text/css" />
</head>
<body>
<?php


function cmp($a, $b)
{
  if ( !isset($a['likes']) && !isset($b['likes']) ) {
    echo "no hay a[likes] ni b[likes]";
    return 0;
  }
  
  if ( !isset($a['likes']) ) {
    echo "no hay a[likes]";
    return 1;
  }
  
  if ( !isset($b['likes']) ) {
    echo "no hay b[likes]";
    return -1;
  }
  
  if ($a['likes']['count'] == $b['likes']['count']) {
    return 0;
  }
  return ($a['likes']['count'] > $b['likes']['count']) ? -1 : 1;
}


$likes1['count'] = 8;
$post1['likes'] = $likes1;
echo $post1['likes']['count'];

$likes2['count'] = 17;
$post2['likes'] = $likes2;
echo $post2['likes']['count'];

$post3 = array();

$post4 = array();

$posts[] = $post4;
$posts[] = $post1;
$posts[] = $post3;
$posts[] = $post2;

usort($posts, "cmp");

echo 'fin';

?>
</body>
</html>