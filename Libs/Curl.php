<?php

namespace Libs;

use Exception;

class Curl
{

	/**
	 * @var array
	 */
	private $_configs = [];

	/**
	 * @var Curl
	 */
	private static $_instance = null;

	public function __construct()
	{
		$this->setConfigs();
	}	

	/**
	 * @return Curl
	 */
	static function getInstance()
	{
		if (null == self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function setConfigs()
	{
		$this->_configs = require('../configs/api.php');
	}

	public function getConfigs(string $key = null)
	{
		return ($key !== null) ? $this->_configs[$key] : $this->_configs;
	}

	public function buildUrl(string $keyApi)
	{
		$url = '';
		$url .= ($this->_configs['ssl']) ? 'https://' : 'http://';
		$url .= "{$this->_configs['host']}/";
		$url .= ($this->_configs['version']) ? "{$this->_configs['version']}/" : '';
		$url .= "{$this->_configs['subPath']}/";
		$url .= ($this->_configs['apis'][$keyApi]) ? "{$this->_configs['apis'][$keyApi]}/" : '';
		return $url;
	}

	public function get($url)
	{
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);
			curl_close($curl);

			$result = [
				'status' => 400,
				'data' => null
			];

			if ($response) {
				$result = [
					'status' => 200,
					'data' => json_decode($response, true)
				];
			}
			return $result;
		}
		catch(Exception $e) {
			throw $e;
		}
	}
}
