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

echo "config" . "\t";
foreach($soc_list as $soc){
	echo $soc . "\t";
}
echo "\n";

foreach($data as $name => $item){
	echo $name . "\t";
	foreach($soc_list as $soc){
		echo @$item[$soc] . "\t";
	}
	echo "\n";
}

