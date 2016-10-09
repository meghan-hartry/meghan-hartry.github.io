<?php
$host = "mysql:host=kylescheercom.fatcowmysql.com;dbname=anthropology";
$usr = "soccerkyle1";
$pswd = "L0Lwat?2016";
$con = new PDO($host, $usr, $pswd, array(PDO::ATTR_PERSISTENT => TRUE ));
$shortmajorsarray = array();
$findshortmajors = "SELECT DISTINCT `shortmajor` FROM leepfrog";
$findmajors = "SELECT DISTINCT `shortmajor` FROM leepfrog";
}
$s = $con->prepare($findshortmajors);
$s->execute();
$results = $s->fetchAll(PDO::FETCH_ASSOC);
if ($results){
	foreach($results as $result){
		foreach($result as $shortmajor){
			array_push($shortmajorsarray,$shortmajor);
		}
	}
}
$c = count($shortmajorsarray);
echo "{<br>";
echo "\"name\": \"all\",<br>\"children\": [<br>{<br>";


for ($i=0;$i<$c;$i++){
	echo "\"name\": \"" . $shortmajorsarray[$i] . "\",<br>
	\"children:\": [<br>{<br>";
	
	$majorcodesarray = array();
	$findmajorcodes = "SELECT DISTINCT `majorcode` FROM leepfrog WHERE `shortmajor`='" . $shortmajorsarray[$i] . "'";
	$s = $con->prepare($findmajorcodes);
	$s->execute();
	$results = $s->fetchAll(PDO::FETCH_ASSOC);
	if ($results){
		foreach($results as $result){
			foreach($result as $majorcode){
				array_push($majorcodesarray,$majorcode);
			}
		}
	}
	$d = count($majorcodesarray);
	
	
	for ($j=0;$j<$d;$j++){
		echo "\"name\": \"" . $majorcodesarray[$j] . "\",<br>
		\"children:\": [<br>";
		$coursecodesarray = array();
		$findcoursecodes = "SELECT DISTINCT `coursecode` FROM leepfrog WHERE `shortmajor`='" . $shortmajorsarray[$i] . "' AND `majorcode`='" . $majorcodesarray[$j] . "'";
		$s = $con->prepare($findcoursecodes);
		$s->execute();
		$results = $s->fetchAll(PDO::FETCH_ASSOC);
		if ($results){
			foreach($results as $result){
				foreach($result as $coursecode){
					array_push($coursecodesarray,$coursecode);
				}
			}
		}
		$e = count($coursecodesarray);
		$shortcodenumberarray = array();
		for ($k=0; $k<$e; $k++){
			$shortcodenumberquery = "SELECT COUNT(*) FROM leepfrog WHERE `shortmajor`='" . $shortmajorsarray[$i] . "' AND `majorcode`='" . $majorcodesarray[$j] . "' AND `coursecode`='" . $coursecodesarray[$k] . "'";
			$s = $con->prepare($shortcodenumberquery);
			$s->execute();
			$UETs = $s->fetch();
			array_push($shortcodenumberarray,$UETs[0]);
		}
		for ($k=0; $k<$e;$k++){
			echo "{\"name\": \"" . $majorcodesarray[$j] . "\", \"size\": " . $shortcodenumberarraty[$k] . "},<br>";
		}
		echo "]<br>";
	}
	echo "},<br>]<br>";	
}
echo "}<br>]<br>}";
?>