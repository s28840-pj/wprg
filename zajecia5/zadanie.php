<?php
// Dane do połączenia z bazą danych
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test_db';

// Nawiązanie połączenia z bazą danych
$conn = new mysqli($host, $username, $password, $database);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

// Wykonanie zapytania SELECT
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if ($result) {
    // Przetwarzanie wyników za pomocą mysqli_fetch_row
    echo "<h3>Results using mysqli_fetch_row:</h3>";
    while ($row = mysqli_fetch_row($result)) {
        echo "ID: $row[0], Name: $row[1], Email: $row[2]<br>";
    }

    // Przetwarzanie wyników za pomocą mysqli_fetch_array
    // Ustawienie wskaźnika wyniku na początek, aby ponownie przejść przez wyniki
    $result->data_seek(0);

    echo "<h3>Results using mysqli_fetch_array:</h3>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Email: " . $row['email'] . "<br>";
    }

    // Wyświetlenie liczby wierszy wyników
    echo "<h3>Number of rows:</h3>";
    echo "Total rows: " . mysqli_num_rows($result) . "<br>";
} else {
    echo "Error: " . $conn->error;
}

// Wykonanie zapytania INSERT INTO
$insert_sql = "INSERT INTO users (name, email) VALUES ('John Doe', 'john.doe@example.com')";
if ($conn->query($insert_sql) === TRUE) {
    echo "<h3>New record created successfully</h3>";
} else {
    echo "Error: " . $conn->error;
}

// Ponowne wykonanie zapytania SELECT, aby zobaczyć nowo dodany rekord
$result = $conn->query($sql);
if ($result) {
    echo "<h3>Updated Results using mysqli_fetch_array:</h3>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Email: " . $row['email'] . "<br>";
    }
} else {
    echo "Error: " . $conn->error;
}

// Zamknięcie połączenia
$conn->close();
