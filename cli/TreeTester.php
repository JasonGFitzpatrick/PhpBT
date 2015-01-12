<?php

use \PhpBT\TreeRoot;
use \PhpBT\RunStatus;
use \PhpBT\Action;
use \PhpBT\PrioritySelector;
use \PhpBT\Decorator;
use \PhpBT\Sequence;

require_once('../vendor/autoload.php');

//$container = require_once('services.php');

/** @var \PhpBT\TreeRoot $tr */
$tr = new TreeRoot();

/*
 * Simple examples of Behavior tree use.
 *
 * All inputs must be delegated or behavior
 * will return the same thing every time.
 */

//Example of a simple behavior
//Succeeds if rand is lower than $max
function randar($max) {
	return new Action(function() use ($max) {
		$r = rand(0, 100);

		if($r > $max) {
			echo "{$r}\t{$max}\tFailure\t\n";
			return RunStatus::FAILURE;
		}
		else {
			echo "{$r}\t{$max}\tSuccess\t\n";
			return RunStatus::SUCCESS;
		}
	});
}

//Behavior to test Decorator
function decRandar($max) {
	return new Action(function() use ($max) {
		$r = rand(0, 100);

		if($r > $max) {
			echo "{$r}\t{$max}\tFailure\tDecorator\n";
			return RunStatus::FAILURE;
		}
		else {
			echo "{$r}\t{$max}\tSuccess\tDecorator\n";
			return RunStatus::SUCCESS;
		}
	});
}

//Behavior will always succeed, to test Sequence
function AlwaysSucceed() {
	return new Action(function() {
		echo " \t \tSuccess\n";
		return RunStatus::SUCCESS;
	});
}

//Behavior will always fail, to test Sequence
function AlwaysFail() {
	return new Action(function() {
		echo " \t \tFailure\n";
		return RunStatus::FAILURE;
	});
}

//Returns Success if a Random below 10
$tr->AddHook('Simple Random Composite', randar(17));

//if the Decorator condition(a rand below 2) passes,
//Decorator will run Behavior
$tr->AddHook('Decorator Test',
	new Decorator(function() { return rand(0, 6) <= 2; },
		decRandar(50)));

//All behaviors in sequence must Succeed for Sequence to Succeed
//This one will fail
$tr->AddHook('Sequence Fail',
	new Sequence(
		AlwaysSucceed(),
		AlwaysSucceed(),
		AlwaysFail()
	));

//This one will Succeed
$tr->AddHook('Sequence Success',
	new Sequence(
		AlwaysSucceed(),
		AlwaysSucceed(),
		AlwaysSucceed()
	));

//These should be unreachable
$tr->AddHook('Rand 1', randar(27));
$tr->AddHook('Rand 2', randar(33));
$tr->AddHook('Rand 3', randar(41));

$tr->RebuildTree();
$tr->Start();

sleep(15);

$tr->Stop();
