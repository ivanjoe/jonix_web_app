<?php
session_start();
$url = $_SESSION['url'];

/* Function definition is taken from
 * http://stackoverflow.com/a/5965940/3021745
 */
// function definition to convert array to xml
function array_to_xml($info, $xml, $lastkey=null) {
  foreach ($info as $key => $value) {
    if(is_array($value)) {
      if(!is_numeric($key)) {
        if (isset($value[0])) {
          array_to_xml($value, $xml, $key);
        } else {
          $subnode = $xml->addChild(ucfirst($key));
          array_to_xml($value, $subnode, $key);
        }
      } else {
        $subnode = $xml->addChild(ucfirst($lastkey));
        array_to_xml($value, $subnode);
      }
    } else {
      $xml->addChild(ucfirst($key), "$value");
    }
  }
}

// Get the JSON data
$data = file_get_contents("php://input");
$data = json_decode($data, true);

// ONIX message string
$onix = '';

// Transcode it to XML
$xml = new SimpleXMLElement('<ONIXMessage release="3.0" xmlns="http://ns.editeur.org/onix/3.0/reference"></ONIXMessage>');

// Function call to convert array to XML
array_to_xml($data, $xml);

// Passing on the generated XML
$onix = $xml->asXML();

// TODO: Send to server, get respond
// Create curl handle
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $onix);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute
$ch_result = curl_exec($ch);

// Check if any error occured
if(curl_errno($ch))
{
  $info = new StdClass();
  $info->result = curl_error($ch);
  $info->http_code = 404;
  $info->onix = $onix;
} else {
  $info = curl_getinfo($ch);
  $info['result'] = $ch_result;
  $info['onix'] = $onix;
  $urls = explode('/', $_SERVER['REQUEST_URI'], -1);
  $url = implode('/', $urls);
  $url = $_SERVER['SERVER_NAME'].$url;
  foreach ($data['product'] as $prod) {
    //$info['view_product'][] = $url."/index.php#/products/".
    $info['view_product'][] = "#/products/".
      $prod['recordReference']."/edit";
  }
}

// Close the connection
curl_close($ch);

// Return some status messages
header("Content-Type: application/json");
echo json_encode($info);
