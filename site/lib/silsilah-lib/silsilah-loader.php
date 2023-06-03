<?php 

//coolpie experimental lib loader
function __silsilah_loader($clsname) {
    // echo "api-tool-loader [$clsname]\n";
	//folder package mana saja yang dikenali
    $prefix = "silsilahApp";
	
	//experimental folder relative to this dir
    $folder = implode(DIRECTORY_SEPARATOR, [__DIR__, "root"]);

    //valid class to load

    if (strpos($clsname, "$prefix\\") === false) {
        return;
    }

    $clsnameParts = explode("\\", $clsname);
    if ($clsnameParts[0] !== $prefix) {
        return;
    }

    $len = count($clsnameParts);

    $clsnameParts[0] = $folder;

    $clsnameParts[$len - 1] = $clsnameParts[$len - 1] . ".php";

    // echo "cls-name-parts: " . implode(":", $clsnameParts) . PHP_EOL; 
    // $lastPart = array_pop($clsnameParts);
    // $loc = $lastPart . ".php";
    // if ($clsnameParts[0] === $prefix) {
    //     array_shift($clsnameParts);
    // }
    // $arr = [$folder];
    // foreach ($clsnameParts as $str) {
    //     $arr[] = $str;
    // }
    // $arr[] = $loc;
    $classFileLocation = implode(DIRECTORY_SEPARATOR, $clsnameParts);
    // echo "class-file-loc: [$classFileLocation]" . PHP_EOL;                
    if (file_exists($classFileLocation)) {
// 			echo "resolve: [$clsname][$path]" . PHP_EOL;
        require_once($classFileLocation);
    }		



}

spl_autoload_register("__silsilah_loader");

?>