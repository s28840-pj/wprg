<form>
    <input type="text" pattern="[0-9]+" name="count">
    <input type="submit">
</form>
<?php
    if (isset($_GET['count'])) {
        $CNT = intval($_GET['count']);
        echo '<p>Liczby pierwsze od 2 do ' . $CNT . '</p>';
        $sito = array_fill(2, $CNT + 1, true);

        for ($i = 2; $i <= $CNT / 2; $i += 1) {
            if (!$sito[$i]) continue;

            for ($j = $i * 2; $j <= $CNT; $j += $i) $sito[$j] = false;
        }

        for ($i = 2; $i <= $CNT; $i += 1) {
            if (!$sito[$i]) continue;
        
            echo $i . '<br>';
        }
    } else {
        echo '<p>Od 2 do jakiej liczby znalezc liczby pierwsze?</p>';
    }
