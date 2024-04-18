<form>
    <input type="text" pattern="[0-9]+" name="num">
    <input type="submit">
</form>
<?php
    if (isset($_GET['num'])) {
        $num = intval($_GET['num']);

        $prime = true;
        for ($i = 2; $i * $i < $num; $i += 1) {
            if ($num % $i == 0) {
                $prime = false;
                break;
            }
        }

        $res = ' nie jest pierwsza';
        if ($prime) {
            $res = ' jest pierwsza';
        }

        echo '<p>Liczba ' . $num . $res . '</p>';
    } else {
        echo '<p>Czy liczba pierwsza tester</p>';
    }
