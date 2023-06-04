<?php 

//register class-loader utk rootdir dan prefix yg diberikan
function coolpie_register_loader($rootDir, $prefix) {

    $func = function ($clsname) use ($rootDir, $prefix) {
        // echo "api-tool-loader [$clsname]\n";
        //folder package mana saja yang dikenali
        // $prefix = "silsilahApp";
        
        //experimental folder relative to this dir
        // $folder = implode(DIRECTORY_SEPARATOR, [__DIR__, "root"]);
        $folder = $rootDir;

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

        $classFileLocation = implode(DIRECTORY_SEPARATOR, $clsnameParts);
        // echo "class-file-loc: [$classFileLocation]" . PHP_EOL;                

        if (file_exists($classFileLocation)) {
            // echo "resolve: [$clsname][$path]" . PHP_EOL;
            require_once $classFileLocation;
        }		


    };

    spl_autoload_register($func);    
}

?>