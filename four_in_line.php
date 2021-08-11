<!doctype html>
<link rel="stylesheet" href="style.css">
<?php

/*
    1) ✅Ievietot X pie kliekšķa
    2) ✅Saglabāt visus gājienus failā
    3) ✅Attēlot visus gājienus gājienu laukumā
    4) ✅Noteikt pareizo gājienu ‘x’ vai ‘o’ un saglabāt un izvadīt pareizo gājiena simbolu.
    5) ✅Uzstaisīt validāciju lai nevar nomainīt simbolu, piemēram, ‘x’ uz ‘o’ pie atkārtota klikšķa uz to pašu rūtiņu
    6) ✅Uzstaisīt validāciju lai nevar ielikt symbolu neatļautā laukumā.
    7) Reset poga ar reset funkcionalitāti

    $new_id = $_GET['id'] + 10;
    if (array_key_exists($new_id, $moves)) {
        //tad varam

    }
*/
    include "navigation.php";

    if (array_key_exists('reset', $_GET) &&  $_GET['reset'] == 'true') {
        resetGame();
        $moves = [];
    }
    else {
        $moves = get();
    }

    if (array_key_exists('id', $_GET)) {
        $symbol = count($moves) % 2 == 0 ? 'x' : 'o';
        $id = $_GET['id'];

        if (
            !array_key_exists($id, $moves) &&
            ($id > 89 || array_key_exists($id + 10, $moves))
        ) {
            add($id, $symbol);
            if (checkWinner($id, $moves)) {
                echo "<h2>Winner is '$symbol'!</h2>";
            }
        }
    }
?>


<div class="game_board four-in-line">
    <?php
    for($i = 0; $i <= 99; $i++) {
        echo "<a href='?id=$i'>" . @$moves[$i] . "</a> ";
        //echo "<a href='?id=$i'>" . $i . "</a> ";
    }
    ?>
</div>
<a href="?reset=true" class="btn">Reset</a>


<?php
function add($id, $symbol) {
    global $moves;
        /* Pievieno simbolu masīvā $moves un failā four_data.json */
        $moves[$id] = $symbol;
        $json = json_encode($moves, JSON_PRETTY_PRINT);
        file_put_contents('four_data.json', $json);
}

function get() {
    if (!file_exists('four_data.json')) {
        return [];
    }

    $content = file_get_contents('four_data.json');
    $data = json_decode($content, true);
    if (!is_array($data)) {
        $data = [];
    }

    return $data;
}

function resetGame() {
    file_put_contents('four_data.json', '{}');

    header('Location: ?');
}

function countMatches($id, $moves, $step, $v_direction = 0) {
    $symbol = $moves[$id];
    $col = getCol($id);
    $row = getRow($id);

    $item_id = $id;
    $count = 0;

    for ($i = 0; $i <= 2; $i++) {
        $item_id = $item_id + $step;
        if (
            $symbol == @$moves[$item_id] &&
            ($v_direction === false ||
            getRow($item_id - $step) + $v_direction == getRow($item_id))
        ) {
            $count++;
        }
        else {
            break;
        }
    }

    return $count;
}

function checkWinner($id, $moves) {
    /**START Horizontal */
    $count = countMatches($id, $moves, -1);
    if ($count == 3) {
        return true;
    }
    $count += countMatches($id, $moves, 1);
    if ($count >= 3) {
        return true;
    }
    /**END Horizontal */

    /**START Dioganal1 */
    $count = countMatches($id, $moves, -9, -1);
    if ($count == 3) {
        return true;
    }

    $count += countMatches($id, $moves, 9, 1);
    if ($count >= 3) {
        return true;
    }
    /**END Dioganal1 */

    /**START Dioganal2 */
    $count = countMatches($id, $moves, -11, -1);
    if ($count == 3) {
        return true;
    }

    $count += countMatches($id, $moves, 11, 1);
    if ($count >= 3) {
        return true;
    }
    /**END Dioganal2 */

    $count = countMatches($id, $moves, 10, false);
    if ($count == 3) {
        return true;
    }

    return false;
}

function getCol($id) {
    return $id % 10;
}
function getRow($id) {
    $col = $id % 10;
    return ($id - $col) / 10;
}
?>
