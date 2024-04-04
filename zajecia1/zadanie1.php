<?php
    $owoce = array('jablko', 'banan', 'pomarancz', 'grejpfrut');

    foreach ($owoce as $owoc) {
        echo '<div>';
        echo '<p>';
        for ($i = strlen($owoc) - 1; $i >= 0; $i -= 1) {
            echo $owoc[$i];
        }
        echo '</p>';
        $odp = 'Nie';
        if ($owoc[0] == 'p') { $odp = 'Tak'; }
        echo '<p>Zaczyna się na literę P? ' . $odp . '</p>';
        echo '</div>';
        echo '<hr>';
    }
