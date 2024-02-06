<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANEL ADMINISTRACYJNY KINA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .body{
            background-color: aliceblue;
        }
        .register-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            color: white;
        }
        .logout-btn {
            position: fixed;
            top: 10px;
            right: 180px;
           
        }
        .container h1{
            padding-top: 20px;
            color: black;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container-fluid"> 
    <h1 class="text-center my-4">PANEL ADMINISTRACYJNY KINA</h1>
    <div class="row mx-2"> 
        <div class="col-12 d-flex justify-content-end mb-3">
            <a href="rejestr.php" class="btn btn-info me-2">Zarejestruj Admina</a>
            <a href="logout.php" class="btn btn-warning">Wyloguj</a>
        </div>
    </div>

    <div class="row mx-2">
        <div class="col-md-2 mb-2">
            <a href="?action=display" class="btn btn-primary w-100 mb-2">Wyświetl Filmy</a>
            <a href="?action=DodajFilm" class="btn btn-success w-100">Dodaj Film</a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="?action=displayClients" class="btn btn-primary w-100 mb-2">Wyświetl Klientów</a>
            <a href="?action=addClient" class="btn btn-success w-100">Dodaj Klienta</a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="?action=displaySaleKino" class="btn btn-primary w-100 mb-2">Wyświetl Sale Kinowe</a>
            <a href="?action=addSaleKino" class="btn btn-success w-100">Dodaj Salę Kinową</a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="?action=displaySeanse" class="btn btn-primary w-100 mb-2">Wyświetl Seanse</a>
            <a href="?action=addSeans" class="btn btn-success w-100">Dodaj Seans</a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="?action=displayRezerwacje" class="btn btn-primary w-100 mb-2">Wyświetl Rezerwacje</a>
            <a href="?action=addRezerwacja" class="btn btn-success w-100">Dodaj Rezerwację</a>
        </div>
    </div>
</div>




        <?php
        session_start();
        include('kino.php');

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location:login.php");
            exit;
        }
       

        $action = $_GET['action'] ?? '';

        
        if ($action == 'display') {
            $query = "SELECT * FROM Filmy";
            $result = mysqli_query($connect, $query);
        
            // Dodajemy nagłówek 'ID' do tabeli
            echo "<table class='table table-striped mt-4'><tr><th>FilmID</th><th>Tytuł</th><th>Reżyser</th><th>Rok Produkcji</th><th>Gatunek</th><th>Czas Trwania</th><th>Akcja</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<tr><td>".$row["FilmID"]."</td>";
                echo "<td>".$row["Tytul"]."</td>";
                echo "<td>".$row["Rezyser"]."</td>";
                echo "<td>".$row["RokProdukcji"]."</td>";
                echo "<td>".$row["Gatunek"]."</td>";
                echo "<td>".$row["CzasTrwania"]."</td>";
                echo "<td>";
                echo "<a href='edit_film.php?id=".$row['FilmID']."' class='btn btn-secondary btn-sm'>Edytuj</a> ";
                echo "<form method='POST' action='delete_film.php' style='display: inline;'>";
                echo "<input type='hidden' name='FilmID' value='".$row['FilmID']."'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Usuń</button>";
                echo "</form>"; 
                echo "<td>";
                echo "</td></tr>";
            }
            echo "</table>";
        } elseif ($action == 'DodajFilm') {
            ?>
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
        < <div class="centrowanie">
                <h2 class="text-center mb-4">Dodaj Film</h2>
                <form action="add_film.php" method="POST">
                    <input type="text" name="Tytul" placeholder="Tytuł" class="form-control" required>
                    <input type="text" name="Rezyser" placeholder="Nazwisko rezysera" class="form-control" required>
                    <input type="number" name="RokProdukcji" placeholder="Rok Produkcji" class="form-control" required>
                    <input type="text" name="Gatunek" placeholder="Gatunek " class="form-control" required>
                    <input type="number" name="CzasTrwania" placeholder="Czas trwania w minutach " class="form-control" required>
                    <input type="submit" name="add" value="DODAJ FILM" class="btn btn-success w-100">
                </form>
            </div>
            <?php
        } elseif ($action == 'displayClients') {
            $query = "SELECT * FROM Klienci";
            $result = mysqli_query($connect, $query);
        
            echo "<table class='table table-striped mt-4'>";
            echo "<tr><th>KlientID</th><th>Imie</th><th>Nazwisko</th><th>Email</th><th>Telefon</th><th>Akcja</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row["KlientID"]."</td>";
                echo "<td>".$row["Imie"]."</td>";
                echo "<td>".$row["Nazwisko"]."</td>";
                echo "<td>".$row["Email"]."</td>";
                echo "<td>".$row["Telefon"]."</td>";
                echo "<td>";
                echo "<a href='edit_clients.php?id=".$row['KlientID']."' class='btn btn-secondary btn-sm'>Edytuj</a> ";
                echo "<form method='POST' action='delete_client.php' style='display: inline;'>";
                echo "<input type='hidden' name='KlientID' value='".$row['KlientID']."'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Usuń</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
         elseif ($action == 'addClient') {
            ?>
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
            <div class="centrowanie">
                <h2 class="text-center mb-4">Dodaj Klienta</h2>
                <form action="add_client.php" method="POST">
                    <input type="text" name="Imie" placeholder="Imię Klienta" class="form-control" required>
                    <input type="text" name="Nazwisko" placeholder="Nazwisko Klienta" class="form-control" required>
                    <input type="text" name="Email" placeholder="Email Klienta" class="form-control" required>
                    <input type="text" name="Telefon" placeholder="Telefon Klienta" class="form-control" required>
                    <input type="submit" name="add" value="DODAJ KLIENTA" class="btn btn-success w-100">
                </form>
            </div>
            <?php
        }elseif ($action == 'displaySaleKino') {
            $query = "SELECT * FROM SaleKino";
            $result = mysqli_query($connect, $query);
        
            echo "<table class='table table-striped mt-4'><tr><th>SalaID</th><th>NumerSali</th><th>LiczbaMiejsc</th><th>Akcja</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row["SalaID"]."</td>";
                echo "<td>".$row["NumerSali"]."</td>";
                echo "<td>".$row["LiczbaMiejsc"]."</td>";
                echo "<td><a href='edit_sale.php?id=".$row['SalaID']."' class='btn btn-secondary btn-sm'>Edytuj</a> ";
                echo "<form method='POST' action='delete_sale.php' style='display: inline;'>";
                echo "<input type='hidden' name='SalaID' value='".$row['SalaID']."'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Usuń</button>";
                echo "</form>";
                echo "</td></tr>";    
            }
            echo "</table>";
        } elseif ($action == 'addSaleKino') {
            ?>
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
             <div class="centrowanie">
                <h2 class="text-center mb-4">Dodaj Sale</h2>
                <form action="add_sale.php" method="POST">
                    <input type="number" name="NumerSali" placeholder="Numer sali" class="form-control" required>
                    <input type="number" name="LiczbaMiejsc" placeholder="Liczba miejsc" class="form-control" required>
                    <input type="submit" name="add" value="DODAJ SALE" class="btn btn-success w-100">
                </form>
            </div>
            <?php
        }
        elseif ($action == 'displaySeanse') {
            $query = "SELECT Seanse.*, Filmy.Tytul, SaleKino.NumerSali FROM Seanse 
                      JOIN Filmy ON Seanse.FilmID = Filmy.FilmID 
                      JOIN SaleKino ON Seanse.SalaID = SaleKino.SalaID";
            $result = mysqli_query($connect, $query);
        
            echo "<table class='table table-striped mt-4'><tr><th>SeansID</th><th>Film</th><th>Sala</th><th>Data Seansu</th><th>Akcja</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row["SeansID"]."</td>";
                echo "<td>".$row["Tytul"]."</td>";
                echo "<td>".$row["NumerSali"]."</td>";
                echo "<td>".$row["DataSeansu"]."</td>";
                echo "<td><a href='edit_seans.php?id=".$row['SeansID']."' class='btn btn-secondary btn-sm'>Edytuj</a> ";
                echo "<form method='POST' action='delete_seans.php' style='display: inline;'>";
                echo "<input type='hidden' name='SeansID' value='".$row['SeansID']."'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Usuń</button>";
                echo "</form>";
                echo "</td></tr>"; 
            }
            echo "</table>";
        } elseif ($action == 'addSeans') {
            ?>
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
                select {
                    max-width: 300px;
                    margin-top: 50px;
                    width: 50%; 
                    margin: 0 auto; 
                }
            </style>
            <div class="centrowanie">
                <form action="add_seans.php" method="POST">
                <h2 class="text-center mb-4">Dodaj Seans</h2>
                    <select name="FilmID" class="form-control" required>
                        <?php
                        $films = mysqli_query($connect, "SELECT * FROM Filmy");
                        while($film = mysqli_fetch_assoc($films)) {
                            echo "<option value='".$film['FilmID']."'>".$film['Tytul']."</option>";
                        }
                        ?>
                    </select><br>
                    <select name="SalaID" class="form-control" required>
                        <?php
                        $sale = mysqli_query($connect, "SELECT * FROM SaleKino");
                        while($sala = mysqli_fetch_assoc($sale)) {
                            echo "<option value='".$sala['SalaID']."'>".$sala['NumerSali']."</option>";
                        }
                        ?>
                        
                    </select><br>
                    
                    <input type="datetime-local" name="DataSeansu" placeholder="Data Seansu" class="form-control" required>
                    <input type="submit" name="add" value="DODAJ SEANS" class="btn btn-success w-100">
            
                
            </div>
            <?php
        }
        elseif ($action == 'displayRezerwacje') {
            $query = "SELECT Rezerwacje.*, Klienci.Imie, Klienci.Nazwisko, Filmy.Tytul, Seanse.DataSeansu, SaleKino.NumerSali 
                      FROM Rezerwacje 
                      JOIN Klienci ON Rezerwacje.KlientID = Klienci.KlientID 
                      JOIN Seanse ON Rezerwacje.SeansID = Seanse.SeansID 
                      JOIN Filmy ON Seanse.FilmID = Filmy.FilmID 
                      JOIN SaleKino ON Seanse.SalaID = SaleKino.SalaID";
            $result = mysqli_query($connect, $query);
        
            echo "<table class='table table-striped mt-4'><tr><th>RezerwacjaID</th><th>Klient</th><th>Film</th><th>Sala</th><th>Data Seansu</th><th>Liczba Biletów</th><th>Data Rezerwacji</th><th>Akcja</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row["RezerwacjaID"]."</td>";
                echo "<td>".$row["Imie"]." ".$row["Nazwisko"]."</td>";
                echo "<td>".$row["Tytul"]."</td>";
                echo "<td>".$row["NumerSali"]."</td>";
                echo "<td>".$row["DataSeansu"]."</td>";
                echo "<td>".$row["LiczbaBiletow"]."</td>";
                echo "<td>".$row["DataRezerwacji"]."</td>";
                echo "<td><a href='edit_rezerwacje.php?id=".$row['RezerwacjaID']."' class='btn btn-secondary btn-sm'>Edytuj</a> ";
                echo "<form method='POST' action='delete_rezerwacje.php' style='display: inline;'>";
                echo "<input type='hidden' name='RezerwacjaID' value='".$row['RezerwacjaID']."'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Usuń</button>";
                echo "</form>";
                echo "</td></tr>";      
            }
            echo "</table>";
        } elseif ($action == 'addRezerwacja') {
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
                <input type="submit" name="add" value="DODAJ REZERWACJĘ" class="btn btn-success w-100">
            </form>
        </div>
            <?php
        }
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>