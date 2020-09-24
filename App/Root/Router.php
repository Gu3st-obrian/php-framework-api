<?php
namespace App\Root;

class Router
{
	private $urlpath;
	private $urlname;
	private $class;
	private $function;
	private $guardian;

	public function __construct($url, $name, $classe, $fn) {
		$this->urlpath = $url;
		$this->urlname = $name;
		$this->class = $classe;
		$this->function = $fn;
	}

	public function setGuard($guardClass) {
		$this->guardian = $guardClass;
	}

	public function getUri() {
		return $this->urlname;
	}

	public function getUrl() {
		return $this->urlpath;
	}

	public function getController() {
		return $this->class;
	}

	public function getCallback() {
		return $this->function;
	}

	public function getGuardian() {
		return $this->guardian;
	}
}
