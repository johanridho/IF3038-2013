<?php
include('./httpful-0.2.0.phar');

$password = sha1("rezavidi");
$uri = "http://localhost/progin4/phprestsql/members?username=%22arya%22&password=%22".$password."%22";
echo $uri . "<br />";
$response = \Httpful\Request::get($uri)  // Will parse based on Content-Type
    ->expectsXml()              // from the response, but can specify
    ->send();                   // how to parse via expectsXml too.

//echo $response->body->{'username'} . "\n";
if (!isset($response->body->{'row'}))
{
	echo "fail";
}
else
{
	echo $response->body->{'row'};
	echo "success";
}
?>