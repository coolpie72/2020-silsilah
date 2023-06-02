<?php
    require_once "lib/class.SVGCanvas.php";
    require_once "lib/class.VerticalTreeTest.php";

    $col1 = "red";
    $col2 = "orange";
    $col3 = "yellow";
    $col4 = "green";
    $col5 = "blue";
    $col6 = "indigo";
    $col7 = "purple";

    $COORD_WIDTH = 100;
    $CANVAS_WIDTH = 600; //in pixel
    $PAD = 10;

    $canvas = new SVGCanvas();


    $canvas->configureMode1($CANVAS_WIDTH, $COORD_WIDTH, $PAD);
    $canvas->init();

    $p0 = Point2i::create(0, 0);
    $p1 = Point2i::create(-$COORD_WIDTH, -$COORD_WIDTH);
    $p2 = Point2i::create($COORD_WIDTH, $COORD_WIDTH);

    $p3 = Point2i::create(-$COORD_WIDTH, $COORD_WIDTH);
    $p4 = Point2i::create($COORD_WIDTH, -$COORD_WIDTH);

    $canvas->line(Point2i::create(-$COORD_WIDTH, 0), Point2i::create($COORD_WIDTH, 0), "red");
    $canvas->line(Point2i::create(0, -$COORD_WIDTH), Point2i::create(0, $COORD_WIDTH), "green");
    // $canvas->line($p0, $p2, "green");

    // $canvas->circle($p0, 10, $col1, "none");
    // $canvas->circle($p1, 10, $col2, "none");
    // $canvas->circle($p2, 10, $col3, "none");
    // $canvas->circle($p3, 10, $col4, "none");
    // $canvas->circle($p4, 10, $col5, "none");

    // $canvas->circleWithEvent($p0, 20, $col1, "black", "alert('p0')");
    // $canvas->circleWithEvent($p1, 20, $col2, "black", "say('p1')");
    // $canvas->circleWithEvent($p2, 20, $col3, "black", "say('p2')");
    // $canvas->circleWithEvent($p3, 20, $col4, "black", "say('p3')");
    // $canvas->circleWithEvent($p4, 20, $col5, "black", "say('p4')");

    //$canvas->drawGraph(100);

    // $canvas->text($p0->str(), $p0, "black");
    // $canvas->text($p1->str(), $p1, "black");
    // $canvas->text($p2->str(), $p2, "black");
    // $canvas->text($p3->str(), $p3, "black");
    // $canvas->text($p4->str(), $p4, "black");

    // $canvas->addObject(PersonCircle::create($p0, 20, "obj1", $col1, "white"));

    // $canvas->addObject(PersonCircle::create(Point2i::create(40, 40), 20, "obj2", $col1, "white"));

    // $center, $radius, $text, $border, $fill) {


    $test = new VerticalTreeTest(Point2i::create(-$COORD_WIDTH + 10, $COORD_WIDTH - 10));
    // $test->transformer = $canvas->transformer;

    $canvas->addObject($test);    


    echo $canvas->draw();
?>
