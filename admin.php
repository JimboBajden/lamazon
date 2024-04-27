<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="landing_page.php"><img src="Lamazoon (1).png" alt="" style="height: 100px;"></a>
    <form action="" method="GET">
        <input name="wyloguj" value="wyloguj sie" type="submit">
    </form>
    <?php        
        session_start();
        $connect=@new mysqli('localhost','root','','lamazon');
        print_r($_SESSION);
        if(isset($_GET["wyloguj"])){
            unset($_SESSION["user"]);
            header('Location: landing_page.php');
        }
    ?>
    <?php
    #kategoria
    if(isset($_POST["nkategoria"])){
        $add = "INSERT INTO `kategoria` (`nazwa`, `img_id`) VALUES ('{$_POST["nkategoria"]}', {$_POST["img"]})";
        echo $add;
        $connect->query($add);
    }
    ?>
    <?php
    #produkt
    if(isset($_POST["pnazwa"])){
        $add= "INSERT INTO `produkt` (`nazwa`, `opis`, `cena`, `kategoria_id`, `img_id`, `ilosc`) VALUES ( '{$_POST["pnazwa"]}', '{$_POST["opis"]}', '{$_POST["cena"]}', {$_POST["kategoria"]}, {$_POST["img"]}, '{$_POST["ilosc"]}')";
        echo $add;
        $connect->query($add);
    }
    ?>
    <?php 
    #ilosc
        if(isset($_POST["zprodukt"])){
            $update = "UPDATE `produkt` SET `ilosc` = {$_POST["ilosc"]} WHERE `produkt`.`produkt_id` = {$_POST["zprodukt"]} ";
            echo $update;
            $connect->query($update);
        }
    ?>
     
<?php
#przesyłanie plików
if(isset($_POST["wyslane"])){
$target_dir = "imgs/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo '<script>alert("File is not an image.")</script>';
        $uploadOk = 0;
    }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo '<script>alert("Sorry, file already exists.")</script>';
        
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo '<script>alert("Sorry, your file was not uploaded.")</script>'; 
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $dodawanieUrl= "INSERT INTO `img` (`url`) VALUES ('{$_FILES["fileToUpload"]["name"]}')";
        echo $dodawanieUrl;
        $connect->query($dodawanieUrl);
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo'<script>alert("Sorry, there was an error uploading your file.")</script>';
    }
    }
    
}
?>
<?php
    if(isset($_GET["ukategoria"])){
        $usuwanieK = "DELETE FROM `kategoria` WHERE `kategoria`.`kategoria_id` = '{$_GET["ukategoria"]}' ";
        $connect->query($usuwanieK);
    }
    if(isset($_GET["uprodukt"])){
        $usuwanieP = "DELETE FROM `produkt` WHERE `produkt`.`produkt_id` = '{$_GET["uprodukt"]}' ";
        $connect->query($usuwanieP);
    }
?>
<?php
    if(isset($_GET["uimg"])){
        $usuwanieI = "DELETE FROM `img` WHERE `img`.`img_id` = '{$_GET["uimg"]}' ";
        $connect->query($usuwanieI);
    }
