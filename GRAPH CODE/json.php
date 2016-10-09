<?php
$host = "mysql:host=kylescheercom.fatcowmysql.com;dbname=bigdata";
$usr = "unexperienced";
$pswd = "whatishappening";
$con = new PDO($host, $usr, $pswd, array(PDO::ATTR_PERSISTENT => TRUE ));
$shortmajorsarray = array();
$findshortmajors = "SELECT DISTINCT `shortmajor` FROM leepfrog ORDER BY `shortmajor`";
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
echo "{";
echo "\"name\":\"ALL\",\"children\": [{";


for ($i=0;$i<$c;$i++){
	echo "\"name\":\"" . $shortmajorsarray[$i] . "\",
	\"children\": [";
	
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
	
	$majorcodenumberarray = array();
	for ($j=0;$j<$d;$j++){
		$majorcodenumberquery = "SELECT COUNT(*) FROM leepfrog WHERE `shortmajor`='" . $shortmajorsarray[$i] . "' AND `majorcode`='" . $majorcodesarray[$j] . "'";
		$s = $con->prepare($majorcodenumberquery);
		$s->execute();
		$UETs = $s->fetch();
		array_push($majorcodenumberarray,$UETs[0]);
	}
	for ($j=0; $j<$d;$j++){
		echo "{\"name\":\"" . $majorcodesarray[$j] . "\", \"size\":" . $majorcodenumberarray[$j] . "},";
	}
echo "]}";
	echo ",{";	
}
echo "}]}";
?>