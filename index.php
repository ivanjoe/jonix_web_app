<?php
$urls = explode('/', $_SERVER['PHP_SELF']);
$urls = array_slice($urls, 0, -1);

$redirect = implode('/',$urls);
$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $redirect . '/app';

header("Location: $redirect");