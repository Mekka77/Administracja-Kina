<?php
session_start();
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwaUzytkownika = mysqli_real_escape_string($connect, $_POST['NazwaUzytkownika']);
    $haslo = $_POST['Haslo']; 

    $sql = "SELECT AdminID, NazwaUzytkownika, Haslo FROM Administratorzy WHERE NazwaUzytkownika = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $nazwaUzytkownika);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && $user['Haslo'] === $haslo) {
            $_SESSION['loggedin'] = true;
            $_SESSION['AdminID'] = $user['AdminID'];
            $_SESSION['NazwaUzytkownika'] = $user['NazwaUzytkownika'];

            header("Location:index.php");
            exit;
        } else {
            echo "Niepoprawna nazwa użytkownika lub hasło";
        }
    } else {
        echo "Błąd: " . mysqli_error($connect);
    }
}
?>
