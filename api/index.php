<?php session_start();

require_once("./Connection.php");
require_once("./Auth.php");
require_once("./Functions.php");

$method = $_SERVER['REQUEST_METHOD'] == "POST" ? $_POST['method'] : false;

if($method && function_exists($method)) {
  $con = new DBConnection();
  call_user_func($method);
} else {
  die(http_response_code(405));
}

// helper function
function res_send($var) {
  echo is_array($var) ? json_encode($var) : $var;
}