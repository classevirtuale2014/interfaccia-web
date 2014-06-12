<?php
	
	require_once("sql.php");

	//TODO Aggiungere notifica al posto del normalissimo echo 


	//Funzioni Che si Connettono Ogni Volta

	function getCurTemp(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime), temp FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[1];
		mysql_close($conn);
		return $temp;
	}

	function get_CurLight(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		mysql_close($conn);
		return $temp;
	}

	function get_CurHumIn(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpUpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		mysql_close($conn);
		return $temp;
	}

	function get_CurHumEx(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		mysql_close($conn);
		return $temp;
	}

	//Funzioni che sfruttano una connessione già esistente

	function get_CurTemp($conn){	//Funzione che restituisce la temperatura corrente
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		return $temp;
	}

	function get_CurLight($conn){	//Funzione che restituisce la temperatura corrente 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		return $temp;
	}

	function get_CurHumIn($conn){	//Funzione che restituisce la temperatura corrente
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		return $temp;
	}

	function get_CurHumEx($conn){	//Funzione che restituisce la temperatura corrente
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$temp = $row[0];
		return $temp;
	}

?>