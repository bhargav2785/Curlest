<?php

/**
 * @author   : Bhargav Vadher
 * @version  : V1.0 6/25/14 8:08 PM
 *
 * a PHP cURL request library
 */
class Curlest
{

	const CURL_TIMEOUT = 10; // seconds

	public function __construct() {}

	/**
	 * Send a GET request using cURL
	 *
	 * @param string $url     request url
	 * @param array  $get     key value pairs for URL params
	 * @param array  $options cURL options
	 *
	 * @return array
	 */
	public function get( $url, array $get = array(), array $options = array() ) {
		$defaults = array(
			CURLOPT_URL            => $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($get),
			CURLOPT_HEADER         => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT        => self::CURL_TIMEOUT,
			CURLOPT_HTTPHEADER     => $options
		);

		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));

		if( !($result = curl_exec($ch)) ){
			trigger_error(curl_error($ch));
		}

		$curlInfo = curl_getinfo($ch);

		curl_close($ch);

		return array(
			'json'     => $result,
			'curlInfo' => $curlInfo
		);
	}

	/**
	 * Send a POST request using cURL
	 *
	 * @param String $url         request url
	 * @param String $jsonPayload values to send as in JSON format
	 * @param Array  $headers     cURL headers
	 * @param Array  $options     cURL options
	 *
	 * @return Array
	 */
	public function post( $url, $jsonPayload = '', $headers = array(), $options = array() ) {
		$defaults = array(
			CURLOPT_POST           => 1,
			CURLOPT_HEADER         => 0,
			CURLOPT_URL            => $url,
			CURLOPT_FRESH_CONNECT  => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE   => 1,
			CURLOPT_TIMEOUT        => self::CURL_TIMEOUT,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_POSTFIELDS     => $jsonPayload
		);

		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));

		if( !($result = curl_exec($ch)) ){
			trigger_error(curl_error($ch));
		}

		$curlInfo = curl_getinfo($ch);

		curl_close($ch);

		return array(
			'json'     => $result,
			'curlInfo' => $curlInfo
		);
	}

}