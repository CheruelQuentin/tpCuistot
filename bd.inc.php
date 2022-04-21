<?php
function connexionPDO() {
    $login = "root";
    $mdp = "";
    $bd = "tpcuistot";
    $serveur = "localhost"; 
    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return var_dump($conn);
    } catch (PDOException $e) {
        return "Erreur de connexion PDO ";
        print $e;
        die();
    }
}


ini_set('soap.wsdl_cache_enabled', 0);
$serversoap=new SoapServer("http://localhost/SOAP/TPCUISTOT/server.wsdl");
$serversoap->addFunction("connexionPDO");
$serversoap->handle();

?>
