<?php
include 'session.php';
include 'soap.php';

foreach ($_POST as $k => $v) {
	${$k} = $v;
}

$result = $client->call('insertCategory',array('name' => $category_name, 'user' => $relateduser,'id' => $creator_id));
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
		// echo '<h2>Result</h2><pre>';
		// print_r($result);
		// echo '</pre>';
		header("location:dashboard.php");
	}
}

echo '<h2>Request</h2>';
echo '<pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
echo '<h2>Response</h2>';
echo '<pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

echo '<h2>Debug</h2>';
echo '<pre>'.htmlspecialchars($client->debug_str, ENT_QUOTES).'</pre>';
?>