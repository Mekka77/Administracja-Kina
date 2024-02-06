<?php
include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salaID = intval($_POST['SalaID']);
    $numerSali = mysqli_real_escape_string($connect, strip_tags($_POST['NumerSali']));
    $liczbaMiejsc = intval($_POST['LiczbaMiejsc']);

    $sql = "UPDATE SaleKino SET NumerSali=?, LiczbaMiejsc=? WHERE SalaID=?";
    
    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "sii", $numerSali, $liczbaMiejsc, $salaID);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
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

if (isset($_GET['id'])) {
    $salaID = intval($_GET['id']);

    $query = "SELECT * FROM SaleKino WHERE SalaID = ?";
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $salaID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $sala = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Salę Kinową</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edytuj salę kinową:</h2>
    <form action="edit_sale.php" method="POST">
        <input type="hidden" name="SalaID" value="<?php echo $sala['SalaID']; ?>"><br>
        <input type="text" name="NumerSali" placeholder="Numer Sali" value="<?php echo $sala['NumerSali']; ?>" required><br>
        <input type="number" name="LiczbaMiejsc" placeholder="Liczba Miejsc" value="<?php echo $sala['LiczbaMiejsc']; ?>" required><br>
        <input type="submit" name="submit" value="ZAKTUALIZUJ SALĘ" class="btn btn-success">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
