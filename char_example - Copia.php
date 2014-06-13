<?php

	require_once("lib/sql.php");

$conn = connect();
$query = "SELECT Temp, UpdateTime
            FROM storico limit 30";
    $data = mysql_query($query, $conn);
    $i=0;
    while($row = mysql_fetch_array($data)) {

    	$time = strtotime($row['UpdateTime']) * 1000;
        $rows[$i]=array($time,(float)$row['Temp']); 
        $rows1[$i]=array($time,(float)$row['Temp']); 

        $i++;
    }
    mysql_close($conn);
    //echo json_encode($rows), "\n";
    $rows1 = json_encode($rows1);
   //echo $rows1;
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highstock Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
$(function() {
	$.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function(data) {

		// Create the chart
		$('#container').highcharts('StockChart', {

			rangeSelector : {
				inputEnabled: $('#container').width() > 480,
				selected : 1
			},

			title : {
				text : 'Grafico Variazione Temperatura nel Tempo'
			},

			series : [{
				name : 'AAPL Stock Price',
				data : <?php echo $rows1;?>,
				type : 'areaspline',
				threshold : null,
				tooltip : {
					valueDecimals : 2
				},
				fillColor : {
					linearGradient : {
						x1: 0, 
						y1: 0, 
						x2: 0, 
						y2: 1
					},
					stops : [
						[0, Highcharts.getOptions().colors[0]], 
						[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
					]
				}
			}]
		});
	});
});

		</script>
	</head>
	<body>
<script src="lib/highstock/js/highstock.js"></script>
<script src="lib/highstock/js/modules/exporting.js"></script>


<div id="container" style="height: 400px; min-width: 310px"></div>
	</body>
</html>
