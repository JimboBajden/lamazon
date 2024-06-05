<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $connect=@new mysqli('localhost','root','','lamazon');
        session_start();    
        if($_SESSION["user"] == "" || !isset($_SESSION["user"])){
            header('Location: landing_page.php');
        }
    ?>
    <button id="convertButton">drukuj/zapisz</button>
    <center>   
        <div class="sprzedawca">   
            <p id="sprzedawca"><b>Sprzedawca: Lazmazon INC </b></p>   
        </div>
    </center>
    <div class="tab">
        <?php
        $osoby = "SELECT * FROM `zamuwienie`";
        $wynik = $connect->query($osoby)->fetch_assoc();
        echo "<p>nabywca:  <b>{$wynik["imie"]}</b></p>    
        <p>adres:  <b>{$wynik["adres"]}</b></p>";
        ?>
    </div>
    <div id="dane">
        <div class="legenda">
            <p id="counter"> lp </p>
            <p id="produkt"> produkt </p>
            <p id="ilosc"> ilosc </p>
            <p id="cena"> cena za sztuke</p>
            <p id="net"> wartość netto [zł]</p>>
        </div>
        <?php
        $sql = "SELECT produkt.nazwa AS 'nazwa' , zamuwienia.ilosc as 'ilosc' , produkt.cala_cena AS 'cala_cena'  FROM `zamuwienia` JOIN produkt USING(produkt_id) WHERE zamuwienie_id = {$_GET["id"]}";
        $count = 1;
        $suma = 0;
        $query = $connect->query($sql);
        while($row = $query->fetch_assoc()){
            $cena = $row["cala_cena"] * $row["ilosc"];
            echo"<div class='uslugi'>
                <p id='counter'> {$count} </p>
                <p id='produkt'> {$row["nazwa"]} </p>
                <p id='ilosc'> {$row["ilosc"]} </p>
                <p id='cena'> {$row["cala_cena"]}</p>
                <p id='net'> {$cena}</p>
            </div> ";    
            $count++;
            $suma += $cena;
        }
        ?>
    </div>
    <br><br>
    <p>suma produktów: <?php echo $suma ?></p>
    <script>
        var convertButton = document.getElementById('convertButton');

        convertButton.addEventListener('click', function() {
        convertButton.style.display = 'none'
        window.print();
        
        convertButton.style.display = 'block'
    });
    </script>
    <style>
        #convertButton{
    position: absolute;
    top: 5%;
    right: 5%;
    width: 200px;
    height: 100px;
    font-size: larger;
}
.podpisy{
    display: flex;
    flex-direction: row;
    gap: 10%;
}
.podpis{
    position: relative;
    width: auto;
}
.podpis::before{
    content: '';
    width: 350px;
    border-bottom: solid 4px black;
    position: absolute;
    top: 0;
    left: 0;
}
.podpis2{
    position: relative;
    width: auto;
    break-inside: auto;    
}
.podpis2::before{
    content: '';
    width: 350px;;
    border-bottom: solid 4px black;
    position: absolute;
    top: 0;
    left: 0;
}
.tab{
    margin-left: 5%;
}
.legenda{
    display: flex;
    justify-content: center;
    align-items: center;
    height:50px;
    border: 1px solid black;
}

.legenda >p{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    break-inside: auto;
    border: solid 1px black;
    padding: 10px;
    text-align: center;
    padding-bottom: 0;
    padding-top: 0;
    margin: 0;
}
.uslugi{
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    border: 2px solid black;
}
.uslugi >p {
    display: flex;
    justify-content: center;
    align-items: center;
    height: inherit;
    break-inside: auto;
    padding: 5px;
    margin: 0;
    border: 4px solid white;
    font-size: small;

}
#counter{
    width: 5%;
}
#usluga{
    width: 35%;
}
#ilosc{
    width: 5%;
}
#cena{
    width: 15%;
}
#net{
    width: 15%;
}
#vat{
    width: 15%;
}
#wvat{
    width: 20%;
}
#brutto{
    width: 15%;
}
.test{
    display: flex;
    width: 50%;
    height: auto;
    border: 1px solid;
    padding: 0;
    margin: 0;
}
.test > p{
    width: 25%;
    text-align: right;
    border: solid 1px;
    height: 100%;
    margin: 0;
    padding: 0;
}
    </style>
</body>
</html>