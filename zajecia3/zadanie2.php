<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form method="get">
        <label for="number">Podaj liczbę:</label>
        <input type="number" id="number" name="number" required>
        <label for="function">Wybierz funkcję:</label>
        <select id="function" name="function">
            <option value="factorial">Silnia</option>
            <option value="fibonacci">Ciąg Fibonacciego</option>
        </select>
        <input type="submit" value="Wyślij">
    </form>

    <?php
    if (isset($_GET['number']) && isset($_GET['function'])) {
        $number = intval($_GET['number']);
        $function = $_GET['function'];

        // Rekurencyjna funkcja silni
        function factorialRecursive($n) {
            if ($n === 0) {
                return 1;
            }
            return $n * factorialRecursive($n - 1);
        }

        // Iteracyjna funkcja silni
        function factorialIterative($n) {
            $result = 1;
            for ($i = 1; $i <= $n; $i++) {
                $result *= $i;
            }
            return $result;
        }

        // Rekurencyjna funkcja Fibonacciego
        function fibonacciRecursive($n) {
            if ($n === 0) {
                return 0;
            }
            if ($n === 1) {
                return 1;
            }
            return fibonacciRecursive($n - 1) + fibonacciRecursive($n - 2);
        }

        // Iteracyjna funkcja Fibonacciego
        function fibonacciIterative($n) {
            if ($n === 0) {
                return 0;
            }
            if ($n === 1) {
                return 1;
            }
            $prev = 0;
            $curr = 1;
            for ($i = 2; $i <= $n; $i++) {
                $temp = $curr;
                $curr = $prev + $curr;
                $prev = $temp;
            }
            return $curr;
        }

        // Pomiar czasu wykonania funkcji
        function measureTime($function, $arg) {
            $start = microtime(true);
            $result = $function($arg);
            $end = microtime(true);
            return [$result, $end - $start];
        }

        // Wybór i wykonanie odpowiednich funkcji
        if ($function === 'factorial') {
            list($resultRecursive, $timeRecursive) = measureTime('factorialRecursive', $number);
            list($resultIterative, $timeIterative) = measureTime('factorialIterative', $number);
        } else {
            list($resultRecursive, $timeRecursive) = measureTime('fibonacciRecursive', $number);
            list($resultIterative, $timeIterative) = measureTime('fibonacciIterative', $number);
        }

        // Wyświetlenie wyników
        echo "<p>Wynik funkcji rekurencyjnej: $resultRecursive</p>";
        echo "<p>Czas wykonania funkcji rekurencyjnej: " . number_format($timeRecursive, 10) . " sekund</p>";
        echo "<p>Wynik funkcji iteracyjnej: $resultIterative</p>";
        echo "<p>Czas wykonania funkcji iteracyjnej: " . number_format($timeIterative, 10) . " sekund</p>";

        if ($timeRecursive < $timeIterative) {
            $fasterFunction = "rekurencyjna";
            $timeDifference = $timeIterative - $timeRecursive;
        } else {
            $fasterFunction = "iteracyjna";
            $timeDifference = $timeRecursive - $timeIterative;
        }

        echo "<p>Funkcja $fasterFunction była szybsza o " . number_format(abs($timeDifference), 10) . " sekund</p>";
    }
    ?>
</body>
</html>
