<?php
$user = 'massebtk';
$pass = 'azerty';
    try{
        $db = new PDO('mysql:host=localhost;dbname=twitter',$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e){
        echo "Erreur: ".$e->getMessage()."<br/>";
    }

 
    
    
  




