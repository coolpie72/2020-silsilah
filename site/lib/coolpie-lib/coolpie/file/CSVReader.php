<?php
namespace coolpie\file;

class CSVReader {

    public function __construct($file, $handler) {
        $this->file = $file;
        $this->handler = $handler;
    }

    public function process() {
        $reader = new FileLineReader();  
        $reader->openFile($this->file);

        while($reader->readLine()) {
            $line = $reader->getCurrentLine();
            $this->processLine($line);
        }

        $reader->close();        
    }

    function processLine($line) {
        // echo $line;


        // S     0  4679     1  0  80   0 19116 231307 ep_pol ?       00:00:02 php-fpm
        // S    48 15052  4679  0  80   0 30348 233504 flock_ ?       00:00:00 php-fpm

        $arr = explode(",", $line);

        $this->handler->processCsvRow($arr);

    }

}
?>