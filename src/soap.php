<?php
require_once('nusoap-0.9.5/lib/nusoap.php');

$client = new nusoap_client('http://soap.ap01.aws.af.cm/soap.php?wsdl', true);
$err = $client->getError();
if ($err)
{
	echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
}
?>