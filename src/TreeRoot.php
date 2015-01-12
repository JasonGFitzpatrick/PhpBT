<?php

namespace PhpBT;

use Exception;

class TreeRoot {
	private $hooks;
	private $rawHooks;
	private $throttle;

	public function __construct($pause = 1) {
		$this->throttle = $pause;
		$this->hooks    = new PrioritySelector();
		$this->rawHooks = [];
	}

	public function AddHook($name, Composite $h) {
		array_push($this->rawHooks, [
			'name' => $name,
			'value' => $h
			]);

		array_push($this->hooks->Children, $h);
	}

	public function RemoveHook($name) {

	}

	public function RebuildTree() {
		$this->hooks = new PrioritySelector();

		foreach($this->rawHooks as $h) {
			array_push($this->hooks->Children, $h['value']);
		}
	}

	private function tick() {
		while(true) {
			if($this->hooks->Status != RunStatus::RUNNING) {
				$this->hooks->Start();
			}

			try {
				$this->hooks->Tick();
			}
			catch(Exception $e) {
				echo $e->getMessage()."\n";
				break;
			}

			try {
				echo "***************** Tick Complete *****************\n";
				sleep($this->throttle);
			}
			catch(Exception $e) {
				echo $e->getMessage()."\n";
				break;
			}
		}
	}

	public function Start() {
		try {
			$this->tick();
		}
		catch(Exception $e) {
			echo $e->getMessage()."\n";
			return;
		}
	}

	public function Stop() {
		$this->hooks->stop();
	}
}