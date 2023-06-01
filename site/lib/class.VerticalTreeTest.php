<?php

class BoxNode {
    public $label;
    public $childs;
    
    public function __construct($label) {
        $this->label = $label;
        $this->childs = array();
    }

    public static function create($label) {
        return new self($label);
    }

    public function haveChild() {
        return $this->childCount() > 0;
    }

    public function childCount() {
        return count($this->childs);
    }

    public function add($label) {
        $this->childs[] = self::create($label);
        return $this;
    }

    public function addNode(&$node) {
        $this->childs[] = $node;
        return $this;
    }
}

class Pen {
    public $stroke;
    public $pos;
    // private $state;
    private $transformer;
    private $rootElem;
    private $savedPoints;

    public function __construct($startPos, $stroke, &$transformer, &$rootElem) {
        $this->stroke = $stroke;
        $this->pos = $startPos->copy();
        // $this->up = true; 
        $this->transformer = $transformer;
        $this->rootElem = $rootElem;
        $this->savedPoints = array();
    }

    public static function create($startPos, $stroke, $transformer, &$rootElem) {
        return new self($startPos, $stroke, $transformer, $rootElem);
    }    

    // public function up(){
    //     $this->up = true;
    //     return $this;
    // }

    // public function down(){
    //     $this->up = false;
    //     return $this;
    // }

    public function strokeDelta($dx, $dy){
        // if (!$this->up) return $this;

        //default stroke
        return $this->strokeDeltaColor($dx, $dy, $this->stroke);

    }

    //custom color stroke
    public function strokeDeltaColor($dx, $dy, $color){
        // if (!$this->up) return $this;

        //pt1: pos

        //p2
        $p2 = $this->pos->add($dx, $dy);
      
        $ln = Element::create("line")
        ->attPointTransform("x1", "y1", $this->pos, $this->transformer)
        ->attPointTransform("x2", "y2", $p2, $this->transformer)
        ->att("stroke", $color);      

        $this->rootElem->child($ln);

        //set current
        $this->pos = $p2->copy();

        // $this->up = false;
        return $this;
    }
    
    public function moveTo($target){
        $this->pos = $target->copy();

        return $this;
    }    

    public function save($label) {
        $this->savedPoints[$label] = $this->pos->copy();
        return $this;
    }

    public function moveToLabel($label) {
        $this->moveTo($this->savedPoints[$label]);
    }    

    public function getPos() {
        return $this->pos->copy();
    }


}

class Box {
    public $pos;

    public function __construct($pos) {
        $this->pos = $pos;
        $this->level = 2;
        $this->totalChildPerLevel = 2;
        $this->boxHeight = 10;
        $this->boxWidth = 30;
        $this->boxBgColor = "lavender";
        $this->bgColor = "#DDDDDD";
    }
}

class VerticalTreeTest {
    public $level;
    public $totalChildPerLevel;
    public $pos;
    public $transformer;

    public function __construct($pos) {
        $this->pos = $pos;
        $this->level = 2;
        $this->totalChildPerLevel = 2;
        $this->boxHeight = 10;
        $this->boxWidth = 30;
        $this->boxBgColor = "lavender";
        $this->bgColor = "#DDDDDD";

        //calculated attribute
        $this->boxHalfHeight = Util::floorPercentage($this->boxHeight, 50); 
        $this->boxHalfWidth = Util::floorPercentage($this->boxWidth, 50); 

        //for box font
        $this->fontHeight = Util::floorPercentage($this->boxHeight, 70);

        //delta for box line
        $this->deltaDown = 2; 
        $this->deltaRight = 5;
    }

    //started at the side point
    public function drawChildNode(&$node, $pos, &$rootElem) {

        //move to top box
        $start = $pos->add(0, $this->boxHalfHeight);

        $this->drawBox($node->label, $start, $rootElem);

    }

    //draw box with text, started at top pos
    public function drawBox($label, $start, &$rootElem) {

        $box = Element::create("rect")
        // ->att("style", "border: 1px solid black")
        ->att("stroke", "black")
        ->att("fill", $this->bgColor)
        ->attPointTransform("x", "y", $start, $this->transformer)
        ->att("fill", $this->boxBgColor)
        ->att("width", $this->boxWidth)
        ->att("height", $this->boxHeight);

        $rootElem->child($box);

        //text
        $ptx = $start->add($this->boxHalfWidth, -$this->boxHalfHeight);
        // $ptxx = $canvas->processPoint($ptx);

        $tx = Element::create("text")
        // ->att("style", "border: 1px solid black")
        ->attPointTransform("x", "y", $ptx, $this->transformer)
        ->att("font-size", "{$this->fontHeight}px")
        ->att("text-anchor", "middle")
        // ->att("alignment-baseline", "central")
        ->att("dominant-baseline", "central")
        ->att("fill", "black")
        ->child($label);

        $rootElem->child($tx);

        // var_dump("drawbox {$label} finished");
    }

