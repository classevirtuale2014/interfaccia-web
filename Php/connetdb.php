<?php

 function connect($conn) //funzione per connettersi al db
{
    $conn = mysql_connect("localhost", "root", "");//Si crea una connessione al database

if (!$conn) //Si controlla se si è effettuato//verifica connessione
{
    echo "Impossibile connettersi al dominio DB: " . mysql_error();
    exit;
}

if (!mysql_select_db("loccioniserver")) //connessione al database piante
{
    echo "Impossibile connettersi al DB: " . mysql_error();
    exit;
}
}

?>