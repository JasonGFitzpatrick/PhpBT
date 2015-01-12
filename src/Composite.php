<?php

namespace PhpBT;

abstract class Composite {

	public $Status;
	private $currentIndex;
	public $Children;

	public function __construct() {
		$this->Status       = RunStatus::RUNNING;
		$this->Children     = [];
		$this->currentIndex = 0;
	}

	abstract function Update();

	public function Start() {
		$this->Status = RunStatus::RUNNING;
	}

	public function Stop() {
		if($this->currentIndex >= count($this->Children) || $this->Status == RunStatus::INVALID) {
			$this->currentIndex = 0;
			$this->Status       = RunStatus::FAILURE;
		}
	}

	public function Tick() {
		if($this->Status != RunStatus::RUNNING) {
			$this->Start();
		}

		$this->Status = $this->Update();

		return $this->Status;
	}
}
