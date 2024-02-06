<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klientID = mysqli_real_escape_string($connect, $_POST['KlientID']);

    $sql = "DELETE FROM Klienci WHERE KlientID = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $klientID);
        
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: index.php?action=displayClients");
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
