<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przeglądanie jako gość</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .body { background-color: aliceblue; }
        .container h1 { padding-top: 20px; color: black; font-family: Arial, Helvetica, sans-serif; font-weight: 600; }
    </style>
</head>
<body>
<div class="container-fluid"> 
    <h1 class="text-center my-4">KINO</h1>
    <div class="row mx-2"> 
        <div class="col-12 d-flex justify-content-end mb-3">
            <a href="logout.php" class="btn btn-warning">Wyjście</a>
        </div>
    </div>
    <div class="row mx-2"> 
        <div class="col-md-2 mb-2">
        <a href="?action=display" class="btn btn-primary w-100 mb-2">Filmy</a>
        <a href="?action=displaySeanse" class="btn btn-primary w-100 mb-2">Seanse</a>
        <a href="?action=addRezerwacja" class="btn btn-success w-100">Kup bilet</a>
        </div>
    </div>

    <?php

    include('kino.php'); 
    $action = $_GET['action'] ?? '';
    if ($action == 'display') 
    {
        
        $query = "SELECT * FROM Filmy";
        $result = mysqli_query($connect, $query);
        
        if ($result) {
            echo "<table class='table table-striped mt-4'><tr><th>Tytuł</th><th>Reżyser</th><th>Rok Produkcji</th><th>Gatunek</th><th>Czas Trwania</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<td>".$row["Tytul"]."</td>";
                echo "<td>".$row["Rezyser"]."</td>";
                echo "<td>".$row["RokProdukcji"]."</td>";
                echo "<td>".$row["Gatunek"]."</td>";
                echo "<td>".$row["CzasTrwania"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Błąd podczas wyświetlania danych: " . mysqli_error($connect);
        }
       
    }elseif ($action == 'displaySeanse') {
        $query = "SELECT Seanse.*, Filmy.Tytul, SaleKino.NumerSali FROM Seanse 
                  JOIN Filmy ON Seanse.FilmID = Filmy.FilmID 
                  JOIN SaleKino ON Seanse.SalaID = SaleKino.SalaID";
        $result = mysqli_query($connect, $query);
    
        echo "<table class='table table-striped mt-4'><tr><th>Film</th><th>Sala</th><th>Data Seansu</th><th>Akcja</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row["SeansID"]."</td>";
            echo "<td>".$row["Tytul"]."</td>";
            echo "<td>".$row["NumerSali"]."</td>";
            echo "<td>".$row["DataSeansu"]."</td>";
        }
        echo "</table>";
    }elseif ($action == 'addRezerwacja') {
        ?>
    <div class="centrowanie">
    <h2 class="text-center mb-4">Dodaj Rezerwacje</h2>
        <style>
            .centrowanie {
                max-width: 300px;
                margin-top: 50px;
                width: 50%; 
                margin: 0 auto; 
            }
            .form-control {
                margin-bottom: 10px;
            }
        </style>
        
        <form action="add_rezerwacje.php" method="POST">
            <select name="KlientID" class="form-control" required>
                <?php
                $klienci = mysqli_query($connect, "SELECT * FROM Klienci");
                while($klient = mysqli_fetch_assoc($klienci)) {
                    echo "<option value='".$klient['KlientID']."'>".$klient['Imie']." ".$klient['Nazwisko']."</option>";
                }
                ?>
            </select><br>
            
            <select name="SeansID" placeholder="" class="form-control" required>
                <?php
                $seanse = mysqli_query($connect, "SELECT Seanse.*, Filmy.Tytul FROM Seanse JOIN Filmy ON Seanse.FilmID = Filmy.FilmID");
                while($seans = mysqli_fetch_assoc($seanse)) {
                    echo "<option value='".$seans['SeansID']."'>".$seans['Tytul']." - ".$seans['DataSeansu']."</option>";
                }
                ?>
            </select><br>
            <input type="number" name="LiczbaBiletow" placeholder="Liczba Biletów" class="form-control"required><br>
            <input type="submit" name="add" value="KUP BILET" class="btn btn-success w-100">
        </form>
    </div>
        <?php
    }
    ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
