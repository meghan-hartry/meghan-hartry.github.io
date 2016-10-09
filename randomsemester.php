<?php
$fruits = array('fall' => 45, 'spring' => 45, 'summer' => 10);
$rand = rand(1,100);
$sum = 0;
$chosenFruit;

foreach ($fruits as $f=>$v) {
    $sum += $v;
    if ( $sum >= $rand ) {
        $chosenFruit = $f;
        break;
    }
}

echo $chosenFruit . "<br>";
?>