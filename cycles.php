<?php

include "navigation.php";

define('MAX', 6);
define('MIN', 1);

$max = 6;
$min = 1;


for ($i = MIN; $i < MAX; $i++) {
    echo "<h" . $i . ">" . $i . "</h" . $i . ">";
}

while ($i > MIN) {
    $i--;
    echo "<h" . $i . ">" . $i . "</h" . $i . ">";
}


$cars = ['Volvo', 'BMW', 'Mercedes', 'Tesla'];

foreach ($cars as $car) {
    echo $car;
}


$cities = [
    'riga' => 'Rīga',
    'tallin' => 'Tallin',
    'Vilnus' => 'Vilnus',
    'Jūrmala'
];


echo "<pre>";
foreach ($cities as $key => $city) {
    echo "$key => <strong>$city</strong>" . PHP_EOL;
}
echo "</pre>";

function al(int $number)
{
    echo $number;

    if ($number > 1) {
        al(--$number);
    }
}


al(20);
$b2 = 2;

echo "<pre>";
function func1($b1)
{
    global $b2;
    echo $b1 * $b2;
}

func1(2);
echo "</pre>";
