<?php
$majorsarray = array();
$host = "mysql:host=kylescheercom.fatcowmysql.com;dbname=bigdata";
$usr = "unexperienced";
$pswd = "whatishappening";
$con = new PDO($host, $usr, $pswd, array(PDO::ATTR_PERSISTENT => TRUE ));
$findmajors = "SELECT DISTINCT `shortmajor` FROM leepfrog";
$s = $con->prepare($findmajors);
$s->execute();
$results = $s->fetchAll(PDO::FETCH_ASSOC);
if ($results){
	foreach($results as $result){
		foreach($result as $major){
			array_push($majorsarray,$major);
		}
	}
}
$c = count($majorsarray);
$classnumberarray = array();
for ($i=0; $i<$c; $i++){
	$classnumberquery = "SELECT COUNT(*) FROM leepfrog WHERE `shortmajor`='" . $majorsarray[$i] . "'";
	$s = $con->prepare($classnumberquery);
	$s->execute();
	$UETs = $s->fetch();
	array_push($classnumberarray,$UETs[0]);
}
for ($i=0; $i<$c; $i++){
	//echo $majorsarray[$i] . "," . $classnumberarray[$i] . "<br>";
}
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.3.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.css">
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.js"></script>
  <style type="text/css">
  </style>
  <title>Select Data</title>
<script type=" text/javascript">//<![CDATA[
$(window).load(function(){
$html = '<select name="majors" id="majors" multiple="multiple" size="1" class="chosenElement">';
	<?php
	for ($i=0;$i<$c;$i++){
		echo '$html';
		echo " += '<option value=\"" . $majorsarray[$i] . "\">" . $majorsarray[$i] . "</option>';";
	}
	?>
    $html += '</select>';
$('.modal-body').html($html);

$('.chosenElement').chosen({ width: "210px" });

$('.html-multi-chosen-select').chosen({ width: "210px" });

$('.simple-select').chosen({ width: "210px" });
});//]]> 

</script>
</head>
<body>
<form action="piecharts.php">
	<div class="modal-body"><select name="items" id="items" multiple="multiple" size="1" class="chosenElement" style="display: none;"><option value="foo">foo</option><option value="bar">bar</option><option value="baz">baz</option><option value="qux">qux</option></select>
		<div class="chosen-container chosen-container-multi" style="width: 210px;" title="" id="items_chosen">
			<ul class="chosen-choices">
				<li class="search-field">
					<input type="text" value="Select Some Options" class="default" autocomplete="off" style="width: 147px;">
				</li>
			</ul>
			<div class="chosen-drop">
				<ul class="chosen-results">
				</ul>
			</div>
		</div>
	</div>
	<input type="submit" value="Submit">
</form>
</body>
</html>