<?php

require_once 'connetdb.php';
static $conn=null;


function insert() // inserire i dati dentro il database
{
    $Iduser = $_POST['nome1'];
    $Idvaso = $_POST['nome2'];
    $date = date('Y-m-d H:i:s');
    $sql="INSERT INTO vasi (IdUser,IdPlant,UpdateTime)
    VALUES ('$Iduser', '$Idvaso', '$date')";
if (!mysql_query($sql)) {
  die('Errore: ' . mysql_error());
}
echo "1 campo aggiunto";
}
connect($conn);
insert();
mysql_close(); //chiudere il db


?>