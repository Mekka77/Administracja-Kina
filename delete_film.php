<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filmID = mysqli_real_escape_string($connect, $_POST['FilmID']);

    $sql = "DELETE FROM Filmy WHERE FilmID = ?";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $filmID);
        
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: index.php?action=display");
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
