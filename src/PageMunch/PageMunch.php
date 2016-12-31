<?php

/*
 * This file is part of the PageMunch package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PageMunch;

class PageMunch {

	/**
	* The library version, will be provided in the request headers.
	*/
	const VERSION = '1.0.0';

	private $config = array();
	public $response = array();

	public function __construct(array $config = array()) {

		$this->config = array_merge(array(
			'host' => 'api.pagemunch.com',
			'version' => '1',
			'format' => 'json',
			'key' => '',
			'user_agent' => 'pagemunch-php ('. self::VERSION .')',
			'curl_connecttimeout' => 2,
			'curl_timeout' => 5
		), $config);
	}


	/**
	 * Requests a summary of the URL
	 *
	 * @param  string  $url     The url to parse
	 * @param  array   $options Additional query parameters
	 * @return Mixed   Returns a response object on success, otherwise false.
	 */
	public function extract($url, array $options = array()) {

		return $this->get('extract', array_merge(array(
			'url' => $url
		), $options));
	}


	/**
	 * Constructs a full URI to make an API request including
	 * the API key.
	 *
	 * @param  string  $method   The name of an API endpoint
	 * @param  array   $options  Additional query parameters
	 * @return Mixed   Returns a response object on success, otherwise false.
	 */
	public function get($method, array $options = array()) {

		$options['apiKey'] = $this->config['key'];

		$url = 'https://'. $this->config['host'] . '/'. $method .'?'. http_build_query($options);

		if ($this->request($url)) {
			return $this->getResponse();
		}

		return false;
	}


	/**
	 * Once a request to the API has been made, this method will
	 * return the full decoded response object of the last call.
	 *
	 * @return object  Returns a response object
	 */
	public function getResponse() {
		return $this->response['response'];
	}


	/**
	 * In the event that an API request fails, calling this method
	 * will return the error object with details on the failure.
	 *
	 * @return object  Returns a response object
	 */
	public function getError() {
		return $this->response['response'] ?: $this->response['error'];
	}


	/**
	 * Performs a curl request to the PageMunch API and gathers the
	 * response information into a single parsed object.
	 *
	 * @param  string  $url    The fully qualified path of an API request
	 * @return boolean  Whether or not the request succeeded.
	 */
	private function request($url) {

		// configure curl
		$c = curl_init();
		curl_setopt_array($c, array(
			CURLOPT_USERAGENT      => $this->config['user_agent'],
			CURLOPT_CONNECTTIMEOUT => $this->config['curl_connecttimeout'],
			CURLOPT_TIMEOUT        => $this->config['curl_timeout'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_ENCODING       => '',
			CURLOPT_URL            => $url,
			CURLOPT_HEADER         => false,
			CURLINFO_HEADER_OUT    => true,
		));

		// perform request
		$response = curl_exec($c);
		$status_code = (int) curl_getinfo($c, CURLINFO_HTTP_CODE);
		$info = curl_getinfo($c);
		$error = curl_error($c);
		$errno = curl_errno($c);
		curl_close($c);

		// store the response
		$this->response['status_code'] = $status_code;
		$this->response['info'] = $info;
		$this->response['error'] = $error;
		$this->response['errno'] = $errno;

		try {
			$this->response['response'] = json_decode($response);
		} catch(Exception $e) {
			$this->response['response'] = array(
				'code' => 500,
				'message' => 'Could not parse JSON response'
			);
		}

		return $status_code === 200;
	}
}

?>
