<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lamazon</title>
    <link rel="stylesheet" href="css2.css">
    <link rel="stylesheet" href="navbar.css">
    <script src="javascript.js"></script>
</head>
<body>
    <?php 
    session_start();
    print_r($_SESSION);
    ?>
    <div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <div class="things">
        <?php 
            $connect=@new mysqli('localhost','root','','lamazon');
            $inquery = "SELECT * FROM `produkt`LEFT JOIN img USING(img_id) WHERE kategoria_id = {$_GET['kategoria']} ";
            $result=$connect->query($inquery);
            while($row=$result->fetch_assoc()){
                echo"<a href='product_page.php?produkt={$row["produkt_id"]}'>";
                echo "<div class='item' onclick = sending('{$row["produkt_id"]}') ><p>{$row["nazwa"]}</p>";
                $tmp = $row["url"];
                    if($tmp == null){
                $tmp = "temp_img.jpg";
                }
                echo "<img class ='backround' src='imgs/{$tmp}' alt=''>";
                echo "</div>";
                echo "</a>";
            }
        ?>
        </div>
</body>
</html>