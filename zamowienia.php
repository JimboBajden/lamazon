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
    ?>
</div>
</body>
</html>