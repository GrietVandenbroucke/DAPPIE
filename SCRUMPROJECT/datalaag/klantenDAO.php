<?php

/* require_once("    ")
 * 
 */

class KlantDAO {
    /* lijst van klanten ophalen */

    public function getAll() {
        $lijst = array();
        $dbh = new PDO($DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        /* !!!!!!!!!!!!!!!!!!!!!!!!!!!! querry nog niet volledig!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

        $sql = "select klanten.id as klantid, naam , voornaam, adres, postcode, gemeente, telefoonnummer,
            emailadres from klanten, dieren 
            where dierid = dier.id";

        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {

            $dier = Dier::create($rij[dierid], $rij["naam"]);

            $klant = Klant::create($rij["klantid"], $rij["naam"], $dier);
            array_push($lijst, $klant);
        }
        $dbh = null;
        return $lijst;
    }

    /* klanten per ID ophalen */

    public function getById($id) {

        $dbh = new PDO($DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $sql = "select klanten.id as klantid , naam , voornaam, dierid from
           klanten , dieren where dierid = dier.id and klanten.id = " . id;
        
        $resultset = $dbh->query($sql);
        $rij = $resultset->fetch();
        $dier = Dier::create ($rij["dierid"],
                $rij["naam"]);
        $klant = Klant::create($rij["dierid"],$rij["naam"],$dier);
        $dbh = null;
        return $klant;
    }
    
    
    
    /*  klant toevoegen */
    
    public function create($naam , $voornaam, $adres,$postcode , $gemeente, $telefoonnummer,
            $emailadres,$dierID) {
        $sql = "insert into klanten (naam, voornaam, adres, postcode, gemeente,
                telefoonnummer,emailadres, dierid) 
                values ('" .$naam."','" .$voornaam."','" .$adres."'," .$postcode."'," .$gemeente."',
                 '".$telefoonnummer."'," .$emailadres."',".$dierID.")";
        
         $dbh = new PDO($DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
         $dbh->exec($sql);
         $klantID = $dbh->lastInsertId();
         $dbh = null;
         $dierDAO = new DierDAO();
         $genre = $genreDAO->getById($dierID);
         $klant = Klant::create($klantID, $naam,$voornaam,$adres,$postcode,$gemeente,$telefoonnummer,
                 $emailadres, $dier);
         return $klant;
        
    }
    
    
    /* klant verwijderen */
    
    public function delete($id){
        $sql = " delete from klanten where id = ".$id;
         $dbh = new PDO($DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
         $dbh->exec ($sql);
         $dbh = null;
    }
    
    
    
    /* klant bijwerken */
    
    public function update ($klant) {
        $sql = "update klanten set naam ='" .$klant-> getNaam().
                "',dierID" .$klant->getDier()->getId();
        $dbh = new PDO($DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->exec($sql);
        $dbh = null ;
    }

}
