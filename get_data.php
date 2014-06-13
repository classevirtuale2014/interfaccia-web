<?php
require_once("lib/sql.php");

$conn = connect();
/*
*   Imposto il numero di dati da ricevere (Default = 30)
*/
if(!isset($_GET['limit']))  //Se non viene passata la variabile limit esso viene impostato a 30
    $limit = 30;
else
    $limit = mysql_real_escape_string($_GET['limit']);  //Protezione da SQLI
/*
*   Imposto il dato che voglio ritirare (Default=Temp)
*/
if(!isset($_GET['var']))  //Se non viene passata la variabile essa viene impostata a Temp
    $var = 'Temp';
else
    $var = mysql_real_escape_string($_GET['var']);  //Protezione da SQLI


$query = "SELECT $var, UpdateTime
            FROM storico limit $limit";
    $data = mysql_query($query, $conn);
    $i=0;
    while($row = mysql_fetch_array($data)) {

    	$time = strtotime($row['UpdateTime']) * 1000;
        $rows[$i]=array($time,(float)$row[$var]); //Tramite Array associativo prendo il valore 
        $rows1[$i]=array($time,(float)$row[$var]);  //della variabile passata
        $i++;
    }
    mysql_close($conn);
    //echo json_encode($rows), "\n";
    $rows1 = json_encode($rows1);
   echo $rows1;
?>