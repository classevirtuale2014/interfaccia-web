<?php
/*
*	Script che riceve ed elabora le richieste del vaso
*	A seconda del contenuto della variabile flag esegue opeazioni diverse
*/
	require_once("lib/sql.php");
	
	if(isset($_GET['flag']) && $_GET['flag'] == "conf"){	//Comando Configurazione



	}else if(isset($_GET['flag']) && $_GET['flag'] == "data")	//Comando Ricezione Dati
		if(isset($_GET['id_vaso'])){
			$conn = connect();
			if(!checkConnection($conn))
				die("ERROR Cannot connect to database");
			
			send_data($conn, $_GET['id_vaso']);


		}else{
			echo "ERROR Id_Vase not sended"
		}

	}else{	//Comando non trovato
		echo "ERROR Command not found";
	}

?>