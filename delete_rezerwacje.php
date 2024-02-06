<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rezerwacjaID = mysqli_real_escape_string($connect, $_POST['RezerwacjaID']);

    $sql = "DELETE FROM Rezerwacje WHERE RezerwacjaID = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $rezerwacjaID);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?action=displayRezerwacje");
            exit;
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>