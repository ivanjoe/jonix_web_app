<?php
require('settings.php');
// Get the params
$recref = $_GET['rref'];

$products_url.=$recref;

// Create curl handle
$ch = curl_init($products_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_GET, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute
$ch_result = curl_exec($ch);

// Check if any error occured
if(curl_errno($ch))
{
  // Failed to reach the site
  $info['result'] = curl_error($ch);
  $info['http_code'] = 404;
} else {
  // Reached the site, return some info
  $info = curl_getinfo($ch);
  $info['xml'] = $ch_result;
  $objects = simplexml_load_string($ch_result);
  $info['result'] = $objects;
}

// Close the connection
curl_close($ch);

// Return some status messages
echo json_encode($info);