<?php

// if using Composer then you should use an autoloader,
// otherwise require the file however you might normally
require('src/PageMunch/PageMunch.php');
use PageMunch\PageMunch;

// create a new API object to use for requests
// don't forget to enter your own API key from the dashboard here.
$api = new PageMunch(array('key' => 'YOUR_API_KEY'));

// make an API call
$response = $api->summary('http://www.youtube.com/watch?v=9bZkp7q19f0');

// check if the API call succeeded and ouput a response.
if ($response) {
	print_r($response->name);
} else {
	print_r($api->getError()->message);
}

?>