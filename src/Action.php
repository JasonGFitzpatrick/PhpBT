<?php

namespace PhpBT;

class Action extends Composite {

	private $delegate;

	public function __construct($d) {
		$this->delegate = $d;
	}

	public function Update() {
		$this->Status = call_user_func($this->delegate, '');
		return $this->Status;
	}
}