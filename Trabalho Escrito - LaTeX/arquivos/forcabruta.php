<?php

function geraCor($n, $k, $ac)
{
    $j = 0;
    for ($i = $n - 1; $i >= 0; $i--) {
        if ($ac[$i] < $k - 1 && $j == 0 && $i > 0) {
            $cor[$i] = $ac[$i] + 1;
            $j = 1;
        } else {
            if ($j == 1) {
                $cor[$i] = $ac[$i];
            } else {
                $cor[$i] = 0;
                $j = 0;
            }
        }
    }
    
    if ($j == 1) {
        $GLOBALS['testable']++;
        return $cor;
    } else {
        $GLOBALS['testable'] = -1;
        return -1;
    }
}


function verificaCor($cor, $G, $n)
{
    $soma = 0;
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($cor[$i] == $cor[$j]) {
                $soma += $G[$i][$j];
            }
        }
    }
    return $soma;
}

function colorir($G, $n, $k)
{

    $a_value = -1;
    list($usec, $sec) = explode(' ', microtime());
    $script_start = (float) $sec + (float) $usec;
    $solmin = 65000000;
    $c = 0;
    for ($j = 0; $j < $n; $j++) {
        if (($n - 1) - $j - $k < 0) {
            $cores[$j] = $c++;
        } else {
            $cores[$j] = 0;
        }
    }
    //print_r($cores);

    do {
        // $value = ceil($GLOBALS['testable'] * 100 / (($k ** ($n - 1)) / 2));
        $min = verificaCor(
            $cores,
            $G,
            $n
        );
        
        if ($solmin == 65000000) {
            $solmin = $min;
            for ($i = 0; $i < $n; $i++) {
                $corMin[$i] = $cores[$i];
            }
        } else {
            if ($min < $solmin) {
                $solmin = $min;
                for ($i = 0; $i < $n; $i++) {
                    $corMin[$i] = $cores[$i];
                }
            }
        }
        // $tempo = $GLOBALS['testable'];
        if ($solmin == 0) {

            $GLOBALS['testable'] = -1;
            break;
        }
        $cor = geraCor($n, $k, $cores);
        if ($cor == -1) {
            break;
        } else {
            $cores = $cor;
        }
        list($usec, $sec) = explode(' ', microtime());
        $script_end = (float) $sec + (float) $usec;
        $elapsed_time = round($script_end - $script_start, 5);

        if ($elapsed_time >= $GLOBALS['max_time']) {
            break;
        }
    } while ($cor != -1 && $solmin > 0);

    // echo (($tempo + 1) * 100 / ($k ** ($n - 1)));
    $corMin[$n] = $solmin;
    return $corMin;
}
