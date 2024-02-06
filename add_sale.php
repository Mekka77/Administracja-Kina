<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numerSali = mysqli_real_escape_string($connect, strip_tags($_POST['NumerSali']));
    $liczbaMiejsc = mysqli_real_escape_string($connect, strip_tags($_POST['LiczbaMiejsc']));

    $sql = "INSERT INTO SaleKino (NumerSali, LiczbaMiejsc) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $numerSali, $liczbaMiejsc);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New cinema hall record created successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=displaySaleKino");
            exit;
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
