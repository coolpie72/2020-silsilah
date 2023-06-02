<?php 

//coolpie experimental lib loader
function __silsilah_loader($clsname) {
    // echo "api-tool-loader [$clsname]\n";
	//folder package mana saja yang dikenali
	$prefix = 'silsilahApp\\';
	
	//experimental folder relative to this dir
    $folder = implode(DIRECTORY_SEPARATOR, [__DIR__, "root"]);

    //valid class to load
    if (strpos($clsname, $prefix) !== false) {
        // echo "within-prefix: [$clsname]" . PHP_EOL;
        $clsnameParts = explode("\\", $clsname);
        $lastPart = array_pop($clsnameParts);
        $loc = $lastPart . ".php";
		$classFileLocation = implode(DIRECTORY_SEPARATOR, [$folder, $loc]);
        // echo "class-file-loc: [$classFileLocation]" . PHP_EOL;                
		if (file_exists($classFileLocation)) {
// 			echo "resolve: [$clsname][$path]" . PHP_EOL;
			require_once($classFileLocation);
		}		

    }

}

spl_autoload_register("__silsilah_loader");

?>