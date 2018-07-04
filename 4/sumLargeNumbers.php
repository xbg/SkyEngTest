<?php

/**
 * @param string $num1
 * @param string $num2
 * @return string result
 */
function sumLargePositiveDecimalNumber(string $num1, string $num2): string
{
    if (!ctype_digit($num1) || !ctype_digit($num2)) {
        throw new \RuntimeException(sprintf('Function %s is only for positive decimal integers', __FUNCTION__));
    }

    $result    = '';
    $remainder = '';

    //we have max '9' character in left decimal place => two decimal place as reserve strlen( (9+9+9) )
    $portionSize = strlen(PHP_INT_MAX) - 2;

    $i = 1;
    do {
        $curSubstringStartPos = (-1) * $portionSize * $i;

        $n1RemainSubstringLength = min(max(strlen($num1) - $portionSize * ($i - 1), 0), $portionSize);
        $n2RemainSubstringLength = min(max(strlen($num2) - $portionSize * ($i - 1), 0), $portionSize);

        $n1 = substr($num1, $curSubstringStartPos, $n1RemainSubstringLength) ?: null;
        $n2 = substr($num2, $curSubstringStartPos, $n2RemainSubstringLength) ?: null;

        $localSum  = (int)$n1 + (int)$n2 + (int)$remainder;
        $remainder = substr((string)$localSum, 0, (-1) * $portionSize) ?: 0;
        $result    = substr((string)$localSum, (-1) * $portionSize) . $result;

        $i++;
    } while ($n1 !== null || $n2 !== null);


    return ltrim($remainder . $result, '0');
}

