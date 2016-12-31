# PageMunch - Web crawler for PHP


## Introduction

PageMunch is a simple API backed by an intelligent web crawler, that lets you extract data from any webpage on the internet in milliseconds. Whether you want to grab the best title, description and image for a page, prices, authorship, enable video embeds or more. We make it crazy easy to treat the web like a database.


## Installation

You can install the PHP module using Composer, simply add it to your requirements, for example:

    {
        "require": {
            "PageMunch/PageMunch": ">=1.0.0"
        }
    }

Or clone the repository directly from GitHub and use the class in the vendors directory of your Framework or elsewhere.

## Usage

```php
// if using Composer then you should use an autoloader, otherwise require the
// file however you might normally
require('src/PageMunch/PageMunch.php');
use PageMunch\PageMunch;

// create a new API object to use for requests - your API key from the PageMunch
// account dashboard should be passed in here. We recommend using an environment
// variable to make distributing code between environments easier and more secure
$api = new PageMunch(array('key' => getenv('PAGEMUNCH_API_KEY')));

$response = $api->extract('http://www.youtube.com/watch?v=9bZkp7q19f0');

// check if the API call succeeded and output the title from the response data
if ($response) {
	print_r($response->title);
} else {
	print_r($api->getError()->message);
}
```


## More Details

For more information, libraries and documentation check out the **[PageMunch Documentation](http://www.pagemunch.com/docs "PageMunch - Web crawler, metadata extraction")**


## License

This module is Copyright PageMunch 2017.
