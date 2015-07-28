<?php
echo "Min value is: " . $min;
echo "<br/>";
echo "Max value is: " . $max;
echo "<br/>";
echo "Total possible unique values: " . $total_unique;
echo "<br/>";
echo "Using locations: ";
foreach ($locations as $location) {
    echo $location . ", ";
}

echo "<hr/>";
foreach ($codes as $code){
    echo $code . '<br/>';
}