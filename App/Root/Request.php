<?php
namespace App\Root;

class Request
{
	private $tampon;
	private $urlpage;
	private $variables;

	public function __construct($urlpage) {
		$this->urlpage = $urlpage;
		$this->setMapParams($_REQUEST);
	}

	private function setMapParams($request) {
		foreach ($request as $key => $value) {
			$this->variables[is_int($key) ? 'get':'post'][$key] = $value;
		}
	}

	public function paramMap($index) {
		$type = is_int($index) ? 'get':'post';
		$this->tampon = isset($this->variables[$type][$index]) ? $this->variables[$type][$index] : '';
		return $this;
	}

	public function int() {
		return intval($this->tampon);
	}

	public function bool() {
		return boolval($this->tampon);
	}

	public function float() {
		return floatval($this->tampon);
	}

	public function double() {
		return doubleval($this->tampon);
	}

	public function text() {
		return strval($this->tampon);
	}

	public function object() {
		return $this->tampon;
	}
}
