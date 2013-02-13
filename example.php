<?php

require('src/PageMunch/PageMunch.php');
use PageMunch\PageMunch;

$api = new PageMunch(array('key' => 'YOUR_API_KEY'));

$response = $api->summary('http://www.youtube.com/watch?v=9bZkp7q19f0');

if ($response) {
	print_r($response->name);
} else {
	print_r($api->getError()->message);
}

?>