<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        $connect=@new mysqli('localhost','root','','lamazon');
        $_SESSION["metoda"]=$_GET["metoda"];
        $max=null;$tab = array();
        //array_push($_SESSION["koszyk"],array(1,5));
        //print_r($_SESSION["koszyk"]);
        if(isset($_SESSION["user"],$_POST["imie"],$_POST["adres"],$_SESSION["metoda"],$_POST["metoda_dostawy"])){
            $sql = "INSERT INTO `zamuwienie` (`konto_id`, `imie`, `adres`, `metoda_platnosci`, `metoda_dostawy`) VALUES ('{$_SESSION["user"]}', '{$_POST["imie"]}', '{$_POST["adres"]}', '{$_SESSION["metoda"]}', '{$_POST["metoda_dostawy"]}'); ";
            $connect->query($sql);
            $id = $connect->insert_id;
            echo $id;
            $newArray = array(); 

           foreach($_SESSION["koszyk"] as $key => $test) {
               $sql = "SELECT * FROM produkt WHERE produkt_id = {$test['0']}";
               $tmp = $connect->query($sql)->fetch_assoc();
           
               if(!is_null($tmp)){
                   $newArray[$key] = $test;  
               }
           }
            $_SESSION["koszyk"] = $newArray;

            foreach($_SESSION["koszyk"] as $produkt){
                
                $sql = "INSERT INTO `zamuwienia` (`zamuwienie_id`, `produkt_id`, `ilosc`) VALUES ('{$id}', '{$produkt[0]}', '{$produkt[1]}');";
                $connect->query($sql);
                $sql = "UPDATE `produkt` SET `ilosc` = `ilosc` - '{$produkt[1]}' WHERE `produkt`.`produkt_id` = '{$produkt[0]}';";
                $connect->query($sql);
            }
            unset($_SESSION["koszyk"]);
            unset($_SESSION["metoda"]);
            header('Location: landing_page.php');
            //erm what the sigma
        }
    ?>
    <form action="" method="post">
        <input type="text" name="imie" required placeholder="imie twe">
        <input type="text" name="adres" required placeholder="adress">
        <select  required name="metoda_dostawy" id="">
            <option value="paczkomat">paczkomat</option>
            <option value="kurier">kurier</option>
            <option value="teleporter">teleporter</option>
        </select>
        <input type="submit" value="zamów">
    </form>
</div>
</body>
</html>