<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salaID = mysqli_real_escape_string($connect, $_POST['SalaID']);

    $sql = "DELETE FROM SaleKino WHERE SalaID = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $salaID);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?action=displaySaleKino");
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
