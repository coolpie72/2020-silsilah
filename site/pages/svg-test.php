<?php




?>
<svg width="100" height="100" style="border: 1px solid black">
  <circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" />
</svg>

<svg style="border: 1px solid black" viewBox="0 0 500 100" xmlns="http://www.w3.org/2000/svg" stroke="red" fill="grey">
  <circle cx="50" cy="50" r="40" />
  <circle cx="150" cy="50" r="4" />

  <svg viewBox="0 0 10 10" x="200" width="100">
    <circle cx="5" cy="5" r="4" />
  </svg>
</svg>


<svg style="border: 1px solid black" width="300px" height="200px"
viewBox="0 0 1500 1000" preserveAspectRatio="none"
xmlns="http://www.w3.org/2000/svg">
<desc>Example ViewBox - uses the viewBox
attribute to automatically create an initial user coordinate
system which causes the graphic to scale to fit into the
viewport no matter what size the viewport is.</desc>

<!-- This rectangle goes from (0,0) to (1500,1000) in user space.
Because of the viewBox attribute above,
the rectangle will end up filling the entire area
reserved for the SVG content. -->
<rect x="0" y="0" width="1500" height="1000" fill="yellow" stroke="blue" stroke-width="12" />

<!-- A large, red triangle -->
<path fill="red" d="M 750,100 L 250,900 L 1250,900 z"/>
<!-- A text string that spans most of the viewport -->

<text x="100" y="600" font-size="200" font-family="Verdana" >
Stretch to fit
</text>

</svg>