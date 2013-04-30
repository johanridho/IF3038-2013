<?php
include('./httpful-0.2.0.phar');

$uri = "http://phprestsql.ap01.aws.af.cm/members/3";
$response = \Httpful\Request::post($uri)
    ->body('<xml><name>Value</name></xml>')
    ->sendsXml()
    ->send();
?>