<?php
function connexionPDO() {
    $login = "root";
    $mdp = "";
    $bd = "tpcuistot";
    $serveur = "localhost"; 
    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    } catch (PDOException $e) {
        return "Erreur de connexion PDO ";
        print $e;
        die();
    }
}

function recettes() {
        $resultat = array();
        try {
            $cnx = connexionPDO();
            $req = $cnx->prepare("select * from recettes ");
            $req->execute();
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
}

function addRecette($nomRecette,$descriptionRecette) {
    $resultat = -1;
    try {
        $cnx = connexionPDO();

        $req = $cnx->prepare("insert into recettes (nomRecette,descriptionRecette) values(:nomRecette,:descriptionRecette)");

        $req->bindValue(':nomRecette', $nomRecette, PDO::PARAM_STR);
        $req->bindValue(':descriptionRecette', $descriptionRecette, PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function deleteRecette($nomRecette) {
    $resultat = -1;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("delete from recettes where nomRecette=:nomRecette");
        $req->bindValue(':nomRecette', $nomRecette, PDO::PARAM_INT);
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

ini_set('soap.wsdl_cache_enabled', 0);
$serversoap=new SoapServer("http://localhost/SOAP/TPCUISTOT/server.wsdl");
$serversoap->addFunction("connexionPDO");
$serversoap->addFunction("recettes");
$serversoap->addFunction("addRecette");
$serversoap->addFunction("deleteRecette");

$serversoap->handle();

?>
