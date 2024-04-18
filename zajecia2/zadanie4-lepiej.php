<form>
    <input type="text" pattern="[0-9]+" name="num">
    <input type="submit">
</form>
<?php
    function is_prime($n) {
        if ($n == 2 || $n == 3) {
            return true;
        }

        if ($n % 2 == 0 || $n % 3 == 0) {
            return false;
        }

        for ($i = 5; $i * $i <= $n; $i += 6) {
            if ($n % $i == 0 || $n % ($i + 2) == 0) {
                return false;
            }
        }

        return true;
    }

    if (isset($_GET['num'])) {
        $num = intval($_GET['num']);

        $res = ' nie jest pierwsza';
        if (is_prime($num)) {
            $res = ' jest pierwsza';
        }

        echo '<p>Liczba ' . $num . $res . '</p>';
    } else {
        echo '<p>Czy liczba pierwsza tester</p>';
    }
