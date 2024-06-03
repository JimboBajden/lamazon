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
        $connect=@new mysqli('localhost','root','','lamazon');
        session_start();
        #print_r($_SESSION);
        /*
        $zgred = password_hash("skibidi",PASSWORD_DEFAULT);
        $test = "skibidii";
        if (password_verify($test, $zgred)) {
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }
        */
        if(isset($_COOKIE["error"])){
            echo $_COOKIE["error"];
            unset($_COOKIE);
        }

        if(isset($_SESSION["user"]) && $_SESSION["user"] != ""){
            echo"<form method='GET'>
                <input name='wyloguj' value='wyloguj sie' type='submit'>
            </form>'";
            if(isset($_GET["wyloguj"])){
                unset($_SESSION["user"]);
            }
        }
        if(isset($_SESSION["user"]) && $_SESSION["user"] != ""){
            $zapytanie = "SELECT * FROM `konta` where konto_id = {$_SESSION["user"]} ";
            $check = $connect->query($zapytanie)->fetch_assoc();
            if($check["admin"] == true){
                header('Location: admin.php');
            }
        }
        

        if(isset($_POST['name'])){    

        $querry2 = "SELECT COUNT(*) AS wynik FROM `konta` WHERE nazwa = '{$_POST["name"]}' ";
        $resoult = $connect->query($querry2);
        $row=$resoult->fetch_assoc();

        $querry1 = "SELECT * FROM `konta` WHERE nazwa = '{$_POST["name"]}';";
        $zapytanie = $connect->query($querry1);
        $testRows = $connect->query($querry1)->fetch_assoc();
        if(isset($_POST["register"])){
            if(is_null($row["wynik"] == 0)){
                $sql = "INSERT INTO `konta` (`nazwa`, `haslo`, `email`) VALUES ('{$_POST["name"]}', '{$_POST["password"]}', '{$_POST["email"]}')";
                $connect->query($sql);
            }else{
                setcookie("error", "takie konto już istnieje", time() + 30 , "/");
                header('Location: login.php');
            }
        } 
        if($row["wynik"] == 1 ){
            if($_POST["name"] == $testRows["nazwa"] && $_POST["password"] == $testRows["haslo"] && $_POST["email"] == $testRows["email"]){
                $_SESSION["user"] = $testRows["konto_id"];
                $doKoszyka = "SELECT * FROM `koszyk` WHERE konto_id = {$testRows["konto_id"]}";
                $_SESSION["koszyk"] = array();            
                $tablica = array();
                $zapytanie3 = $connect->query($doKoszyka);
                $i=0;
                while($dane = $zapytanie3->fetch_assoc()){
                    $tablica[$i][0]=$dane["produkt_id"];
                    $tablica[$i][1]=$dane["ilosc"];
                    $i++;
                }
                $_SESSION["koszyk"] = $tablica;
                
                $zapytanie = "SELECT * FROM `konta` where konto_id = {$_SESSION["user"]} ";
                $check = $connect->query($zapytanie)->fetch_assoc();
                if( $check["admin"] == true){
                    header('Location: admin.php');
                }
                else{
                    header('Location: landing_page.php');
                }
            }else{
                setcookie("error", "złe dane logowania", time() + 30 , "/");
                header('Location: login.php');
            }
        }
        
        }
        /*
        if( $testRows["wynik"] == 0){
            $sql = "INSERT INTO `konta` (`nazwa`, `haslo`, `email`) VALUES ('{$_POST["name"]}', '{$_POST["password"]}', '{$_POST["email"]}')";
            $connect->query($sql);
            $idQ = "SELECT konto_id FROM `konta` WHERE nazwa = '{$_POST["name"]}' AND `email` = '{$_POST["email"]}' AND `haslo` = '{$_POST["password"]}'";
            $id = $connect->query($idQ)->fetch_assoc();
            $_SESSION["user"] = $id["konto_id"];
            header('Location: landing_page.php');
            }

*/
/*
            $_SESSION["user"] = $row["konto_id"];
            $doKoszyka = "SELECT * FROM `koszyk` WHERE konto_id = {$row["konto_id"]}";
            $_SESSION["koszyk"] = array();            
            $tablica = array();
            $zapytanie3 = $connect->query($doKoszyka);
            $i=0;
            while($row = $zapytanie3->fetch_assoc()){
                $tablica[$i][0]=$row["produkt_id"];
                $tablica[$i][1]=$row["ilosc"];
                $i++;
            }
            $_SESSION["koszyk"] = $tablica;
            
            $zapytanie = "SELECT * FROM `konta` where konto_id = {$_SESSION["user"]} ";
            $check = $connect->query($zapytanie)->fetch_assoc();
            if( $check["admin"] == true){
                //header('Location: admin.php');
            }
            else{
                //header('Location: landing_page.php');
            }
 */   
    ?>
<div class="top">
        <a href="landing_page.php"><img class="logo" src="Lamazoon (1).png" alt="logo strony"></a>
        <a href="login.php" style="float:right"><img class="user" src="user2.png" alt="user"></a>
        <a href="koszyk.php"><img src="cart.png" alt="" style="width: 100px;" class="cart"></a>
    </div>
    <form action="" method="post">
    <center>
        <div class="inputs">
                <input name="name" type="text">
                <input name="password" type="password">
                <input name="email" type="email">
                <div>
                    <span>zarejestruj</span>
                    <input type="checkbox" name="register" id="tojestid" value="tak">
                </div>
                <input type="submit">
        </div>
    </center>
</form>
</body>
</html>