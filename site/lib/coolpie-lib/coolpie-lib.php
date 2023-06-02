<?php 
/*
 * Ini adalah file "bootstrap" coolpie lib dan cnf lib classes
 * yang ada di sub folder "coolpie" dan "cnf"
 * 
 * Untuk memakai class-class tsb pastikan pernah load file ini sekali di awal.
 * Autoloader akan diregister untuk class-class "coolpie" dan "cnf".
 * 
 * Selanjutnya class-class bisa dipakai dengan menggunanakan mekanisme use
 * contoh:
 * use coolpie\str\StringUtil;
 * use cnf\dummy\DummyUtil;
 * 
 * 
 */


define("COOLPIE_REPO_PATH", __DIR__);

// function coolpieRequire($file) {
//     $args = explode(".", $file);
//     $lastIdx = count($args) - 1;
//     $args[$lastIdx] = $args[$lastIdx] . ".php";
//     require_once implode(DIRECTORY_SEPARATOR, $args);
// }

function __coolpieLoader($clsname) {
// 	echo "coolpie-loader [$clsname]\n";
	$clsnameParts = explode("\\", $clsname);
	if (count($clsnameParts) > 1 && ($clsnameParts[0] == "coolpie" || $clsnameParts[0] == "cnf")) {
// 		$res = "";
		$loc = [COOLPIE_REPO_PATH];
		while (count($clsnameParts) > 1) {
			$part = array_shift($clsnameParts);
			$loc[] = $part;
		}
		
		//untuk last part kita tambahkan ekstensi .php
		$loc[] = $clsnameParts[0] . ".php";
		$classFileLocation = implode(DIRECTORY_SEPARATOR, $loc);
		if (file_exists($classFileLocation)) {
// 			echo "resolve: [$clsname][$classFileLocation]" . PHP_EOL;
			require_once($classFileLocation);
		}		
	}
	
}

spl_autoload_register("__coolpieLoader");


?>