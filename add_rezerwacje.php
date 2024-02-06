<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klientID = mysqli_real_escape_string($connect, strip_tags($_POST['KlientID']));
    $seansID = mysqli_real_escape_string($connect, strip_tags($_POST['SeansID']));
    $liczbaBiletow = mysqli_real_escape_string($connect, strip_tags($_POST['LiczbaBiletow']));
    $dataRezerwacji = date('Y-m-d H:i:s'); 

    $sql = "INSERT INTO Rezerwacje (KlientID, SeansID, LiczbaBiletow, DataRezerwacji) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiis", $klientID, $seansID, $liczbaBiletow, $dataRezerwacji);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New reservation record created successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=displayRezerwacje");
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
