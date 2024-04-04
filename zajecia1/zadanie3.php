<form>
    <input type="text" pattern="[1-9][0-9]*" name="count">
    <input type="submit">
</form>
<?php
    if (isset($_GET['count'])) {
        $CNT = intval($_GET['count']);
        $nums = array_fill(0, $CNT, 1);

        for ($i = 2; $i < $CNT; $i += 1) {
            $nums[$i] = $nums[$i - 2] + $nums[$i - 1];
        }

        echo '<p>fib(' . number_format($CNT) . ') = ' . number_format($nums[$CNT - 1]) . '</p>';

        for ($i = 0; $i < $CNT / 2; $i += 1) {
            echo number_format($i + 1) . ': ' . number_format($nums[$i * 2]) . '<br>';
        }
    } else {
        echo '<p>Ktora liczba ciagu fibonacciego?</p>';
    }
