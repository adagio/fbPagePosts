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

function str_remove_url($string) {
  $pattern = '/http([\S]+)/';
  $replacement = '';
  $string_with_no_url = preg_replace($pattern, $replacement, $string);
  return $string_with_no_url;
}

