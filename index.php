<!DOCTYPE html>
<?php
$name = 'World';

include "navigation.php";
?>

<h1>Conditions</h1>
<h2><?php print("Hello " . $name); ?></h2>


<?php
if ($name === "World") {
    print("<h3>This text is printed with print function</h3>");
}

if (0 == "0") {
    echo "'0' == 0";
}

if (0 === "0") {
    echo "'0' !== 0";
}

echo "<br>";
if (false) {
    echo "false";
} elseif (false > 5) {
    echo "false";
} elseif (true) {
    echo "true";
}

$a = 4;


switch ($a) {
    case 1:
        echo "One";
        break;
    case 2:
        echo "Two";
        break;
    case 3:
        echo "Three";
        break;
    case 4:
        echo "Four";
        break;
    default:
        # code...
        break;
}
echo "<hr>";
$b = [1, 2, 3, 4, 5, 6, 7];
foreach ($b as $value) {

    if ($value > 5 || $value < 3) {
        continue;
    }
    echo $value . "<br>";
}

?>