    //pos: kotak node, top left
    public function drawChilds(&$node, $pos, &$rootElem) {
        $startPos = $pos->add($this->boxHalfWidth, -$this->boxHeight);
        //create pen: default stroke black
        $pen = Pen::create($startPos, "black", $this->transformer, $rootElem);

        $col1 = "red";
        $col2 = "blue";
        $col3 = "green";

        $pal = Palette::create()->add("red")->add("orange")->add("yellow")->add("green")->add("blue")->add("indigo")->add("purple");


        // $idx = 0;
        // var_dump($node->childCount());

        //additional vertical connector, for first item it is 0
        $verticalConnector = 0;
        
        $total = 0;
        $totalThisNode = 0; //for early child, no prev sibling
        foreach ($node->childs as $child) {
            // $idx++
            $lineColor = $pal->next();

            // $totalBeforeNode = $total;
            $vertDist = ($this->boxHalfHeight + $this->deltaDown); //default kalau total = 0
            if ($totalThisNode > 0) {
                $vertDist = $totalThisNode * ($this->boxHeight + $this->deltaDown);
            }


            //stroke down
            //$pen->strokeDeltaColor(0, -($this->boxHalfHeight + $this->deltaDown + $verticalConnector), $lineColor);
            $pen->strokeDeltaColor(0, -$vertDist, $lineColor);
            $pen->save("p");

            //stroke right
            $pen->strokeDeltaColor($this->deltaRight, 0, $lineColor);
            
            $boxPos = $pen->getPos(); //get pos for box drawing
            $boxPos = $boxPos->add(0, $this->boxHalfHeight); //move to top, for drawing box

            // var_dump($child);
            // exit;

            echo("before-draw-node: node: {$child->label} total-before-this-node: $totalThisNode<br/>");
            
            $totalThisNode = $this->drawNode($child, $boxPos, $rootElem);    
  
            //move to last position
            $pen->moveToLabel("p");
            
            //set connector for next items (constant)
            // $verticalConnector = $this->boxHalfHeight;

            $total += $totalThisNode;

        }

        return $total;

    }

    //recursively: return num of node drawn: self + direct child
    public function drawNode(&$node, $pos, &$rootElem) {
 
        $this->drawBox($node->label, $pos, $rootElem);
 
        //draw childs

        $totalChild = $this->drawChilds($node, $pos, $rootElem);

        //total nodes drawn
        // echo("after-draw-childs: node: {$node->label} total-child: $totalChild<br/>");
        return 1 + $totalChild;       
    }
  
    
    //will be called by canvas, canvas will inject itself
    public function render(&$canvas) {
        $this->transformer = $canvas->transformer;

        //config 1
        // $t11 = BoxNode::create("1.1")->add("1.1.1")->add("1.1.2");

        // $t13 = BoxNode::create("1.3")->add("1.3.1");

        // $rootBox = BoxNode::create("1")->addNode($t11)->add("1.2")->addNode($t13)->add("1.4")->add("1.5");

        //config 2, more complex
        // $t11 = BoxNode::create("1.1")->add("1.1.1")->add("1.1.2")->add("1.1.3");

        // $t13 = BoxNode::create("1.3")->add("1.3.1")->add("1.3.2");

        // $t14 = BoxNode::create("1.4")->add("1.4.1");

        // $rootBox = BoxNode::create("1")->addNode($t11)->add("1.2")->addNode($t13)->addNode($t14)->add("1.5");

        //config 3, full 3 level
        $t11 = BoxNode::create("1.1")->add("1.1.1")->add("1.1.2")->add("1.1.3");

        $t12 = BoxNode::create("1.2")->add("1.2.1")->add("1.2.2")->add("1.2.3");

        $t13 = BoxNode::create("1.3")->add("1.3.1")->add("1.3.2")->add("1.3.3");

        $rootBox = BoxNode::create("1")->addNode($t11)->addNode($t12)->addNode($t13);
        
        // var_dump($rootBox);

        $width = 150;
        $height = 150;

        $deltaDown = 20;
        $deltaRight = 30;

        $grp = Element::create("g");

        //outer element (bg box)
        $root = Element::create("rect")
        // ->att("style", "border: 1px solid black")
        ->att("stroke", "black")
        ->att("fill", $this->bgColor)
        ->attPointTransform("x", "y", $this->pos, $this->transformer)
        ->att("width", $width)
        ->att("height", $height);

        $grp->child($root);

        //start point
        // var_dump($this->pos);
        $start = $this->pos->add(10, -10);
        // var_dump($start);

        $this->drawNode($rootBox, $start, $grp);

        return $grp;
    }

}


?>