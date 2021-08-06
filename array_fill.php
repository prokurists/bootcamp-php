<?php
include "navigation.php";

$table = template();
showTable($table, 0);

/*
    Piemērs #1
        [x, x, x],
        [x, x, x],
        [x, x, x]
    */

$table = template();

for ($r = 0; $r <= 2; $r++) {
    for ($c = 0; $c <= 2; $c++) {
        $table[$r][$c] = 'x';
    }
}

showTable($table, 1);



/*
    Piemērs #2
        [x, 0, x],
        [x, 0, x],
        [x, 0, x]
    */

$table = template();

for ($r = 0; $r <= 2; $r++) {
    for ($c = 0; $c <= 2; $c += 2) {
        $table[$r][$c] = 'x';
    }
}
showTable($table, 2);




/*
    Piemērs #3
        [x, x, x],
        [x, x, x],
        [0, 0, 0]
    */

$table = template();

for ($r = 0; $r <= 1; $r++) {
    for ($c = 0; $c <= 2; $c++) {
        $table[$r][$c] = 'x';
    }
}
showTable($table, 3);



/*
    Piemērs #4
        [x, 0, 0],
        [0, x, 0],
        [0, 0, x]
    */

$table = template();

for ($r = 0; $r <= 2; $r++) {
    $table[$r][$r] = 'x';
}

showTable($table, 4);
/*
    Piemērs #5
        [0, 0, x],
        [0, 0, x],
        [x, x, x]
    */

$table = template();

for ($r = 2; $r >= 0; $r = -2) {
    for ($c = 0; $c <= 2; $c++) {
        $table[$r][$c] = 'x';
        $table[$c][$r] = 'x';
    }
}
showTable($table, 5);
/*
    Piemērs #6
        [6, 0, 5],
        [4, 0, 3],
        [2, 0, 1]
    */
$table = template();
$d = 6;

for ($r = 0; $r <= 2; $r++) {
    for ($c = 0; $c <= 2; $c += 2) {

        do {
            $table[$r][$c] = $d;
            $d--;
        } while ($d > 6);
    }
}

showTable($table, 6);
/*
    Piemērs #7
        [8, 0, 5],
        [3, 0, 2],
        [1, 0, 1]
    */

$table = template();


$rez = 0;
$g = 1;
$n = 0;
for ($r = 2; $r >= 0; $r--) {
    for ($c = 2; $c >= 0; $c -= 2) {

        $rez = $g + $n;
        $g = $n;
        $n = $rez;
        $table[$r][$c] = $rez;
    }
}


showTable($table, 7);
/*
    Piemērs #8
        [5, -1, 1],
        [-8, 2, 0],
        [13, -3, 1]
    */
$table = template();

$rez = 0;
$g = 2;
$n = 1;
for ($c = 2; $c >= 0; $c--) {

    for ($r = 0; $r <= 2; $r++) {

        $rez = $g - $n;

        $table[$r][$c] = $rez;
        $g = $n;
        $n = $rez;
    }
}
showTable($table, 8);


function template()
{
    return [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0]
    ];
}

function showTable($table, $example_number)
{
    echo "<h3>Example #$example_number</h3><pre>";
    foreach ($table as $row) {
        echo "<br>";
        foreach ($row as $value) {
            echo $value . "   |   ";
        }
    }
    echo "</pre><br><br>";
}
