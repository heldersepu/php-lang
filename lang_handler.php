<?php
  /*
    Language Handler System via Cookie.
  */
  include_once 'lang/langList.php';
  if(isSet($_GET['lang'])) {
    $lingua = $_GET['lang'];
    // register the session and set the cookie
    $_SESSION['lingua'] = $lingua;
    setcookie("lingua", $lingua, time() + (3600 * 24 * 30));
  }
  else if(isSet($_SESSION['lingua'])) {
    $lingua = $_SESSION['lingua'];
  }
  else if(isSet($_COOKIE['lingua'])) {
    $lingua = $_COOKIE['lingua'];
  }
  else {
    $lingua = 'en';
  }
  if(in_array($lingua, getLanguageList())){
    include_once 'lang/lang.'.$lingua.'.php';
  }
  else {
    include_once 'lang/lang.en.php';
  }
  $lang = new language();

?>