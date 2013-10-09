<?php
session_start();

header("Content-Type: application/json");

if (isset($_GET['login'])) {

	// Get the JSON data
	$data = file_get_contents("php://input");
	$data = json_decode($data);

	if ($data->password == 'demo') {
		$_SESSION['demo'] = md5(date("Ymd").'UserLoggedIn');
		echo json_encode(array('status' => 'loggedIn', 'resp' => 'User is logged in! Yeah!'));
	} else {
		echo json_encode(array('status' => 'notLoggedIn', 'resp' => 'Wrong password! Oh, nay!'));
	}
} elseif (isset($_GET['logout'])) {
	session_destroy();
    echo json_encode(array('status'=>'LoggedOut'));
}