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
    <center>
    <div style="display:flex">
        <div class="karta">
            <form action="" method="post">
                <p>podaj numer karty</p>
                <input name="kartaNumer" type="number">
            </form>
        </div>
        <div class="przelew">
            <form action="" method="post">
                <p>podaj dane konta</p>
                <input name="kontoNumer" type="number">    
            </form>
        </div>
    </div>
    </center>
</body>
</html>