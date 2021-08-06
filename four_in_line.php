<!DOCTYPE html>
<link rel="stylesheet" href="style.css">

<?php
include "navigation.php";
if (array_key_exists('reset', $_GET) && $_GET['reset'] == 'true') {
    resetGame();
    $moves = [];
} else {
    $moves = get();
}


if (array_key_exists('id', $_GET)) {
    if (checkGameRules($_GET['id'])) {
        $symbol = count($moves) % 2 == 0 ? 'x' : 'o';
        add($_GET['id'], $symbol);
    }
}
?>


<div class="game_board four-in-line">
    <?php

    for ($i = 1; $i <= 100; $i++) {
        $symbol = (array_key_exists($i, $moves)) ? $moves[$i] : '';
        echo "<a href='?id=$i'>$symbol</a>";
    }


    ?>

</div>

<a href="?reset=true" class="btn">Reset</a>



<?php
function add($id, $symbol)
{
    global $moves;
    if (!array_key_exists($id, $moves)) {
        $moves[$id] = $symbol;
        $json = json_encode($moves);
        file_put_contents('four_in_line.json', $json);
    }
}

function get()
{
    if (!file_exists('four_in_line.json')) {
        return [];
    }
    $content = file_get_contents('four_in_line.json');
    $data = json_decode($content, true);

    if (!is_array($data)) {
        $data = [];
    }
    return $data;
}

function resetGame()
{
    file_put_contents('four_in_line.json', '');
    header('Location: ?');
}

/*funkcija kura pārbauda vai pēdēja rinda ir pilna
lai turpinātos funkcija ar add() nepieciešama true vērtiba */
function checkGameRules($id)
{

    // paņemam visas vērtības no masīva
    $validateData = get();
    //taisam ciklu pēdējai rindai
    for ($i = 91; $i >= 100; $i++) {
        if ($id = $i) {
            return true;
        } else {
            return false;
        }
    }
}


?>