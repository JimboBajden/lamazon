<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css4.css">
</head>
<body>
    <?php
        session_start();
        $connect=@new mysqli('localhost','root','','lamazon');
    ?>  
    <center><h1>wybierz metode płatności</h1></center>
    <div class="nwm">
        <a href="zamowienia.php?metoda=przelew">Przelew</a>
        <a href="zamowienia.php?metoda=karta">Kartą</a>
    </div>

    
</body>
</html>