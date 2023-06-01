<?php 

require_once "lib/game/class.Dice.php";

// $d = Dice::create(1, 6);
// for($i = 1; $i <= 10; $i++) {
//     $val = $d->roll();
//     echo "try #$i - $val<br/>";
// }

$d = Dice::create(1, 6);
for($i = 1; $i <= 10; $i++) {
    $val = $d->rollWithCritical(30);
    $crit = $val[1] ? "crit": "";
    echo "try #$i - $val[0] - $crit<br/>";
}


?>


Hello world