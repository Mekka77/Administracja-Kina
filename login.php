<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie Administratora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 50px; }
        .container { max-width: 400px; }
        .form-signin { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Logowanie</h2>
    <div class="row justify-content-center">
        <div class="col">
            <form method="post" action="login_schema.php" class="form-signin">
                <div class="mb-3">
                    <label for="NazwaUzytkownika" class="form-label">Nazwa Użytkownika:</label>
                    <input type="text" id="NazwaUzytkownika" name="NazwaUzytkownika" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="Haslo" class="form-label">Hasło:</label>
                    <input type="password" id="Haslo" name="Haslo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Zaloguj</button>
            </form>
            <div class="mt-4 text-center">
                <a href="guest_view.php" class="btn btn-secondary w-100">Przeglądaj jako gość</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
