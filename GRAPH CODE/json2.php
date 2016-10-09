<?php
ob_start();
require 'json.php';
$output = ob_get_clean();
$output2 = substr($output, 0, -9);
$output3 = $output2 . "}]}]}";
$output4 = strtr ($output3, array ('},]}' => '}]}'));
//echo $output4;
file_put_contents('bigdata.json', $output4);
?>