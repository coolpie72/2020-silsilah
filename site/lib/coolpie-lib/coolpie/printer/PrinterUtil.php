<?php
namespace coolpie\printer;

class PrinterUtil {

    public static function getEchoLinePrinter() {
        $printer = function ($line) {
            echo $line . PHP_EOL;
        };
        return $printer;
    }

}