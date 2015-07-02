<?php


/*   require_once     

 * 
 *  */


class DierenDAO{
    
    public function getAll() {
        $lijst = array();
        $dbh = new PDO($DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
     /*!!!!!!!!!!!!!!!!!!!!!  querry aan te passen!!!!!!!!!!!!!!!!!!!!!!!!!!*/   
        $sql = "select id , naam from dieren";
        
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij){
            $dier = Dier::create($rij["id"],
                    $rij["naam"]);
                   array_push($lijst, $dier);
        }
        $dbh = null;
        return $lijst;
    }
    
    
    /* dieren per ID ophalen */
    
    public function getById($id){
       $dbh = new PDO($DBConfig::$DB_CONNSTRING,
                DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
       
       $sql = "select naam from dieren 
               where id = $id";
       $resultset = $dbh->query($sql);
       $rij = $resultSet->fetch();
       $genre = Genre::create($id , $rij["naam"]);
       $dbh = null;
       return $dier;
    }
}