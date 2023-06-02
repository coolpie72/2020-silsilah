<?php
class PersonCircle {
    public $text;
    public $radius;
    public $center;
    public $border;
    public $fill;

    public function __construct() {

    }

    public static function create($center, $radius, $text, $border, $fill) {
        $obj = new self();
        $obj->center = $center;
        $obj->radius = $radius;
        $obj->text = $text;
        $obj->border = $border;
        $obj->fill = $fill;

        return $obj;
    }

    public function render(&$canvas) {
        $cx = $canvas->processPoint($this->center);

        $elm = Element::create("circle")
        ->att("cx", $cx->x)
        ->att("cy", $cx->y)
        ->att("r", $this->radius)
        ->att("stroke", $this->border)
        ->att("fill", $this->fill);

         //text element
        $fontScale = 60;
        $fontSize = floor($this->radius * $fontScale / 100);
        $tx = Element::create("text")
        // ->att("style","text-transform: uppercase;")
        ->att("class","sv-text")
        ->att("x", $cx->x)
        ->att("y", $cx->y)
        ->att("text-anchor", "middle")
        // ->att("alignment-baseline", "central")
        ->att("dominant-baseline", "central")
        ->att("font-size", "{$fontSize}px")
        ->att("fill", "black")
        // ->child(strtoupper($this->text));
        ->child($this->text);

        $grp = Element::create("g")
        ->att("onclick","alert('$this->text')")
        ->child($elm)
        ->child($tx);


        return $grp;

    }

}

?>