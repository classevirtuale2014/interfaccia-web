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
    $idVase = mysql_real_escape_string($idVase);
    $temp = mysql_real_escape_string($temp);
    $light = mysql_real_escape_string($light);
    $humair = mysql_real_escape_string($humair);
    $humland = mysql_real_escape_string($humland);

    //Esecuzione della query
    $sql="INSERT INTO storico (IdVase, HumAir, HumLand, Light, Temp, UpdateTime)VALUES ('$idVase', '$humair', '$humland', '$light', $temp, $date)";
	if (!mysql_query($conn, $sql)) {
	  die('Error: ' . mysql_error());
	}
	return true;
	

}

function send_data($conn, $id_Vas){

	//Ricavo ID Plant
    $sql="SELECT IdVase FROM UserVase WHERE IdPlant=$id_Vas";
	$res = mysql_query($conn, $sql);
	if(!$res){
	  die('Error: ' . mysql_error($conn));
	}
	if(mysql_fetch_row($res) != 1){
		die("Cannot find your ID Plant");
	}

	$id_plant = mysql_result($res, 0);

	//Ricavo le informazioni

	$sql="SELECT ALL FROM Info_Plants WHERE IdPlant = $id_plant";
	$res = mysql_query($conn, $sql);
	if(!$res){
	  die('Error: ' . mysql_error($conn));
	}
	if(mysql_fetch_row($res) > 0){
		die("Cannot find your your plant");
	}


//TODO Utilizzare JSON al posto di sta risposta schifosa
while ($row = mysql_fetch_array($res, MYSQL_BOTH)) 
    echo $row["HumMaxAir"] . ";" . $row["HumMaxLand"] . ";" . $row["HumMinAir"] . ";" . $row["HumMinLand"] . ";" . $row["Light"] . ";" . $row["TempMax"] . ";" . $row["TempMin"] . ";";


}

function checkConnection($conn){
	if($conn===false)
		return false;
	return true;
}

function require_name_plant($conn)
{
	$sql="SELECT Name FROM Info_Plants WHERE IdVase FROM  UserVase = IdPlant FROM Info_Plants";
	$res = mysql_query($conn, $sql);
	if(!$res){
	  die('Error: ' . mysql_error($conn));
	}
}
?>