<?php

namespace PhpBT;

class PrioritySelector extends Composite {

	private $currentIndex;

	public function __construct() {
		$this->currentIndex = 0;
		$this->Children     = [];
		$numargs            = func_num_args();
		$args               = func_get_args();

		if($numargs == 0) {
			return;
		}

		foreach($args as $c) {
			array_push($this->Children, $c);
		}
	}

	public function Update() {

		$this->currentIndex = 0;

		while(true) {
			$rs = $this->Children[$this->currentIndex]->Tick();

			if($rs != RunStatus::FAILURE) {
				return $rs;
			}

			if($this->currentIndex >= count($this->Children) - 1) {
				return RunStatus::FAILURE;
			}

			$this->currentIndex++;
		}
	}
}