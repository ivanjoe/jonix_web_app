<?php
$url = 'http://195.148.149.175:8080/jonix/send';

// Get the JSON data
$data = $_GET;
$query = $_GET['query'];
$schid = $_GET['schid'];
$url = '';

switch ($schid) {
	// YSA
	case 64:
		$url = "http://light.onki.fi/rest/v1/ysa/search?query=".$query."*&lang=fi";
		break;
	// GeoNames ID
	case 86:
		$url = "http://api.geonames.org/searchJSON?formatted=true&name=".$query."*&maxRows=10&lang=fi&username=almalm&style=short";
		break;
	default:
		# code...
		break;
}

// Create curl handle
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_GET, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute
$ch_result = curl_exec($ch);

// Close the connection
curl_close($ch);

// Return some status messages
echo $ch_result;