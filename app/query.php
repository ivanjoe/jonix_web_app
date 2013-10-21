<?php
$url = 'http://195.148.149.175:8080/jonix/send';

// Get the JSON data
$data = $_GET;
$query = $_GET['query'];

$url = "http://light.onki.fi/rest/v1/ysa/search?query=".$query."*&lang=fi";

//print_r($data);

// Create curl handle
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_GET, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute
$ch_result = curl_exec($ch);

// Check if any error occured
/*if(!curl_errno($ch))
{
 $info = curl_getinfo($ch);
 $info['result'] = $ch_result;
}*/

// Close the connection
curl_close($ch);

// Return some status messages
echo $ch_result;