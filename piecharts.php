<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Pie Chart</title>
    <link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css" rel="stylesheet" data-semver="3.0.1" data-require="normalize@*" />
<!--datatables start-->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.12.3.js"></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<!--datatables end-->
	</head>
<body>
<?php
$majorsarray = array();
$host = "mysql:host=kylescheercom.fatcowmysql.com;dbname=bigdata";
$usr = "unexperienced";
$pswd = "whatishappening";
$con = new PDO($host, $usr, $pswd, array(PDO::ATTR_PERSISTENT => TRUE ));
if ($_POST['majors']){
$findmajors = "SELECT DISTINCT `majorname` FROM leepfrog WHERE `shortmajor`='" . $_POST['majors'] . "'";
}
else {
$findmajors = "SELECT DISTINCT `shortmajor` FROM leepfrog";
}
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
echo "</div>";
echo $_POST['majors'];
?>
<div id="chart"></div>
<script data-require="d3@*" data-semver="4.0.0" src="https://d3js.org/d3.v4.min.js"></script>
<script>
      (function(d3) {
        'use strict';

        var dataset = [<?php
		  $totalstring = "";
		  for ($i=0;$i<$c;$i++){
			  echo "{ label: '" . $majorsarray[$i] . "', count: " . $classnumberarray[$i] . "},
			  ";
		  }
		  ?>
        ];

        var width = 360;
        var height = 360;
        var radius = Math.min(width, height) / 2;

        var color = d3.scaleOrdinal(d3.schemeCategory20b);

        var svg = d3.select('#chart')
          .append('svg')
          .attr('width', width)
          .attr('height', height)
          .append('g')
          .attr('transform', 'translate(' + (width / 2) + 
            ',' + (height / 2) + ')');

        var arc = d3.arc()
          .innerRadius(0)
          .outerRadius(radius);

        var pie = d3.pie()
          .value(function(d) { return d.count; })
          .sort(null);

        var path = svg.selectAll('path')
          .data(pie(dataset))
          .enter()
          .append('path')
          .attr('d', arc)
          .attr('fill', function(d, i) { 
            return color(d.data.label);
          });

      })(window.d3);
</script>
<table id="myTable" class="display" cellspacing="0" border="1">
    <thead>
        <tr>
            <th>Major</th>
            <th># of classes</th>
        </tr>
    </thead>
    <tbody>
	<?php
	for ($i=0;$i<$c;$i++){
		echo "<tr>";
		echo "<td>" . $majorsarray[$i] . "</td>";
		echo "<td>" . $classnumberarray[$i] . "</td>";
        echo "</tr>";
    }
	?>
    </tbody>
</table>
</body>
</html>