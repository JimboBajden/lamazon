<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css2.css">
    <link rel="stylesheet" href="css3.css">
    <link rel="stylesheet" href="navbar.css">

</head>
<body>
    <?php 
    session_start();                    
    $connect=@new mysqli('localhost','root','','lamazon');
    if(!isset($_SESSION["koszyk"])){
        $_SESSION["koszyk"] = array();
    }
        $produkty = array();
        foreach($_SESSION["koszyk"] as $test){
            array_push($produkty,$test[0]);
        }
        
    if(isset($_POST["id"])){
        if(!in_array($_POST["id"],$produkty)){
            array_push($_SESSION["koszyk"] , array($_POST["id"],$_POST["ilosc"]));
            if(isset($_SESSION["user"])){
            $dodawanie = "INSERT INTO `koszyk` (`konto_id`, `produkt_id`,`ilosc`) VALUES ('{$_SESSION["user"]}', '{$_POST["id"]}','{$_POST["ilosc"]}')";
            $connect->query($dodawanie);
        }
        }
        echo "greg0";
        if($_POST["ilosc"] != $_SESSION["koszyk"][array_search($_POST["id"],$produkty)][1]){
            $_SESSION["koszyk"][array_search($_POST["id"],$produkty)][1] = $_POST["ilosc"];
            echo "greg";
        }
        }
        print_r($_SESSION);
   
    ?>
    <div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <center>
        <div class="box">
            <div class = "wraper">
                <?php    
                    $query1="SELECT * FROM `produkt` LEFT join `img` using(`img_id`) WHERE `produkt_id` = {$_GET['produkt']}";
                    $resoult = $connect->query($query1);
                    $row = $resoult->fetch_assoc();
                    echo "<img class='previev' src='imgs/{$row["url"]}'>";
                    echo "<h1 class='nazwa'>{$row["nazwa"]}</h1>";
                ?>
                    <div class="opcje">
                        <div>
                            <?php
                                if(!is_null($row["promocja"])){
                                    $promocja = $row["cena"]-(($row["promocja"]/100)*$row["cena"]);
                                    number_format($promocja,2);
                                    echo "<h1 class='nowa'>{$promocja} zł</h1>";
                                    echo "<h2 class='stara'>{$row["cena"]} zł</h2>";
                                }else{
                                    echo "<h1 class='stara'>{$row["cena"]} zł</h1>";
                                }
                            ?>
                            <style>
                                .stara{
                                    text-decoration: line-through;
                                }
                                .nowa{
                                    color: red;

                                }
                            </style>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="id" value=" <?php echo $row["produkt_id"] ?>">
                            <input type="number" name="ilosc" min="1" value="1" max = <?php echo $row["ilosc"]; ?>>
                            <input type="submit" value="dodaj do koszyka">    
                        </form>
                    </div>
            </div>
            <?php    
                echo "<p>{$row["opis"]}</p>"
            ?>
        </div>
    </center>
</body>
</html>