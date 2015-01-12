<?php

namespace PhpBT;

abstract class RunStatus{
	const INVALID = -1;
	const RUNNING = 0;
	const SUCCESS = 1;
	const FAILURE = 2;
}