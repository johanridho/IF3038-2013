<?php
require_once('src/nusoap-0.9.5/lib/nusoap.php');

$client = new nusoap_client('http://soap.ap01.aws.af.cm/soap.php?wsdl', true);
$err = $client->getError();
if ($err)
{
	echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
}
$result = $client->call('hello', array('name' => 'Danny'));
if ($client->fault)
{
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '<pre>';
}
else
{
	$err = $client->getError();
	if ($err)
	{
		echo '<h2>Error</h2><pre>'.$err.'</pre>';
	}
	else
	{
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}

echo '<h2>Request</h2>';
echo '<pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
echo '<h2>Response</h2>';
echo '<pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

echo '<h2>Debug</h2>';
echo '<pre>'.htmlspecialchars($client->debug_str, ENT_QUOTES).'</pre>';
?>