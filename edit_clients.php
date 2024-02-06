<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klientID = intval($_POST['KlientID']);
    $imie = mysqli_real_escape_string($connect, strip_tags($_POST['Imie']));
    $nazwisko = mysqli_real_escape_string($connect, strip_tags($_POST['Nazwisko']));
    $email = mysqli_real_escape_string($connect, strip_tags($_POST['Email']));
    $telefon = mysqli_real_escape_string($connect, strip_tags($_POST['Telefon']));

    $sql = "UPDATE Klienci SET Imie=?, Nazwisko=?, Email=?, Telefon=? WHERE KlientID=?";
    
    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $imie, $nazwisko, $email, $telefon, $klientID);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
            mysqli_stmt_close($stmt);
            header("Location: index.php?action=displayClients");
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
    $klientID = intval($_GET['id']);

    $query = "SELECT * FROM Klienci WHERE KlientID = ?";
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $klientID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $klient = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Klienta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edytuj klienta:</h2>
    <form action="edit_clients.php" method="POST">
        <input type="hidden" name="KlientID" value="<?php echo $klient['KlientID']; ?>"><br>
        <input type="text" name="Imie" placeholder="Imię Klienta" value="<?php echo $klient['Imie']; ?>" required><br>
        <input type="text" name="Nazwisko" placeholder="Nazwisko Klienta" value="<?php echo $klient['Nazwisko']; ?>" required><br>
        <input type="text" name="Email" placeholder="Email Klienta" value="<?php echo $klient['Email']; ?>" required><br>
        <input type="text" name="Telefon" placeholder="Telefon Klienta" value="<?php echo $klient['Telefon']; ?>" required><br>
        <input type="submit" name="submit" value="ZAKTUALIZUJ KLIENTA" class="btn btn-success">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
