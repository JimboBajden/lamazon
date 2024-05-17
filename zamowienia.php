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
        if(isset($_SESSION["user"],$_POST["imie"],$_POST["adres"],$_SESSION["metoda"],$_POST["metoda_dostawy"])){
            //$sql = "INSERT INTO `zamuwienie` (`konto_id`, `imie`, `adres`, `metoda_platnosci`, `metoda_dostawy`) VALUES ('{$_SESSION["user"]}', '{$_POST["imie"]}', '{$_POST["adres"]}', '{$_SESSION["metoda"]}', '{$_POST["metoda_dostawy"]}'); ";
            //$connect->query($sql);
            $sql = "SELECT MAX(zamuwienie_id) as wynik FROM `zamuwienie`;";
            $max = $connect->query($sql)->fetch_array();
            //echo $max["wynik"];
            foreach($_SESSION["koszyk"] as $test){
            array_push($tab,$test);
            }
            foreach($tab as $produkt){
                $sql = "INSERT INTO `zamuwienia` (`zaumienie_id`, `produkt_id`, `ilosc`) VALUES ('{$max["wynik"]}', '{$produkt[0]}', '{$produkt[1]}');";
                $connect->query($sql);
            }
        }
        //echo $_SESSION["metoda"];
        /*
        $tab = array();
        foreach($_SESSION["koszyk"] as $test){
            array_push($tab,$test);
        }
        $max = "SELECT MAX(zamuwienie_id) as max FROM zamuwienia ";
        $wynik = $connect->query($max)->fetch_assoc();
        if($wynik["max"] == null)
        {
            $wynik["max"]=1;
        }
        else
        {
            $wynik["max"] = $wynik["max"]+1;
        }
        print_r($wynik);
        foreach($tab as $elements){
            $sql = "INSERT INTO `zamuwienia` (`zamuwienie_id`, `produkt_id`, `ilosc`, `konto_id`) VALUES ('{$wynik["max"]}','{$elements[0]}','{$elements[1]}' ,'{$_SESSION["user"]}');";    
            #echo $sql , "<br>";
            $connect->query($sql);
        }
        $_SESSION["koszyk"]= array();
        $usunKoszyk = "DELETE FROM koszyk WHERE konto_id = {$_SESSION["user"]}";
        $connect->query($usunKoszyk);
        header("Location:landing_page.php");
        */
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