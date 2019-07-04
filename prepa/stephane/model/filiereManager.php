<?php

class filiereManager {

    private $db; //connexion MyPDO

    public function __construct(MyPDO $connect)
    {
        $this->db = $connect;
    }

/**
 * 
 * Methode de la partie public
 * 
 */

 //creation du menu
 public function creerMenu(): array {
     $sql = "SELECT idlafiliere,lenom,lacronyme,lacouleur,lepicto FROM lafiliere ORDER BY lenom ASC;";
     $recup = $this->db->query($sql);

     if($recup->rowCount()===0){
         return[];
     }
     return $recup->fetchAll(PDO::FETCH_ASSOC);
 }

//creation de l'affichage
 public function selectionnerFiliereIndexPublic(): array{

    $sql = "SELECT * FROM lafiliere ORDER BY lenom ASC;";
    $recup = $this->db->query($sql);

    if($recup->rowCount()===0){
        return [];
    }
    return $recup->fetchAll(PDO::FETCH_ASSOC);
 }



 //recuperation d'une filiere par son ID
 public function selectionnerFiliereParId(int $idlafiliere): array{
     if(empty($idlafiliere)){
         return [];

     }
     $sql="SELECT * FROM lafiliere WHERE idlafiliere ;";
     $recup = $this->db->query($sql);
     

     if($recup->rowCount()===0){
         return [];
     }
      return $recup->fetchAll(PDO::FETCH_ASSOC);
    
 }

 // Requête pour mettre à jour une filiere en vérifant si la variable get idsection correspond bien à la variable post idfiliere (usurpation d'identité)

 public function updateFiliere(thefiliere $datas, int $get){

    // vérification que les champs soient valides (pas vides)
    if(empty($datas->getLenom())||empty($datas->getLacronyme())||empty($datas->getIdlafiliere())){
        return false;
    }

    // vérification contre le contournement des droits
    if($datas->getIdlafiliere()!=$get){
        return false;
    }

    $sql = "UPDATE lafiliere SET lenom=?, lacronyme=? WHERE idlafiliere=?";

    $update = $this->db->prepare($sql);

    $update->bindValue(1,$datas->getLenom(),PDO::PARAM_STR);
    $update->bindValue(2,$datas->getLacronyme(),PDO::PARAM_STR);
    $update->bindValue(3,$datas->getIdlafiliere(),PDO::PARAM_INT);

    try{
        $update->execute();
        return true;
    }catch (PDOException $e){
        echo $e->getCode();
        return false;
    }

}



}