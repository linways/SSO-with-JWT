<?php

require_once(__DIR__ . "/utils.php");

// Obtained from the router's global variable $URL_PARAMS
$ssoId = $URL_PARAMS['ssoId'];

try{
  $partner = getSSOPartnerById($ssoId);
  // Check the user is logged in and have required permissions here
  $jwt = generateToken($ssoId, $partner['shared_key']);


  // Creating the response
  $response = <<<EOT
  <b>Generated Token :</b><br/>
    <pre>
    $jwt
    </pre>
  <a href="/sso/token/verify?ssoid=$ssoId&jwt=$jwt">Click Here</a> to verify the token.<br/>
  This should be done at the partner service.
EOT;
  echo $response;

}catch(Exception $e){
  echo $e->getMessage();
}
