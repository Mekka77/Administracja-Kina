<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seansID = mysqli_real_escape_string($connect, $_POST['SeansID']);

    $sql = "DELETE FROM Seanse WHERE SeansID = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $seansID);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?action=displaySeanse");
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
