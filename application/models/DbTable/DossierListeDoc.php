<?php

class Model_DbTable_DossierListeDoc extends Zend_Db_Table_Abstract
{

    protected $_name="listedocconsulte"; // Nom de la base
    protected $_primary = "ID_DOC"; // Cl� primaire

    //Fonction qui r�cup�re tous les doc de viste
    public function getDocVisite()
    {
        $select = "SELECT *
            FROM listedocconsulte
            WHERE VISITE_DOC = '1';";

        return $this->getAdapter()->fetchAll($select);
    }

    //Fonction qui r�cup�re tous les doc d'etude
    public function getDocEtude()
    {
        $select = "SELECT *
            FROM listedocconsulte
            WHERE ETUDE_DOC = '1';";

        return $this->getAdapter()->fetchAll($select);
    }

    public function getDocVisiteRT()
    {
        $select = "SELECT *
            FROM listedocconsulte
            WHERE VISITERT_DOC = '1';";

        return $this->getAdapter()->fetchAll($select);
    }

    public function getDocVisiteVAO()
    {
        $select = "SELECT *
            FROM listedocconsulte
            WHERE VISITEVAO_DOC = '1';";

        return $this->getAdapter()->fetchAll($select);
    }

    //r�cupere les dossier qui ont �t� selection pour le dossier
    public function recupDocDossier($id_dossier, $id_nature)
    {
        $select = "SELECT *
        FROM dossierdocconsulte
        WHERE ID_DOSSIER = '".$id_dossier."'
        AND ID_NATURE = '".$id_nature."' ;";
        //echo $select;
        return $this->getAdapter()->fetchAll($select);
    }



    /*
    public function recupDocDossier($id_dossier)
    {
        $select = "SELECT *
        FROM dossierdocconsulte
        WHERE id_dossier = '".$id_dossier."';";
        //echo $select;
        return $this->getAdapter()->fetchAll($select);
    }
    */
}
