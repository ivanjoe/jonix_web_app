<?php
$url = 'http://195.148.149.175:8080/jonix/send?key=34042286-16c0-4c77-8968-c7a45f79224a';

// Get the JSON data
$data = file_get_contents("php://input");
$data = json_decode($data);


// TODO: Transcode it to XML
// TODO: Send to server, get respond

$data = '<?xml version="1.0"?>
<ONIXMessage release="3.0" xmlns="http://ns.editeur.org/onix/3.0/reference">
  <Header>
    <SentDateTime>'.$data->header->sentDateTime.'</SentDateTime>
    <Sender/>
    </Header>
  <Product>
  	<RecordReference>wwww.aakjkljklj.com</RecordReference>
  	<NotificationType>01</NotificationType>
  	<ProductIdentifier/>
  </Product>
  </ONIXMessage>';

// Create curl handle
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute
$ch_result = curl_exec($ch);

// Check if any error occured
if(!curl_errno($ch))
{
 $info = curl_getinfo($ch);
 $info['result'] = $ch_result;

 //echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "<br/>";
 //echo 'Status code:' . $info['http_code'] . "<br/>";
}

// Close the connection
curl_close($ch);

// Return some status messages
echo json_encode($info);