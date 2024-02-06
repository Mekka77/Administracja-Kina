<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seansID = intval($_POST['SeansID']);
    $filmID = intval($_POST['FilmID']);
    $salaID = intval($_POST['SalaID']);
    $dataSeansu = mysqli_real_escape_string($connect, $_POST['DataSeansu']);

    $sql = "UPDATE Seanse SET FilmID=?, SalaID=?, DataSeansu=? WHERE SeansID=?";
    
    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "iisi", $filmID, $salaID, $dataSeansu, $seansID);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
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

if (isset($_GET['id'])) {
    $seansID = intval($_GET['id']);

    $query = "SELECT Seanse.*, Filmy.Tytul, SaleKino.NumerSali FROM Seanse 
              JOIN Filmy ON Seanse.FilmID = Filmy.FilmID 
              JOIN SaleKino ON Seanse.SalaID = SaleKino.SalaID
              WHERE SeansID = ?";
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $seansID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $seans = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Seans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edytuj seans:</h2>
    <form action="edit_seans.php" method="POST">
        <input type="hidden" name="SeansID" value="<?php echo $seans['SeansID']; ?>"><br>
        <select name="FilmID" required>
            <?php
            $films = mysqli_query($connect, "SELECT * FROM Filmy");
            while($film = mysqli_fetch_assoc($films)) {
                $selected = ($film['FilmID'] == $seans['FilmID']) ? "selected" : "";
                echo "<option value='".$film['FilmID']."' $selected>".$film['Tytul']."</option>";
            }
            ?>
        </select><br>
        <select name="SalaID" required>
            <?php
            $sale = mysqli_query($connect, "SELECT * FROM SaleKino");
            while($sala = mysqli_fetch_assoc($sale)) {
                $selected = ($sala['SalaID'] == $seans['SalaID']) ? "selected" : "";
                echo "<option value='".$sala['SalaID']."' $selected>".$sala['NumerSali']."</option>";
            }
            ?>
        </select><br>
        <input type="datetime-local" name="DataSeansu" value="<?php echo date('Y-m-d\TH:i', strtotime($seans['DataSeansu'])); ?>" required><br>
        <input type="submit" name="submit" value="ZAKTUALIZUJ SEANS" class="btn btn-success">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
