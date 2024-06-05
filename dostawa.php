<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php
    $connect=@new mysqli('localhost','root','','lamazon');
    session_start();    
    if($_SESSION["user"] == "" || !isset($_SESSION["user"])){
        header('Location: landing_page.php');
    }
?>
<div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <form method='GET'>
                <input name='wyloguj' value='wyloguj sie' type='submit'>
            </form>
    <h1>zamówienia</h1>
    <?php
        if(isset($_GET["wyloguj"])){
            unset($_SESSION["user"]);
            header('Location: landing_page.php');
        }
        $sql = "SELECT * FROM `konta` WHERE konto_id = {$_SESSION["user"]}";
        $admin = $connect->query($sql)->fetch_assoc();
        if(isset($_GET["status"],$_GET["id"]) && $admin["admin"] == 1){
            echo $_GET["status"],$_GET["id"];
            $sql = "SELECT * FROM `zamuwienie` WHERE zamuwienie_id = {$_GET['id']} ";
            $check = $connect->query($sql)->fetch_assoc();
            if($check["status"] == "przygotowywany"){
                $sql = "UPDATE `zamuwienie` SET `status` = 'wysłany' WHERE `zamuwienie`.`zamuwienie_id` = {$_GET['id']};";
                $connect->query($sql);
                echo "pp";
            }elseif($check["status"] == "wysłany"){
                $sql = "UPDATE `zamuwienie` SET `status` = 'odebrane' WHERE `zamuwienie`.`zamuwienie_id` = {$_GET['id']};";
                $connect->query($sql);
            }
            
        }
        ?>
        <div class='grid-container'>
            <span class='grid-item'>imie</span>
            <span class='grid-item'>adres</span>
            <span class='grid-item'>metoda płatności</span>
            <span class='grid-item'>metoda dostawy</span>
            <span class='grid-item'>status</span>
            <span class='grid-item'>przycisk</span>
        </div>
        <?php
        if($admin["admin"] != 1){
            $sql = "SELECT * FROM `zamuwienie` WHERE konto_id = {$_SESSION["user"]}";    
        }else{
            $sql = "SELECT * FROM `zamuwienie`";    
        }
        $result=$connect->query($sql);
       
        while($row = $result->fetch_assoc()){
            
                
            echo "<div class='grid-container'>
                <form  class = 'elementy'> 
                
                <input type='hidden' name='id' value = '{$row["zamuwienie_id"]}'>
                <span class='grid-item'>{$row["imie"]}</span>
                <span class='grid-item'>{$row["adres"]} </span> 
                <span class='grid-item'>{$row["metoda_platnosci"]}</span>
                <span class='grid-item'>{$row["metoda_dostawy"]}</span> 
                <span class='grid-item'>{$row["status"]}</span>";
            if($row["status"] == "przygotowywany"){
                echo "<input class='grid-item' type='submit' name='status' value='wyślij'>";
            }elseif($row["status"] == "wysłany"){
                echo "<input class='grid-item' type='submit' name='status' value='potwierdz'>";
            }else{
                echo "<span class='grid-item'>dostarczone</span>";
            }
            $sql = "SELECT SUM(produkt.cala_cena*zamuwienia.ilosc) as wynik FROM `zamuwienia` JOIN produkt USING(produkt_id) WHERE zamuwienie_id = {$row["zamuwienie_id"]}; ";
            $wynik = $connect->query($sql)->fetch_assoc();
            $cena = $wynik["wynik"];
            echo "<span class='grid-item'>cena: {$cena}</span>";
            
            echo"</form>";

            echo "<form action='faktura.php'>
                <input type='hidden' name='id' value = '{$row["zamuwienie_id"]}'>
                <input type='submit' value = 'faktura'>
            </form>
            </div>";
        }
    ?>
    <style>
        .grid-container {
            display: flex;
            flex-direction: row;
            gap: 10px;
            width: 100%;
        }

        .grid-item {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 1.5em;
            border-radius: 5px;
        }
        .plz{
            border: 1px solid black;
        }
    </style>
</body>
</html>