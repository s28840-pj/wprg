<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $osoby = $_POST["osoby"];
    if ($osoby < 1 || $osoby > 4) {
        $errors[] = "Nieprawidłowa ilość osób";
    }

    $imie = $_POST["imie"];
    if (empty($imie)) {
        $errors[] = "Imię jest wymagane";
    }

    $nazwisko = $_POST["nazwisko"];
    if (empty($nazwisko)) {
        $errors[] = "Nazwisko jest wymagane";
    }

    $adres = $_POST["adres"];
    if (empty($adres)) {
        $errors[] = "Adres jest wymagany";
    }

    $karta = $_POST["karta"];
    if (empty($karta)) {
        $errors[] = "Dane karty są wymagane";
    }

    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Nieprawidłowy adres email";
    }

    $data = $_POST["data"];
    if (empty($data)) {
        $errors[] = "Data pobytu jest wymagana";
    }

    if (empty($errors)) {
        $godzina = $_POST["godzina"];
        $lozko_dzieciece = isset($_POST["lozko_dzieciece"]) ? "Tak" : "Nie";
        $udogodnienia = implode(", ", $_POST["udogodnienia"]);

        echo "<h2>Podsumowanie rezerwacji</h2>";
        echo "Ilość osób: $osoby<br>";
        echo "Imię: $imie<br>";
        echo "Nazwisko: $nazwisko<br>";
        echo "Adres: $adres<br>";
        echo "Dane karty: $karta<br>";
        echo "Email: $email<br>";
        echo "Data pobytu: $data<br>";
        echo "Godzina przyjazdu: $godzina<br>";
        echo "Łóżko dla dziecka: $lozko_dzieciece<br>";
        echo "Udogodnienia: $udogodnienia<br>";
    } else {
        echo "<h2>Błędy</h2>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
?>
<form method="post">
    Ilość osób: <select name="osoby">
        <?php for ($i = 1; $i <= 4; $i++) echo "<option value=\"$i\">$i</option>"; ?>
    </select><br>
    Imię: <input type="text" name="imie" required><br>
    Nazwisko: <input type="text" name="nazwisko" required><br>
    Adres: <input type="text" name="adres" required><br>
    Dane karty: <input type="text" name="karta" required><br>
    Email: <input type="email" name="email" required><br>
    Data pobytu: <input type="date" name="data" required><br>
    Godzina przyjazdu: <input type="time" name="godzina"><br>
    Łóżko dla dziecka: <input type="checkbox" name="lozko_dzieciece"><br>
    Udogodnienia: <br>
    <input type="checkbox" name="udogodnienia[]" value="Klimatyzacja"> Klimatyzacja<br>
    <input type="checkbox" name="udogodnienia[]" value="Popielniczka dla palacza"> Popielniczka dla palacza<br>
    <input type="submit" value="Zarezerwuj">
</form>
<?php
}
?>
