<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = mysqli_real_escape_string($connect, strip_tags($_POST['Tytul']));
    $rezyser = mysqli_real_escape_string($connect, strip_tags($_POST['Rezyser']));
    $gatunek = mysqli_real_escape_string($connect, strip_tags($_POST['Gatunek']));
    $rokProdukcji = mysqli_real_escape_string($connect, strip_tags($_POST['RokProdukcji']));
    $czasTrwania = mysqli_real_escape_string($connect, strip_tags($_POST['CzasTrwania']));

    $sql = "INSERT INTO Filmy (Tytul, Rezyser, RokProdukcji, Gatunek, CzasTrwania) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssisi", $tytul, $rezyser, $rokProdukcji, $gatunek, $czasTrwania);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New record created successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=display");
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
