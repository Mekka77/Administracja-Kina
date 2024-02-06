<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filmID = mysqli_real_escape_string($connect, strip_tags($_POST['FilmID']));
    $salaID = mysqli_real_escape_string($connect, strip_tags($_POST['SalaID']));
    $dataSeansu = mysqli_real_escape_string($connect, strip_tags($_POST['DataSeansu']));

    $sql = "INSERT INTO Seanse (FilmID, SalaID, DataSeansu) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $filmID, $salaID, $dataSeansu);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New screening record created successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=displaySeanse");
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
