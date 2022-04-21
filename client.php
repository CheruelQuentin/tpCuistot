<?php
ini_set('soap.wsdl_cache_enabled', 0);
$service=new SoapClient("http://localhost/SOAP/TPCUISTOT/server.wsdl");
$taballservices=$service->connexionPDO();

print_r($taballservices);
?>