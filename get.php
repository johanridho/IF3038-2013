<?php
// include('./httpful-0.2.0.phar');

// $password = sha1("rezavidi");
// $uri = "http://phprestsql.ap01.aws.af.cm/members?id>3";
// // echo $uri . "<br />";
// $response = \Httpful\Request::get($uri)  // Will parse based on Content-Type
//     ->expectsXml()              // from the response, but can specify
//     ->send();                   // how to parse via expectsXml too.

// echo $response->raw_body->{'row'};
// // if (!isset($response->body->{'row'}))
// // {
// // 	echo "fail";
// // }
// // else
// // {
// // 	echo $response->body->{'row'};
// // 	echo "success";
// // }

$xml = simplexml_load_file("http://phprestsql.ap01.aws.af.cm/members?id>1.xml");
// echo $xml->getName() . "<br>";
foreach($xml->children() as $child)
{
	echo $child->getName() . ": " . $child . "<br>";
}

// if (!isset($xml->children())) echo 'kosong';
// else
// {
// 	foreach($xml->children() as $child)
// 	  {
// 	  echo $child->getName() . ": " . $child . "<br>";
// 	  }
// }
?>