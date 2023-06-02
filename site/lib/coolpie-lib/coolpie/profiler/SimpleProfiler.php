<?php
namespace coolpie\profiler;

class SimpleProfiler {
    public function __construct() {
    }

    public function start() {
        $this->start = time();
    }

    public function get() {
        $end = time();

        $diff = $end - $this->start;

        return $diff;
    }

}

?>