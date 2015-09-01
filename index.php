<?php

//debug
ini_set('display_errors','On');
error_reporting(E_ALL & ~E_NOTICE);

//set authentication parameters
$authUser = '';
$authPass = '';
$X_apikey = '';

//load Httpful library
require_once('./vendor/nategood/httpful/bootstrap.php');
use \Httpful\Request;

//function to avoid injection of malicious code
function removeSpecialChars($string) {
	$string = str_replace(' ', '', $string); //deletes all spaces
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); //removes special chars
}

//GET credentials
$cred['couponId'] = (int)$_GET['coupon_id'];
$cred['passkey'] = substr(removeSpecialChars($_GET['passkey']),0,32); //generated passkey is always 32 chars long
$cred['issuerGuid'] = removeSpecialChars($_GET['issuer_guid']); //issuerGuid can have different length

//start http request
try {
	//POST
	$response = Request::post('http://dispatcher.onlinelabs4all.org/apis/engine/verifyCoupon')
		->body(json_encode($cred))
		->authenticateWith($authUser,$authPass)
		->addHeader('X-apikey',$X_apikey)
		->expectsJson()
		->send();

	//check status code
	if($response->code === 401) {
		echo '<b>Error!</b> Status Code: 401 (Unauthorized)';
		exit;
	} else if($response->code === 415) {
		echo '<b>Error!</b> Status Code: 415 (JSON not set)';
		exit;
	} else if(!($response->code === 200)) {
		echo '<b>Error!</b> Status Code: ' . $response->code;
		exit;
	}

	//check success
	if(!$response->body->success) {
		echo '<b>Unauthorized!</b> (Error Message: ' . $response->body->errorMessage . ')';
		exit;
	} else {
		$couponVerified = true;
		//Load client
		include_once('./LabClient.php');
	}
} catch (Exception $e) {
	echo '<b>Exception:</b> ' . $e->getMessage();
}

?>
