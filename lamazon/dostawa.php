<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $connect=@new mysqli('localhost','root','','lamazon');
    session_start();    
?>
    <h1>zamówienia</h1>
    <?php
        if(isset($_GET["status"],$_GET["id"]) ){
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

        $sql = "SELECT * FROM `zamuwienie` ";
        $result=$connect->query($sql);
        while($row = $result->fetch_assoc()){
            echo "<form  class = 'elementy'> 
            <input type='hidden' name='id' value = '{$row["zamuwienie_id"]}'>
            <span>imie: {$row["imie"]}    ,
            </span>  <span> adres : {$row["adres"]}   , </span> 
                <span> metoda płatności {$row["metoda_platnosci"]}     ,</span>
                <span> metoda dostawy :{$row["metoda_dostawy"]}    ,</span> 
                <span> status dostawy,{$row["status"]}</span>";
            if($row["status"] == "przygotowywany"){
                echo "<input type='submit' name='status' value='wyślij'>";
            }elseif($row["status"] == "wysłany"){
                echo "<input type='submit' name='status' value='potwierdz'>";
            }else{
                echo "<span>dostarczone</span>";
            }

            echo"</form>";
        }
    ?>
    <style>
        .elementy > span{
            border: 1px solid black;
        }
    </style>
</body>
</html>