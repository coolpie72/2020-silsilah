<?php 
require_once("coolpie-lib.php");

use coolpie\str\StringUtil;


echo (StringUtil::contains("foo bar", "foo") ? "OK" : "NOT OK") . PHP_EOL;

?>

