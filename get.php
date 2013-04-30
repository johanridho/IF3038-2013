<?php
$xml = simplexml_load_file("http://phprestsql.ap01.aws.af.cm/members/3.xml");
// if (!isset($xml->row[0]))
// {
// 	echo 'FAIL';
// }
// else
// {
	$i = 0;
	foreach($xml as $child)
	{
		echo $child->getName() . ": " . $child . "<br>";
		$i++;
	}
	echo 'Count:' . $i;
//}
?>