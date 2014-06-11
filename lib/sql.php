<?php
require_once("../config.php");
//Funzione che effettua la connessione
function connect($conn) //funzione per connettersi al db
{
	$conn = mysql_connect("localhost", constant("DB_USER"), constant("DB_PASS"));//Si crea una connessione al database

	if (!$conn) //Si controlla se si è effettuatoverifica connessione
	    die("Cannot connect to the database " . mysql_error());

	if (!mysql_select_db(constant("DB_NAME"))) //connessione al database piante
	    die("Cannot connect to the database: " . mysql_error());
	return $conn;
}
//Funzione che inserisce i dati nello storico, il primo parametro definisce la connessione
function insert($conn, $idVase, $temp, $light, $humair, $humland) // inserire i dati dentro il database
{
    $date = date('Y-m-d H:i:s');
    /*
	*	Aggiunta restituzione dati in caso di modifica vaso 
    */

    //Protezione da SQLI
    mysql_real_escape_string($idVase);
    mysql_real_escape_string($temp);
    mysql_real_escape_string($light);
    mysql_real_escape_string($humair);
    mysql_real_escape_string($humland);

    //Esecuzione della query
    $sql="INSERT INTO storico (IdVase, HumAir, HumLand, Light, Temp)VALUES ('$idVase', '$humair', '$humland', '$light', $temp)";
	if (!mysql_query($sql)) {
	  die('Error: ' . mysql_error());
	}
	return true;
	

}

function send_data()
?>