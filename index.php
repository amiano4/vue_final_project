<?php session_start();

$url = isset($_GET['page']) ? "/{$_GET['page']}" : '/';

$url == '/' && redirectTo("/login"); // redirect index to login

$routes = [
  'global'  => [ '/', '/404' ],
  'guest'   => [ '/login', '/register' ],
  'auth'    => [ '/dashboard', '/users', '/profile' ]
];

filterVisitorURL();

include "includes/page_header.php";
include "src/pages"."$url.php";
include "includes/page_footer.php";

function filterVisitorURL() {
  global $url, $routes;

  // if unknown url, go to 404
  if(!isUrl($url))
    $url = "/404";

  // render 404 page
  if($url == "/404") {
    include "src/pages/404.php";
    exit();
  }

  // recycling the create account form for admin
  if($url == "/register" && isset($_COOKIE['vfp_admin_action_create_user'])) {
    return;
  }
  
  if(isUrl($url) == 'auth') {
    // guest accessing auth pages
    if(isGuest())
      redirectTo("/login");

    // normal user accessing admin assets
    if($url == "/users" && isUser())
      redirectTo("/dashboard");
      
  } else {
    // admin/user accessing non-auth pages
    if(!isGuest()) {
      redirectTo("/dashboard");
    }
  }
}

function redirectTo($url) {
  header("location: .$url"); 
  exit();
}

function isUrl($url) {
  global $routes;
  
  if(in_array($url, $routes['global']))
    return 'global';
  
  if(in_array($url, $routes['guest']))
    return 'guest';

  if(in_array($url, $routes['auth']))
    return 'auth';

  return false;
}

function isUser() {
  return isset($_SESSION['user-data']) && $_SESSION['user-data']['role'] == 1;
}

function isAdmin() {
  return isset($_SESSION['user-data']) && $_SESSION['user-data']['role'] == 0;
}

function isGuest() {
  return !isset($_SESSION['user-data']);
}

?>