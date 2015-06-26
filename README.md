# PhpBT
A behavior tree implementation in PHP

#Example Usage

$tr = new TreeRoot();

function randar($max)
{
	return new Action(function ($max) use ($max) {
		$r = rand(0, 100);

		echo "{$r}\t{$max}\n";

		if ($r > $max) {
			return RunStatus::FAILURE;
		} else {
			return RunStatus::SUCCESS;
		}
	});
}


$p = new PrioritySelector(
	randar(10),
	randar(20),
	randar(60),
	randar(70)
);

$tr->AddHook('Random', $p);
$tr->RebuildTree();
$tr->Start();

sleep(15);
