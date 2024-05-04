<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form method="post">
        <label for="path">Ścieżka:</label>
        <input type="text" id="path" name="path" required>
        <br>
        <label for="dirname">Nazwa katalogu:</label>
        <input type="text" id="dirname" name="dirname" required>
        <br>
        <label for="operation">Operacja:</label>
        <select id="operation" name="operation">
            <option value="read">Odczyt</option>
            <option value="delete">Usuń</option>
            <option value="create">Stwórz</option>
        </select>
        <br>
        <input type="submit" value="Wykonaj">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $path = rtrim($_POST['path'], '/') . '/';
        $dirname = $_POST['dirname'];
        $operation = $_POST['operation'] ?? 'read';

        function manageDirectory($path, $dirname, $operation = 'read') {
            $fullPath = $path . $dirname;

            if ($operation === 'read') {
                if (is_dir($fullPath)) {
                    $elements = scandir($fullPath);
                    if ($elements === false) {
                        return "Nie udało się odczytać zawartości katalogu.";
                    }
                    return "Zawartość katalogu: " . implode(", ", array_diff($elements, array('.', '..')));
                } else {
                    return "Katalog nie istnieje.";
                }
            }

            if ($operation === 'delete') {
                if (!is_dir($fullPath)) {
                    return "Katalog nie istnieje.";
                }
                $elements = array_diff(scandir($fullPath), array('.', '..'));
                if (count($elements) > 0) {
                    return "Katalog nie jest pusty i nie można go usunąć.";
                }
                if (rmdir($fullPath)) {
                    return "Katalog został pomyślnie usunięty.";
                } else {
                    return "Nie udało się usunąć katalogu.";
                }
            }

            if ($operation === 'create') {
                if (is_dir($fullPath)) {
                    return "Katalog już istnieje.";
                }
                if (mkdir($fullPath, 0777, true)) {
                    return "Katalog został pomyślnie stworzony.";
                } else {
                    return "Nie udało się stworzyć katalogu.";
                }
            }

            return "Nieznana operacja.";
        }

        $result = manageDirectory($path, $dirname, $operation);
        echo "<p>$result</p>";
    }
    ?>
</body>
</html>
