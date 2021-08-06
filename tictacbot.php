<?php


/*
1. Pagaidām bots karās, kad tiek veikts pēdējais gājiens un būs niča - tikai kad ir ieslegts bots
2. trycorners funkcija izvada vairakas reizes pa daudz gajienus. - laikam check
3. kliskinot uz citiem laukiem ta pat gajienu taisa bots.



*/

if (!isset($_COOKIE['isEnabled'])) {
    $enableValue = 'false';
    $enableName = "Izslēgt botu";
    $enableBot = 'true';
} else {
    $enableValue = $_COOKIE["enableValue"];
    $enableName = $_COOKIE["enableName"];
    $enableBot = $_COOKIE["isEnabled"];
}


if (array_key_exists('enable', $_GET) &&  $_GET['enable'] == 'true') {
    setcookie('isEnabled', 'true', time() + (86400 * 30), "/");
    setcookie('enableName', 'Izslēgt botu', time() + (86400 * 30), "/");
    setcookie('enableValue', 'false', time() + (86400 * 30), "/");
    resetGame();
}

if (array_key_exists('enable', $_GET) &&  $_GET['enable'] == 'false') {
    setcookie('isEnabled', 'false', time() + (86400 * 30), "/");
    setcookie('enableName', 'Ieslēgt botu', time() + (86400 * 30), "/");
    setcookie('enableValue', 'true', time() + (86400 * 30), "/");
    resetGame();
}

//ja ir nospiesta poga piešķirt līmeni viņš to ieraksta cookie
if (isset($_POST['level_submit']) && $_POST['level_submit'] == 'set_level') {
    $cookie_name = 'bot_level';
    $cookie_value = $_POST['bot_level'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    resetGame();
}

//parbaudam vai cookie ir ielikts bota līmeņa dati
if (!isset($_COOKIE['bot_level'])) {
    $botLevel = 'bot_level_low';
} else {
    $botLevel = $_COOKIE['bot_level'];
}




//Option logā rāda konkrēto saglabāto vērtību low/medium/high
switch ($botLevel) {
    case 'bot_level_low':
        $lowSelected = 'selected';
        $mediumSelected = $hardSelected = '';

        break;
    case 'bot_level_medium':
        $mediumSelected = 'selected';
        $lowSelected = $hardSelected = '';
        break;
    case 'bot_level_hard':
        $hardSelected = 'selected';
        $mediumSelected = $lowSelected = '';
        break;
}


//funkcija pievienojam bota gajienu
function addBot()
{
    global $botLevel;

    if (!checkWinner('x')) {

        function defCycle()
        {
            global $moves;
            do {
                $rand = rand(1, 9);
            } while (array_key_exists($rand, $moves));

            add($rand, 'o');
            return true;
        }

        function tryCorners()
        {
            global $moves;
            $rand = rand(1, 9);
            for ($i = $rand; $i <= 9; $i += 2) {
                if (!array_key_exists($i, $moves)) {
                    add($i, 'o');
                    break;
                } else {
                    tryMiddle();
                    break;
                }
            }
            return true;
        }
        function tryMiddle()
        {
            global $moves;
            if (!array_key_exists(5, $moves)) {
                add(5, 'o');
            } else {
                tryCorners();
            }
        }

        switch ($botLevel) {
            case 'bot_level_low':
                tryCorners();
                break;

            case 'bot_level_medium':
                tryMiddle();

                break;

            case 'bot_level_hard':
                tryCorners();
                break;
        }
    }
}

// ja tiek nospiesta poga ka bots ies pirmais
if (array_key_exists('start', $_GET) &&  $_GET['start'] == 'bot') {
    resetGame();
    addBot();
}
