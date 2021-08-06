<!DOCTYPE html>
<?php
include "navigation.php";



?>
<h2>Time form</h2>
<form action="">
    <input type="hidden" name="form_name" value="time">
    <input type="text" name="text">
    <input type="text" name="timestamp" value="<?= time() ?>">
    <button type="submit">Submit</button>
</form>
<h2>Calculator</h2>

<form action="">
    <input type="hidden">
    <input type="number" name="number1">
    <input type="number" name="number2">
    <button type="submit" name="form_name" value="calculator">Submit</button>
    <button type="reset">Reset</button>
</form>


<pre>

    <?php
    if (array_key_exists('form_name', $_GET)) {
        if (
            $_GET['form_name'] == 'calculator' &&
            array_key_exists('number1', $_GET) &&
            array_key_exists('number2', $_GET) &&
            is_numeric($_GET['number1']) &&
            is_numeric($_GET['number2'])
        ) {
            $sum = $_GET["number1"] + $_GET["number2"];
            echo "<strong>SUM: </strong> $sum";
        }
        if ($_GET['form_name'] == 'time') {
            echo print_r($_GET, true);
        }
    }
    ?>

</pre>

<a href="?number1=2&number2=2&form_name=calculator">2+2</a>
<a href="?message=Hello+World">Hello World!</a>

<?php
if (array_key_exists('message', $_GET)) {
    echo $_GET['message'];
}
?>


<h2>List</h2>
<?php
$cars = ['BMW', 'Volvo', 'Volkswagen', 'Audi'];
?>
<form action="" method="POST">
    <select name="cars" id="">
        <?php foreach ($cars as $car) : ?>
            <option value="<?= $car; ?>"> <?= $car; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Submit</button>
</form>

<?php
if (array_key_exists('cars', $_POST)) {
    echo $_POST['cars'];
    echo print_r($_REQUEST, true);
}


?>