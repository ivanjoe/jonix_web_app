<?php
session_start();
require('settings.php');
$response = '';

if (isset($_GET['login'])) {

	// Get the JSON data
	$data = file_get_contents("php://input");
	$data = json_decode($data);

	if ($data->password == 'demo') {
		$_SESSION['demo'] = md5(date("Ymd").'UserLoggedIn');
		// Store in the session the proxies
		$_SESSION['url'] 				= $url;	// The backend's address
		$_SESSION['geonames_username'] 	= $geonames_username; // The username for Geonames
		$_SESSION['products_url'] 		= $products_url; // The url to get the product info
		$_SESSION['title'] 				= 'normal';

		$response = json_encode(array('status' => 'loggedIn', 'resp' => 'User is logged in! Yeah!'));
	} elseif ($data->password == 'nodata') {
		$_SESSION['demo'] = md5(date("Ymd").'UserLoggedIn');
		// Store in the session the proxies
		$_SESSION['url']				= '';
		$_SESSION['geonames_username']	= $geonames_username;
		$_SESSION['products_url'] 		= '';
		$_SESSION['title']				= 'demo';

		$response = json_encode(array('status' => 'loggedIn', 'resp' => 'User is logged in, but we will not send any data to the backend!'));
	} else {
		$response = json_encode(array('status' => 'notLoggedIn', 'resp' => 'Wrong password! Oh, nay!'));
	}
} elseif (isset($_GET['logout'])) {
	session_destroy();
    $response = json_encode(array('status'=>'LoggedOut'));
}

header("Content-Type: application/json");
echo $response;