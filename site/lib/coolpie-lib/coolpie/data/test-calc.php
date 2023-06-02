<?php

require_once "CalcLib.php";

$pct = CalcLib::percent(26, 85, true); echo $pct . PHP_EOL;
assert($pct == 30.59);

$pct = CalcLib::percent(59, 85, true); echo $pct . PHP_EOL;
assert($pct == 69.41);

$pct = CalcLib::percent(1, 3, true); echo $pct . PHP_EOL;
assert($pct == 33.33);

$pct = CalcLib::percent(1, 2, true); echo $pct . PHP_EOL;
assert($pct == 50);

$pct = CalcLib::percent(2, 9, true); echo $pct . PHP_EOL;
assert($pct == 22.22);

?>