<?php
namespace App\Root;
use \Exception;

class Crypto
{
	private $active;
	private $algorithm;
	private $complexity;
	private $format;
	private $start = 0;
	private $secretkey;
	private $secretiv;
	private $secretNumber = [];

	public function __construct($configs) {
		$this->algorithm = $configs['algorithm'];
		$this->complexity = $configs['complex'];
		$this->format = $configs['app-type'];
		$this->start = $configs['start'];
		$this->secretkey = $configs['key'];
		$this->secretiv = $configs['iv'];
		$this->initer($configs['active']);
	}

	private function initer($active) {
		if ($active == 'yes') {
			$this->active = true;
		}
		elseif ($active == 'no') {
			$this->active = false;
		}
		else {
			throw new Exception("Active Crypto by using only yes or no on your app.", 1);
		}
	}

	public function AesEncrypt($plaintext, $token) {
		$message = openssl_encrypt($plaintext, $this->algorithm, $this->SecretRandom($token), $this->start, $this->SecretRandom($token));
		return $this->crypto->Keys() . $message;
	}

	public function AesDecrypt($ciphertext, $token) {
		$secretKey = substr($token, $this->start, 2);
		$secretIv = substr($token, 2, 2);
		$message = openssl_decrypt($ciphertext, $this->algorithm, $secretKey, $this->start, $secretIv);
		return $message;
	}

	private function Keys() {
		return !empty($this->secretNumber) ? implode('', $this->secretNumber) : '';
	}

	private function SecretRandom($token) {
		$strlen = strlen($token);
		$maxlen = 16;
		$randomNum = mt_rand(1, $strlen - $maxlen);
		$randomNum = substr($token, $randomNum, $maxlen);
		$this->secretNumber[] = $randomNum;
		return $randomNum;
	}
}
