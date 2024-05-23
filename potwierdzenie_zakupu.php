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
    ?>  
    <center><h1>wybierz metode płatności</h1></center>
    <form action="zamowienia.php" method="post">
    <center>
    <div style="display:flex">
        <div class="karta">
            
                <p>podaj numer karty</p>
                <input name="kartaNumer" type="number">
                <input type="checkbox" name="karta" id="">
        </div>
        <div class="przelew">
            <form action="zamowienia.php" method="post">
                <p>podaj dane konta</p>
                <input name="kontoNumer" type="number">  
                <input type="checkbox" name="Przelew" id="">
            
        </div>
    </div>
    </center>
    <center>
        <div>
            <h1>wybierz metode dostawy</h1>
            <span>Kurier <input type="text" name="adres" placeholder="adres"></span>
            <input type="checkbox" name="kurier" id="">
        </div>
    </center>
    </form>
</body>
</html>