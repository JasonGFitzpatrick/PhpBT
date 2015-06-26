# PhpBT
A behavior tree implementation in PHP

#Example Usage

```
$tr = new TreeRoot();

function random($max)
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
	random(10),
	random(20),
	random(60),
	random(70)
);

$tr->AddHook('Random', $p);
$tr->RebuildTree();
$tr->Start();

sleep(15);
```
