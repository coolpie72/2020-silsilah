<?php

require_once "class.Element.php";
require_once "class.Point2i.php";
require_once "class.Palette.php";
require_once "class.PersonCircle.php";

class SVGCanvas {
    public $width;
    public $height;
    public $minX;
    public $maxX;
    public $minY;
    public $maxY;
    public $transformer;

    private $objects;

    private $root;

    function __construct() {

    }

    function add($obj) {
        $this->canvasRoot->child($obj);
    }

    public function line($p1, $p2, $color) {
        $p1x = $this->processPoint($p1);
        $p2x = $this->processPoint($p2);

        $elm = Element::create("line")
            ->att("x1", $p1x->x)
            ->att("y1", $p1x->y)
            ->att("x2", $p2x->x)
            ->att("y2", $p2x->y)
            ->att("stroke", $color);

        $this->add($elm);
    }

    public function addObject($obj) {
        $elm = $obj->render($this);
        $this->add($elm);
    }

    public function circle($center, $rad, $stroke, $fill) {
        $centerx = $this->processPoint($center);
        $elm = Element::create("circle")
            ->att("cx", $centerx->x)
            ->att("cy", $centerx->y)
            ->att("r", $rad)
            ->att("stroke", $stroke)
            ->att("fill", $fill);

        $this->add($elm);
    }

    public function addPersonCircle($pc) {


    }    
    
    public function circleWithEvent($center, $rad, $stroke, $fill, $onclick) {
        $centerx = $this->processPoint($center);
        $elm = Element::create("circle")
            ->att("cx", $centerx->x)
            ->att("cy", $centerx->y)
            ->att("r", $rad)
            ->att("stroke", $stroke)
            ->att("onclick", $onclick)
            ->att("fill", $fill);
        $this->add($elm);
    }

    public function getViewBoxAttRender() {
        return "{$this->minX} {$this->minY} {$this->getWidth()} {$this->getHeight()}";
    }

    public function getWidth() {
        return $this->maxX - $this->minX;
    }    

    public function getHeight() {
        return $this->maxY - $this->minY;
    }        

    public function init() {
        $this->root = Element::create("svg")
        ->att("style", "border: 1px solid black")
        ->att("width", "{$this->width}px")
        ->att("height", "{$this->height}px")
        ->att("viewBox", $this->getViewBoxAttRender())
        ->att("preserveAspectRatio", "none");


        // $transform = Element::create("g")
        // ->att("transform","scale(1,-1)");

        // $this->root->child($transform);

        // $this->canvasRoot = $transform;

        $script = Element::create("script")->child("
        function say(val){
            console.log(val);
            alert(val);
        }
        ");

        $this->root->child($script);


        $this->canvasRoot = $this->root;



    }

    public function draw() {

        // $str = "
        //     <svg 
        //     style=\"border: 1px solid black\" 
        //     width=\"{$this->width}px\" 
        //     height=\"{$this->height}px\"
        //     {$this->getViewBoxAttRender()}
        //     preserveAspectRatio=\"none\"
        //     >
        //     {$this->getContents()}   
        //     </svg>
        // ";


        return $this->root->get();
    }

    public function getContents() {
        $str = "";
        foreach ($this->objects as $elm) {
            $str .= $elm . "\n";
        }
        return $str;
    }

    public function processPoint($p) {
        //inverse the y
        return Point2i::create($p->x, -$p->y);
    }    

    public function text($text, $pos, $color) {
        $p = $this->processPoint($pos);
        $elm = Element::create("text")
        ->att("x", $p->x)
        ->att("y", $p->y)
        ->att("fill", $color)
        // ->att("transform", "scale(1,-1)")
        ->child($text);

        $this->add($elm);       
    }

    //mode1: bujursangkar, equal aspect ratio
    public function configureMode1($canvasWidth, $coordWidth, $pad) {
        $this->width = $canvasWidth;
        $this->height = $canvasWidth;
    
        $effCoordWidth = $coordWidth + $pad;

        $this->minX = -$effCoordWidth;
        $this->maxX = $effCoordWidth;
        $this->minY = -$effCoordWidth;
        $this->maxY = $effCoordWidth;

        $this->transformer = new class {
            public function transform($p) {
                return Point2i::create($p->x, -$p->y);
            }
        };
    
    }

    public function drawGraph($segments) {
        //$p1 = Point2i::create($this->minX, 0);
        $step = $this->getWidth() / $segments;

        $x = $this->minX;
        $y = $this->f($x);

        $pt1 = Point2i::create($x, $y);

        $pt2 = Point2i::create(0, 0);
        while ($pt1->x <= $this->maxX) {
            $x2 = $pt1->x + $step;
            $y2 = $this->f($x2);

            $pt2 = Point2i::create($x2, $y2);

            $this->line($pt1, $pt2, "black");
            
            $pt1 = $pt2;
        }

    }

    public static function f($x) {
        //return $x;
        return 30 * sin(50 * $x);
    }

}
?>

