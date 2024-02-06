<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = mysqli_real_escape_string($connect, strip_tags($_POST['Imie']));
    $nazwisko = mysqli_real_escape_string($connect, strip_tags($_POST['Nazwisko']));
    $email = mysqli_real_escape_string($connect, strip_tags($_POST['Email']));
    $telefon = mysqli_real_escape_string($connect, strip_tags($_POST['Telefon']));

    $sql = "INSERT INTO Klienci (Imie, Nazwisko, Email, Telefon) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $imie, $nazwisko, $email, $telefon);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New client record created successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=displayClients");
            exit;
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}


if(isset($_GET['error'])) {
    echo "<p>Error processing the request!</p>";
}
?>
