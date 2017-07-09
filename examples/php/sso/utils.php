<?php
use \Firebase\JWT\JWT;

require_once (__DIR__ . "/partner_data.php");

/**
 * getSSOPartnerById - returns the partner object of given partnerId
 *
 * @param  {String} $ssoId Id of the partner
 * @return {Object}            Partner object
 */
function getSSOPartnerById($ssoId){
  // Checking whether the partner exist and  is active
  if (array_key_exists($ssoId, SSO::partners) && SSO::partners["$ssoId"]["is_active"])
      return SSO::partners["$ssoId"];
  throw new Exception('partnerId not found or suspended');
}


/**
 * generateToken - Generate JSON Web Token for partner service
 *
 * @param  {String} $ssoId Partner id
 * @param  {String} $key       shared key for signing the token
 * @return {String}            JWT signed using $key
 */
function generateToken($ssoId, $key){
  $token = array(
    "email" => "example@abc.com", // email address of teh loggedin user
    "iss" => "https://linways.com",
    "exp" => time() + (3 *60), // expires 3 minutes from now
    "iat" => time(),
    "aud" => $ssoId,
  );
  return JWT::encode($token, $key);
}


/**
 * verifyToken - verify the token
 *
 * @param  {String} $ssoId SSO partner id
 * @param  {String} $jwt   JSON Web Token from sso partner
 * @return {AssocArray}    token content
 */
function verifyToken($ssoId, $jwt){
  // Get partner details using ssoId
  $partner = getSSOPartnerById($ssoId);
  /**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
  JWT::$leeway = 60;  // $leeway in seconds, This is optional
  return (array) JWT::decode($jwt, $partner['shared_key'], array('HS256'));
}
