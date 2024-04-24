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
        #print_r($tab);
        $max = "SELECT MAX(zamuwienie_id) as max FROM zamuwienia ";
        $wynik = $connect->query($max)->fetch_assoc();
        if($wynik["max"] == null){$wynik["max"]=1;}
        print_r($wynik);
        foreach($tab as $elements){
            $sql = "INSERT INTO `zamuwienia` (`zamuwienie_id`, `produkt_id`, `ilosc`, `konto_id`) VALUES ('{$wynik["max"]}','{$elements[0]}','{$elements[1]}' ,'1');";    
            #echo $sql , "<br>";
            $connect->query($sql);
        }
    ?>
</div>
</body>
</html>