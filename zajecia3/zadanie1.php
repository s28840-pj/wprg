<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form method="get">
        <label for="birthdate">Wybierz datę urodzenia:</label>
        <input type="date" id="birthdate" name="birthdate" required>
        <input type="submit" value="Wyślij">
    </form>

    <?php
    if (isset($_GET['birthdate'])) {
        $birthdate = $_GET['birthdate'];

        function getDayOfWeek($date) {
            $timestamp = strtotime($date);
            return date('l', $timestamp);
        }

        function calculateAge($date) {
            $birthDate = new DateTime($date);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDate);
            return $age->y;
        }

        function daysUntilNextBirthday($date) {
            $birthDate = new DateTime($date);
            $currentDate = new DateTime();
            
            // Ustawienie następnych urodzin
            $nextBirthday = new DateTime($currentDate->format('Y') . '-' . $birthDate->format('m-d'));

            // Jeżeli następne urodziny już były w tym roku, ustaw na przyszły rok
            if ($nextBirthday < $currentDate) {
                $nextBirthday->modify('+1 year');
            }

            $interval = $currentDate->diff($nextBirthday);
            return $interval->days;
        }

        $dayOfWeek = getDayOfWeek($birthdate);
        $age = calculateAge($birthdate);
        $daysToNextBirthday = daysUntilNextBirthday($birthdate);

        echo "<p>Urodziłeś się w: $dayOfWeek.</p>";
        echo "<p>Masz ukończone: $age lat.</p>";
        echo "<p>Do następnych urodzin pozostało: $daysToNextBirthday dni.</p>";
    }
    ?>
</body>
</html>
