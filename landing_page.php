<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamazon</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="css2.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<?php 
    $connect=@new mysqli('localhost','root','','lamazon');
    session_start();
    
?>
<body>
    <div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <div class="cards">
    <?php 
        $query1 = "SELECT * FROM kategoria LEFT JOIN img USING(img_id)";
        $result=$connect->query($query1);
        while($row=$result->fetch_assoc()){
            echo"<a href='products_page.php?kategoria={$row['kategoria_id']}'>";
            $tmp = $row["url"];
            if($tmp == null){
                $tmp = "temp_img.jpg";
            }
            echo "<div class='card' id ='{$row["nazwa"]}' onclick =sending('{$row["nazwa"]}') style='background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)) , url(imgs/{$tmp});'>";
            echo "<p class='category_name'>{$row["nazwa"]}</p>";
            echo "</div>";
            echo "</a>";
            
        }
    ?>
    </div> 
</body>
</html> 
