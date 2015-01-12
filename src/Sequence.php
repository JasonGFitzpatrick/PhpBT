<?php

namespace PhpBT;

class Sequence extends Composite {

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

			//Any Failure kills the sequence
			if($rs == RunStatus::FAILURE) {
				return RunStatus::FAILURE;
			}

			//If we have reached the end, the Sequnce was a success
			if($this->currentIndex >= count($this->Children) - 1) {
				return RunStatus::SUCCESS;
			}

			$this->currentIndex++;
		}
	}
}