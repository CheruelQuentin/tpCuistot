<?php
ini_set('soap.wsdl_cache_enabled', 0);
$service=new SoapClient("http://localhost/SOAP/TPCUISTOT/server.wsdl");
$taballservices=$service->connexionPDO();
$taballrecettes=$service->recettes();
//$tabdeleterecettes=$service->deleteRecettes(1);
$tabaddrecettes=$service->addRecette('Welsh','une recette du nord');

print_r($taballrecettes);
?>