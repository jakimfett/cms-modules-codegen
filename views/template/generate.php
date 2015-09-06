<?php
echo "Min value is: " . $min;
echo "<br/>";
echo "Max value is: " . $max;
echo "<br/>";
echo "Total possible unique values: " . $total_unique;

echo "<hr/>";
foreach ($codes as $code) {
    echo $code . '<br/>';
}