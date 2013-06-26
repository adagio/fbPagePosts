<?php

function has_no_url($str) {
  return ( strpos($str, 'http') === FALSE );
}

function has_url($str) {
  return !has_no_url($str);
}

function is_not_null($var) {
  return !is_null($var);
}

function is_not_set($var) {
  return !isset($var);
}

function str_remove_url($string) {
  $pattern = '/http([\S]+)/';
  $replacement = '';
  $string_with_no_url = preg_replace($pattern, $replacement, $string);
  return $string_with_no_url;
}

function cmp($a, $b)
{
  
  if ( !isset($a['likes']) && !isset($b['likes']) ) {
    return 0;
  }
  
  if ( !isset($a['likes']) ) {
    return 1;
  }
  
  if ( !isset($b['likes']) ) {
    return -1;
  }

  if ($a['likes']['count'] == $b['likes']['count']) {
    return 0;
  }
  return ($a['likes']['count'] > $b['likes']['count']) ? -1 : 1;
  
}
