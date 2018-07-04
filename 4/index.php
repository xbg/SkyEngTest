<?php
require_once 'sumLargeNumbers.php';

function randomLargeIntAsString(int $length): string
{
    $result = '';

    while (strlen($result) < $length) {
        $result .= random_int(0, PHP_INT_MAX);
    }

    return substr($result, 0, $length);
}


$num1 = randomLargeIntAsString(600);
$num2 = randomLargeIntAsString(600);

echo 'num1: ' . $num1 . PHP_EOL;
echo 'num2: ' . $num2 . PHP_EOL;
echo 'result: ' . sumLargePositiveDecimalNumber($num1, $num2) . PHP_EOL;
