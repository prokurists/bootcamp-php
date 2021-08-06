<!doctype html>
<link rel="stylesheet" href="style.css">
<?php
/**
 * Pievieno navigāciju
 * Q: Vai navigācija ir kāds PHP kods vai tikai HTML?
 * A: Tur ir gan PHP gan HTML
 */
include "navigation.php";

//pievienoju botu
include "tictacbot.php";


//Pārbaude vai ir uzspiesta reset poga
/**
 * Q: Kā darbojas šis if nosacijums?
 * A: array_key_exists('reset', $_GET) - pārbauda vai reset atslēga ir masīvā $_GET
 * A: $_GET['reset'] == 'true' - salīdzina vai reset vērtība ir 'true'
 */
if (array_key_exists('reset', $_GET) &&  $_GET['reset'] == 'true') {
    //ir uzspiesta
    resetGame();
    $moves = [];
} else {
    //nav uzspiesta
    $moves = get();
}
print_r($moves['x']);

/**
 * Pārbauda vai ir padoda ID vērtība
 * Q1: Vai šī pārbaude būs vajadzīga?
 * A1: Jā, vajadzīga
 */
if (array_key_exists('id', $_GET)) { //ir padota
    // pēc skaita nosaka vai jāliek X vai O
    if ($enableBot == 'false') {
        $symbol = count($moves) % 2 == 0 ? 'x' : 'o';
    } else {
        //Izmaiņas, par cik spēlēs tikai
        $symbol = 'x';
    }
    // Pārbauda vai nav noteikts uzvarētājs
    if (@$moves['winner'] === null) { //nav noteikts uzvarētājs
        // pievieno simbolu json failā
        if ($enableBot == 'true') {
            if (add($_GET['id'], $symbol)) {
                addBot();
            }
            checkWinner('o');
        } else {
            add($_GET['id'], $symbol);
            checkWinner($symbol);
        }
    } else {
        echo "<h2>Winner is '$symbol'!</h2>";
    }
}
?>
<a class="btn" href="?enable=<?= @$enableValue; ?>"><?= @$enableName; ?></a>
<?php if ($enableBot == 'true') { ?>
    <a class="btn" href="?start=bot">Bots sāk spēli</a>
    <form action="" method="POST" class="btn">
        <select name="bot_level" id="">
            <option value="bot_level_low" <?php echo $lowSelected; ?>>Low</option>
            <option value="bot_level_medium" <?php echo $mediumSelected; ?>>Medium</option>
            <option value="bot_level_hard" <?php echo $hardSelected; ?>>Hard</option>
        </select>
        <button type="submit" name="level_submit" value="set_level">Set level</button>
    </form>
<?php } ?>
<div class="game_board">
    <?php

    for ($i = 1; $i <= 9; $i++) {
        // Ievietojam simbolu iekš <a>
        /**
         * Q: Kur ņemam $symbol vērtību?
         */
        if (($botLevel == 'bot_level_hard') &&  @$moves[$i] == 'o' && ($_COOKIE['isEnabled'] == 'true')) {
            $symbol = '';
        } else {
            $symbol = array_key_exists($i, $moves) ? $moves[$i] : '';
        }

        echo "<a href='?id=$i'>" . $symbol . "</a> ";
    }
    ?>
</div>
<a href="?reset=true" class="btn">Reset</a>


<?php

function get()
{
    // Pārbauda vai neeksistē fails
    if (!file_exists('tic_data.json')) { // Fails neeksistē
        //Pārtraucam funkcijas izpildi izvadot tukšu masīvu
        return [];
    }

    // Paņems JSON formāta visus gājienus no faila un ierakstīs mainīgajā
    $content = file_get_contents('tic_data.json');

    // No JSON formāta pārvērš saturu uz massīvu
    $data = json_decode($content, true);
    if (!is_array($data)) {
        $data = [];
    }

    return $data;
}

function add($id, $symbol)
{
    // Pieslēdz globālo mainīgo
    global $moves;
    // Vai gājienu masīvā nav ID
    if (!array_key_exists($id, $moves)) { //Šāda ID vel nav
        // Masīvā ieraksta simbolu ar noteiktu ID
        $moves[$id] = $symbol;
        // Gājienu masīvu pārvērš JSON formātā
        $json = json_encode($moves);
        // JSON formātā visus gājienus saglabā failā
        file_put_contents('tic_data.json', $json);

        return true;
    }
}
//Resetojam tic.data.json failu, jeb visus laukus.
function resetGame()
{
    //ieliekam tic.data.json failā {}
    file_put_contents('tic_data.json', '{}');
    // pārmet mūs uz lokāciju ?
    header('Location: ?');
}

// pārbauda uzvarētāju
function checkWinner($symbol)
{
    //pieslēdz globālo mainīgo
    global $moves;
    //nodefinē visus uzvaras variantus
    $win_combinations = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],

        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],

        [1, 5, 9],
        [3, 5, 7],
    ];

    //foreach cikls, kur izejam cauri visām kombinācijām
    foreach ($win_combinations as $combination) {
        //parbaudam vai ir visi 3 varianti kādā no masīviem
        if (
            @$moves[$combination[0]] == $symbol &&
            @$moves[$combination[1]] == $symbol &&
            @$moves[$combination[2]] == $symbol
        ) { // ja sakrīt izvada m uzvarētāju
            echo "<h2>Winner is '$symbol'!</h2>";
            // pievienojam uzvarētāju un nobloķējam iespēju veikt darbības
            add('winner', $symbol);
            return true;
        }
    }
    return false;
}

?>