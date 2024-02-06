<?php
include('kino.php');


if (isset($_GET['id'])) {
    $filmID = intval($_GET['id']);

    $query = "SELECT * FROM Filmy WHERE FilmID = ?";
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $filmID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $film = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = mysqli_real_escape_string($connect, strip_tags($_POST['Tytul']));
    $rezyser = mysqli_real_escape_string($connect, strip_tags($_POST['Rezyser']));
    $gatunek = mysqli_real_escape_string($connect, strip_tags($_POST['Gatunek']));
    $rokProdukcji = mysqli_real_escape_string($connect, strip_tags($_POST['RokProdukcji']));
    $czasTrwania = mysqli_real_escape_string($connect, strip_tags($_POST['CzasTrwania']));
    $filmID = intval($_POST['FilmID']);

    $sql = "UPDATE Filmy SET Tytul=?, Rezyser=?, RokProdukcji=?, Gatunek=?, CzasTrwania=? WHERE FilmID=?";
    
    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssisii", $tytul, $rezyser, $rokProdukcji, $gatunek, $czasTrwania, $filmID);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edytuj film:</h2>
    <form action="edit_film.php" method="POST">
        <input type="hidden" name="FilmID" value="<?php echo $film['FilmID']; ?>"><br>
        <input type="text" name="Tytul" placeholder="Tytuł filmu" value="<?php echo $film['Tytul']; ?>" required><br>
        <input type="text" name="Rezyser" placeholder="Imię i nazwisko reżysera" value="<?php echo $film['Rezyser']; ?>" required><br>
        <input type="number" name="RokProdukcji" placeholder="Rok produkcji filmu" value="<?php echo $film['RokProdukcji']; ?>" required><br>
        <input type="text" name="Gatunek" placeholder="Gatunek filmu" value="<?php echo $film['Gatunek']; ?>" required><br>
        <input type="number" name="CzasTrwania" placeholder="Czas trwania" value="<?php echo $film['CzasTrwania']; ?>" required><br>
        <input type="submit" name="submit" value="ZAKTUALIZUJ FILM" class="btn btn-success">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
