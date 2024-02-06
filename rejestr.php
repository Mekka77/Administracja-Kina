<?php


include('kino.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwaUzytkownika = mysqli_real_escape_string($connect, $_POST['NazwaUzytkownika']);
    $haslo = $_POST['Haslo']; 

    $sql = "INSERT INTO Administratorzy (NazwaUzytkownika, Haslo) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $nazwaUzytkownika, $haslo);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Administrator zarejestrowany pomyślnie";
        } else {
            echo "Błąd: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Błąd: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja Administratora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }
        .container {
            max-width: 400px;
        }
        .form-signin {
            margin: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Rejestracja Administratora</h2>
    <div class="row justify-content-center">
        <div class="col">
            <form method="post" action="rejestr.php" class="form-signin">
                <div class="mb-3">
                    <label for="NazwaUzytkownika" class="form-label">Nazwa Użytkownika:</label>
                    <input type="text" id="NazwaUzytkownika" name="NazwaUzytkownika" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="Haslo" class="form-label">Hasło:</label>
                    <input type="password" id="Haslo" name="Haslo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Zarejestruj</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

