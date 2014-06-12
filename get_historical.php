<?php

require_once("lib/sql.php");

$conn = connect();
$query = "SELECT Temp, UpdateTime
            FROM storico limit 30";
    $data = mysqli_query($conn, $query);
    $i=0;
    while($row = mysqli_fetch_array($data)) {

        $rows[$i]=array((float)$row['UpdateTime'],(float)$row['Temp']); 
        $rows1[$i]=array((float)$row['UpdateTime'],(float)$row['Temp']); 

        $i++;
    }
    mysql_close($conn);
    echo json_encode($rows), "\n";
    echo json_encode($rows1);

?>