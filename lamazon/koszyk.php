<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css2.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <?php
    session_start();
    //echo "<pre>";
    //var_dump($_SESSION);
    //echo "</pre>";
    $connect=@new mysqli('localhost','root','','lamazon');
        
    if(isset($_GET["usun"])){
        if(isset($_SESSION["user"]) && $_SESSION["user"] != ""){
            $usuwanie = "DELETE FROM koszyk WHERE produkt_id = {$_GET["produkt_id"]} AND konto_id = {$_SESSION["user"]}";
            $connect->query($usuwanie);
        }
        
        $kopia = array();
        foreach($_SESSION["koszyk"] as $item){
            if($item[0] != $_GET["produkt_id"]){
                array_push($kopia,$item);
            }
        }
        $_SESSION["koszyk"] = $kopia;
    }    
    $tab = array();
    foreach($_SESSION["koszyk"] as $test){
        array_push($tab,$test[0]);
    }
    $test = implode(",",$tab);
    if($test != ""){
        $sql = "SELECT * FROM `produkt` LEFT JOIN img USING(img_id) WHERE produkt_id IN ({$test})";   
    }else{
        $sql = "SELECT * FROM `produkt` LEFT JOIN img USING(img_id) WHERE produkt_id = null";
    }
    $zapytane = $connect->query($sql);

    if(isset($_GET["zmien"])){
        $index = array_search($_GET["id"],$tab);
        $_SESSION["koszyk"][$index][1] = $_GET["ilosc"];
    }
    #print_r($_SESSION);
    ?>
    <div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <center>
        <div class="content">
            <div class="items">
                <?php
                    $i=0;
                    while($row=$zapytane->fetch_assoc()){
                    $tmp = $row["url"];
                    if($tmp == null){
                        $tmp = "temp_img.jpg";
                    }   
                    $ilosc = $_SESSION["koszyk"][$i][1];$i++;
                    echo"<form action='' method='get' class='greg'>
                    <img class ='imgery' src='imgs/{$tmp}' alt=''>
                    <div class='elements'>{$row["nazwa"]}</div>
                    <input name='ilosc' type='number'min='1' max ='{$row["ilosc"]}' step='1' value='{$ilosc}'>
                    <input type='hidden' name='id' value='{$row["produkt_id"]}'>
                    <input name='zmien' value='=' type='submit'>
                        </form>";  
                    echo "<form>";
                    echo "<input type='hidden' name='produkt_id' value='{$row["produkt_id"]}'>";
                    echo "<input name='usun' value='usun'  type='submit'>";  
                    echo "</form>";
                }
                ?>
            </div>
            <div class="options">
                <?php
                $suma = 0;
                $i=0;
                echo "<div class='costs'>";
                $zapytane2 = $connect->query($sql);
                 while($greg=$zapytane2->fetch_assoc()){
                    if($greg["ilosc"] == 1){
                        echo "<div>{$greg["cena"]}zł</div>"; 
                    $suma += $greg["cena"];
                    }else{
                        $tmp = $_SESSION["koszyk"][$i][1];$i++;
                        echo "<div>{$greg["cena"]}zł x {$tmp}</div>"; 
                        $suma += ($greg["cena"] * $tmp);
                    }
                    
                }   
                
                echo"</div>";
                echo "<h1>{$suma}zł</h1>";
                ?>
                <form action="zamowienia.php">
                    <?php
                    $produkty = implode(",",$tab);
                    echo "<input type='hidden' name='produkty' value='$produkty'>";
                    ?>
                    <input type="submit" value="przejdz do finalizajci zakupu">
                </form>
            </div>
        </div>
        <input type="submit">
    </center>
</body>
</html>