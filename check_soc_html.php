<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ESP32 SoC Table</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.combined.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
    <script>
    $(document).ready(function() {
      $('table').tablesorter({
      widthFixed: true,
        widgets: ['zebra', 'columns', 'filter', 'pager', 'resizable', 'stickyHeaders']
      });
    });
    </script>
  </head>

  <body>
    <h1>ESP32 SoC Table</h1>
    <table>
<?php

$data = array();
$soc_list = array();
$soc_list['esp32'] = array();
$soc_list['esp32s2'] = array();
$soc_list['esp32s3'] = array();
$name = "";
foreach(glob("esp-idf-master/components/soc/*/include/soc/Kconfig.soc_caps.in") as $filepath) {
	$str = explode("/", $filepath);
	$soc = $str[3];
	$soc_list[$soc] = $soc;

	$file = file_get_contents($filepath);
	$lines = explode("\n", $file);
	foreach($lines as $line){
		$line = trim($line);
		$line_item = explode(" ", $line);
		if($line_item[0]=='config'){
			$name = $line_item[1];
		}
		if($line_item[0]=='default'){
			if($line_item[1][0]=='"'){
				$data[$name][$soc] = $line_item[1] . " " . $line_item[2];
			} else {
				$data[$name][$soc] = $line_item[1];
			}
		}
	}
}

echo "      <thead><tr>";
echo '<th>config</th>';
foreach($soc_list as $soc){
	echo '<th>'. $soc . '</th>';
}
	echo "</tr></thead>\n";

foreach($data as $name => $item){
	echo "      <tr>";
	echo '<td>' . $name . "</td>";
	foreach($soc_list as $soc){
		echo '<td>' . @$item[$soc] . "</td>";
	}
	echo "</tr>\n";
}

?>
    </table>
  </body>
</html>
