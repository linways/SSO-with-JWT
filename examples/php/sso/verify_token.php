<?php
use \Firebase\JWT\JWT;
require_once(__DIR__ . "/utils.php");

// Query parameters
$ssoId = $_GET['ssoid'];
$jwt = $_GET['jwt'];

try{
  // verifying token
  $token = verifyToken($ssoId, $jwt);

  // Creating the response
  // Write the logic for logging in the user and redirect to required page
  echo "<b>Token verified:</b> <br/>";
  print_r($token);

}catch(Exception $e){
  echo $e->getMessage();
}
