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

	function getCurLight(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime), Light FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$light = $row[1];
		mysql_close($conn);
		return $light;
	}

	function getCurHumIn(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpUpdateTime), HumLand FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest temp";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$humin = $row[1];
		mysql_close($conn);
		return $humin;
	}

	function getCurHumEx(){	//Funzione che restituisce la temperatura corrente
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(UpdateTime), HumAir FROM storico");
		if($ris === false){
			echo "Unable to Get the lastest HumEx";
			return false;
		}

		$row = mysql_fetch_row($ris);

		$humex = $row[1];
		mysql_close($conn);
		return $humex;
	}

	function getMaxTemp(){
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(Temp) FROM storico WHERE UpdateTime >= now() - INTERVAL 1 DAY;");
		if($ris === false){
			echo "Unable to Get the highest Temp";
			return false;
		}
		$row = mysql_fetch_row($ris);
		$temp = $row[0];
		mysql_close($conn);
		return $temp;
	}
	function getMinTemp(){
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;
		$ris = mysql_query("SELECT min(Temp) FROM storico WHERE UpdateTime >= now() - INTERVAL 1 DAY;");
		if($ris === false){
			echo "Unable to Get the lowest Temp";
			return false;
		}
		$row = mysql_fetch_row($ris);
		$temp = $row[0];
		mysql_close($conn);
		return $temp;
	}


//Luminosità Massimi e Minimo

	function getMaxLight(){
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;

		$ris = mysql_query("SELECT max(Light) FROM storico WHERE UpdateTime >= now() - INTERVAL 1 DAY;");
		if($ris === false){
			echo "Unable to Get the highest light value";
			return false;
		}
		$row = mysql_fetch_row($ris);
		$light = $row[0];
		mysql_close($conn);
		return $light;
	}
	function getMinLight(){
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;
		$ris = mysql_query("SELECT min(Light) FROM storico WHERE UpdateTime >= now() - INTERVAL 1 DAY;");
		if($ris === false){
			echo "Unable to Get the lowest light value";
			return false;
		}
		$row = mysql_fetch_row($ris);
		$light = $row[0];
		mysql_close($conn);
		return $light;
	}

	//Funzione che controlla l'ultimo aggiornamento inviato dalla pianta

	function getLastUpdateTime(){
		$conn = connect();	//Mi connetto 
		if(!checkConnection($conn))	//Controllo la connessione
			return false;
		$ris = mysql_query("SELECT max(UpdateTime) FROM storico");
		if($ris === false){
			echo "Unable to Get the lowest light value";
			return false;
		}
		$row = mysql_fetch_row($ris);
		$time = $row[0];
		mysql_close($conn);
		return $time;		
	}

	//Funzioni che sfruttano una connessione già esistente
/*
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
*/
?>