?>

    <div>
        <div class="dodawanie">
            <form class="kategoria" method="post">
                <h1>dodaj kategorie</h1>
                <input type="text" name="nkategoria" placeholder="nazwa kategori">
                <select name="img" id="">obraz
                    <option value="null">null</option>
                <?php
                    $zapytanie = "SELECT * FROM img";
                    $resoult = $connect->query($zapytanie);
                    while($row = $resoult->fetch_assoc()){
                        echo "<option value='{$row["img_id"]}'>{$row["url"]}</option>";
                    }
                ?>
                </select>
                <input type="submit">
            </form>
            <form class="nowe" method="post">
            <h1>dodaj produkt</h1>
                <input type="text" name="pnazwa" placeholder="nazwa produktu">
                <input type="text" name="opis" placeholder="opis produktu">
                <input type="text" name="cena" placeholder="cena produktu">
                <select name="kategoria" placeholder="kategoria produktu" id="">
                    <?php
                    $zapytanie = "SELECT * FROM kategoria";
                    $resoult = $connect->query($zapytanie);
                    while($row = $resoult->fetch_assoc()){
                        echo "<option value='{$row["kategoria_id"]}'>{$row["nazwa"]}</option>";
                    }
                    ?>
                </select>
                <select name="img" id="">
                <option value="null">null</option>
                <?php
                    $zapytanie = "SELECT * FROM img";
                    $resoult = $connect->query($zapytanie);
                    while($row = $resoult->fetch_assoc()){
                        echo "<option value='{$row["img_id"]}'>{$row["url"]}</option>";
                    }
                    ?>
                </select>
                <input type="text" name="ilosc" placeholder="dostępna ilość produktu">
                <input type="submit">
            </form>
            <form method="post">
                <h1>zmień ilosc produktu</h1>
                <select name="zprodukt" id="">
                    <?php
                    $zapytanie1 = "SELECT * FROM `kategoria`";
                    $resoult = $connect->query($zapytanie1);
                    while($kategoria=$resoult->fetch_assoc()){
                        echo "<optgroup label='{$kategoria["nazwa"]}'>";
                        $zapytanie2 = "SELECT produkt_id, produkt.nazwa AS nazwa, kategoria.nazwa AS kategoria FROM produkt JOIN `kategoria` USING(kategoria_id) where kategoria.nazwa = '{$kategoria["nazwa"]}'";
                        echo $zapytanie2;
                        $tmp = $connect->query($zapytanie2);
                        while($produkt=$tmp->fetch_assoc()){
                            echo "<option value='{$produkt["produkt_id"]}'>{$produkt["nazwa"]}</option>";
                        }
                        echo"</optgroup>";
                    }
                    ?>
                </select>
                <input type="text" name="ilosc" placeholder="nowa ilosc">
                <input type="submit">
            </form>
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Prześlij zdjęcie</h1>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="hidden" name="wyslane" value="1">
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
        <div class="odejmowanie">
            <form action="">
                <h1>usuń kategorie</h1>
                <select name="ukategoria" id="">
                    <?php
                        $resoult = $connect->query($zapytanie1);
                        while($kategoria=$resoult->fetch_assoc()){
                            echo "<option value='{$kategoria["kategoria_id"]}'>{$kategoria["nazwa"]}</option>";
                        }
                    ?>
                </select>
                <input type="submit">
            </form>
            <form action="">
                <h1>usuń produkt</h1>
                <select name="uprodukt" id="">
                <?php
                    $zapytanie1 = "SELECT * FROM `kategoria`";
                    $resoult = $connect->query($zapytanie1);
                    while($kategoria=$resoult->fetch_assoc()){
                        echo "<optgroup label='{$kategoria["nazwa"]}'>";
                        $zapytanie2 = "SELECT produkt_id, produkt.nazwa AS nazwa, kategoria.nazwa AS kategoria FROM produkt JOIN `kategoria` USING(kategoria_id) where kategoria.nazwa = '{$kategoria["nazwa"]}'";
                        echo $zapytanie2;
                        $tmp = $connect->query($zapytanie2);
                        while($produkt=$tmp->fetch_assoc()){
                            echo "<option value='{$produkt["produkt_id"]}'>{$produkt["nazwa"]}</option>";
                        }
                        echo"</optgroup>";
                    }
                    ?>
                    </select>
                    <input type="submit">
            </form>
            <form action="">
                <h1>usuń img</h1>
                <select name="uimg" id="">
                    <?php 
                    $zapytanie3 = "SELECT * FROM `img` ";
                    $resoult = $connect->query($zapytanie3);
                    while($row=$resoult->fetch_assoc()){
                        echo "<option value='{$row["img_id"]}'>{$row["url"]}</option>";
                    }
                    ?>
                    <input type="submit">
                </select>
            </form>
        </div>
    </div>
    
</body>
</html>