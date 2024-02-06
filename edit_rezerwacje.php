<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rezerwacjaID = intval($_POST['RezerwacjaID']);
    $klientID = intval($_POST['KlientID']);
    $seansID = intval($_POST['SeansID']);
    $liczbaBiletow = intval($_POST['LiczbaBiletow']);

    $sql = "UPDATE Rezerwacje SET KlientID=?, SeansID=?, LiczbaBiletow=? WHERE RezerwacjaID=?";
    
    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiii", $klientID, $seansID, $liczbaBiletow, $rezerwacjaID);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
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

if (isset($_GET['id'])) {
    $rezerwacjaID = intval($_GET['id']);

    $query = "SELECT * FROM Rezerwacje WHERE RezerwacjaID = ?";
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $rezerwacjaID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rezerwacja = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Rezerwację</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edytuj rezerwację:</h2>
    <form action="edit_rezerwacje.php" method="POST">
        <input type="hidden" name="RezerwacjaID" value="<?php echo $rezerwacja['RezerwacjaID']; ?>"><br>
        <select name="KlientID" required>
            <?php
            $klienci = mysqli_query($connect, "SELECT * FROM Klienci");
            while($klient = mysqli_fetch_assoc($klienci)) {
                $selected = ($klient['KlientID'] == $rezerwacja['KlientID']) ? "selected" : "";
                echo "<option value='".$klient['KlientID']."' $selected>".$klient['Imie']." ".$klient['Nazwisko']."</option>";
            }
            ?>
        </select><br>
        <select name="SeansID" required>
            <?php
            $seanse = mysqli_query($connect, "SELECT Seanse.*, Filmy.Tytul FROM Seanse JOIN Filmy ON Seanse.FilmID = Filmy.FilmID");
            while($seans = mysqli_fetch_assoc($seanse)) {
                $selected = ($seans['SeansID'] == $rezerwacja['SeansID']) ? "selected" : "";
                echo "<option value='".$seans['SeansID']."' $selected>".$seans['Tytul']." - ".$seans['DataSeansu']."</option>";
            }
            ?>
        </select><br>
        <input type="number" name="LiczbaBiletow" placeholder="Liczba Biletów" value="<?php echo $rezerwacja['LiczbaBiletow']; ?>" required><br>
        <input type="submit" name="submit" value="ZAKTUALIZUJ REZERWACJĘ" class="btn btn-success">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
