<?php
session_start();

// Ustawienie danych logowania
$login_data = [
    'username' => 'admin',
    'password' => 'password'
];

// Funkcja logowania
function login($username, $password, $login_data) {
    if ($username === $login_data['username'] && $password === $login_data['password']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

// Funkcja wylogowania
function logout() {
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function hasAllFields() {
    foreach (['osoby', 'imie'] as $field) {
        if (!isset($_POST[$field])) return false;
    }
    return true;
}

function mysetcookie($name, $val, $time) {
    setcookie($name, $val, $time);
    $_COOKIE[$name] = $val;
}

// Obsługa logowania
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!login($username, $password, $login_data)) {
        $login_error = "Nieprawidłowy login lub hasło.";
    }
}

// Obsługa wylogowania
if (isset($_POST['logout'])) {
    logout();
}

// Obsługa formularza rezerwacji
if ($_SERVER["REQUEST_METHOD"] == "POST" && isLoggedIn() && hasAllFields()) {
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

    $osoby_info = [];
    for ($i = 1; $i <= $osoby; $i++) {
        $osoba_imie = $_POST["osoba{$i}_imie"];
        $osoba_nazwisko = $_POST["osoba{$i}_nazwisko"];
        if (empty($osoba_imie) || empty($osoba_nazwisko)) {
            $errors[] = "Imię i nazwisko są wymagane dla osoby $i";
        } else {
            $osoby_info[] = "Osoba $i: $osoba_imie $osoba_nazwisko";
        }
    }

    if (empty($errors)) {
        $godzina = $_POST["godzina"];
        $lozko_dzieciece = isset($_POST["lozko_dzieciece"]) ? "Tak" : "Nie";
        $udogodnienia = isset($_POST["udogodnienia"]) ? implode(", ", $_POST["udogodnienia"]) : '';

        // Ustawienie ciasteczek
        mysetcookie('osoby', $osoby, time() + 3600);
        mysetcookie('imie', $imie, time() + 3600);
        mysetcookie('nazwisko', $nazwisko, time() + 3600);
        mysetcookie('adres', $adres, time() + 3600);
        mysetcookie('karta', $karta, time() + 3600);
        mysetcookie('email', $email, time() + 3600);
        mysetcookie('data', $data, time() + 3600);
        mysetcookie('godzina', $godzina, time() + 3600);
        mysetcookie('lozko_dzieciece', $lozko_dzieciece, time() + 3600);
        mysetcookie('udogodnienia', $udogodnienia, time() + 3600);
        for ($i = 1; $i <= $osoby; $i++) {
            $name = "osoba{$i}_imie";
            $surname = "osoba{$i}_nazwisko";
            $osoba_imie = $_POST["osoba{$i}_imie"];
            $osoba_nazwisko = $_POST["osoba{$i}_nazwisko"];
            mysetcookie($name, $osoba_imie, time() + 3600);
            mysetcookie($surname, $osoba_nazwisko, time() + 3600);
        }

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
        foreach ($osoby_info as $info) {
            echo $info . "<br>";
        }
    } else {
        echo "<h2>Błędy</h2>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_cookies'])) {
    // Czyszczenie ciasteczek
    mysetcookie('osoby', '', time() - 3600);
    mysetcookie('imie', '', time() - 3600);
    mysetcookie('nazwisko', '', time() - 3600);
    mysetcookie('adres', '', time() - 3600);
    mysetcookie('karta', '', time() - 3600);
    mysetcookie('email', '', time() - 3600);
    mysetcookie('data', '', time() - 3600);
    mysetcookie('godzina', '', time() - 3600);
    mysetcookie('lozko_dzieciece', '', time() - 3600);
    mysetcookie('udogodnienia', '', time() - 3600);

    echo "<p>Ciasteczka zostały wyczyszczone.</p>";
}
?>

<?php if (!isLoggedIn()): ?>
    <h2>Logowanie</h2>
    <?php if (isset($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
    <form method="post">
        Login: <input type="text" name="username" required><br>
        Hasło: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Zaloguj">
    </form>
<?php else: ?>
    <?php $udogodnienia = isset($_COOKIE["udogodnienia"]) ? explode(", ", $_COOKIE["udogodnienia"]) : []; ?>
    <h2>Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <form method="post">
        <input type="submit" name="logout" value="Wyloguj">
    </form>
    <h2>Formularz rezerwacji hotelu</h2>
    <form method="post">
        Ilość osób: <select name="osoby" id="osoby">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo (isset($_COOKIE['osoby']) && $_COOKIE['osoby'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br>
        Imię: <input type="text" name="imie" value="<?php echo isset($_COOKIE['imie']) ? $_COOKIE['imie'] : ''; ?>" required><br>
        Nazwisko: <input type="text" name="nazwisko" value="<?php echo isset($_COOKIE['nazwisko']) ? $_COOKIE['nazwisko'] : ''; ?>" required><br>
        Adres: <input type="text" name="adres" value="<?php echo isset($_COOKIE['adres']) ? $_COOKIE['adres'] : ''; ?>" required><br>
        Dane karty: <input type="text" name="karta" value="<?php echo isset($_COOKIE['karta']) ? $_COOKIE['karta'] : ''; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" required><br>
        Data pobytu: <input type="date" name="data" value="<?php echo isset($_COOKIE['data']) ? $_COOKIE['data'] : ''; ?>" required><br>
        Godzina przyjazdu: <input type="time" name="godzina" value="<?php echo isset($_COOKIE['godzina']) ? $_COOKIE['godzina'] : ''; ?>"><br>
        Łóżko dla dziecka: <input type="checkbox" name="lozko_dzieciece" <?php echo (isset($_COOKIE['lozko_dzieciece']) && $_COOKIE['lozko_dzieciece'] == 'Tak') ? 'checked' : ''; ?>><br>
        Udogodnienia: <br>
        <input type="checkbox" name="udogodnienia[]" value="Klimatyzacja" <?php echo (in_array('Klimatyzacja', $udogodnienia)) ? 'checked' : ''; ?>> Klimatyzacja<br>
        <input type="checkbox" name="udogodnienia[]" value="Popielniczka dla palacza" <?php echo (in_array('Popielniczka dla palacza', $udogodnienia)) ? 'checked' : ''; ?>> Popielniczka dla palacza<br>
        <div id="osoby_info">
            <?php
            if (isset($_COOKIE['osoby'])) {
                for ($i = 1; $i <= $_COOKIE['osoby']; $i++) {
                    $imie_cookie = isset($_COOKIE["osoba{$i}_imie"]) ? $_COOKIE["osoba{$i}_imie"] : '';
                    $nazwisko_cookie = isset($_COOKIE["osoba{$i}_nazwisko"]) ? $_COOKIE["osoba{$i}_nazwisko"] : '';
                    echo "Imię osoby $i: <input type=\"text\" name=\"osoba{$i}_imie\" value=\"$imie_cookie\" required><br>";
                    echo "Nazwisko osoby $i: <input type=\"text\" name=\"osoba{$i}_nazwisko\" value=\"$nazwisko_cookie\" required><br>";
                }
            }
            ?>
        </div>
        <input type="submit" value="Zarezerwuj">
    </form>
    <script>
    const osoby = document.getElementById('osoby');
    const osoby_info = document.getElementById('osoby_info');
    function updatePersons() {
        osoby_info.innerHTML = '';
        for (var i = 1; i <= osoby.value; i++) {
            osoby_info.innerHTML += 'Imię osoby ' + i + ': <input type="text" name="osoba' + i + '_imie" required><br>';
            osoby_info.innerHTML += 'Nazwisko osoby ' + i + ': <input type="text" name="osoba' + i + '_nazwisko" required><br>';
        }
    }
    osoby.addEventListener('change', updatePersons);
    if (osoby_info.childElementCount == 0) updatePersons();
    </script>
<?php endif ?>
