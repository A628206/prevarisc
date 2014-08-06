<?php

class Model_DbTable_Groupement extends Zend_Db_Table_Abstract
{
    protected $_name="groupement"; // Nom de la base
    protected $_primary = "ID_GROUPEMENT"; // Clé primaire
    protected $_referenceMap = array(
            "groupementtype" => array(
                "columns" => "ID_GROUPEMENT",
                "refTableClass" => "Model_DbTable_GroupementType",
                "refColumns" => "ID_GROUPEMENTTYPE",
            ),
            "groupementcommune" => array(
                "columns" => "ID_GROUPEMENT",
                "refTableClass" => "Model_DbTable_GroupementCommune",
                "refColumns" => "ID_GROUPEMENT",
                "onDelete" => self::CASCADE
            ),
            "groupementpreventionniste" => array(
                "columns" => "ID_GROUPEMENT",
                "refTableClass" => "Model_DbTable_GroupementPreventionniste",
                "refColumns" => "ID_GROUPEMENT",
                "onDelete" => self::CASCADE
            ),
        );

    public function get($id = null)
    {
        $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from("groupement")
                        ->joinInner("groupementtype", "groupement.ID_GROUPEMENTTYPE = groupementtype.ID_GROUPEMENTTYPE", "LIBELLE_GROUPEMENTTYPE")
                        ->joinLeft("utilisateurinformations", "utilisateurinformations.ID_UTILISATEURINFORMATIONS = groupement.ID_UTILISATEURINFORMATIONS");

        if ($id != null) {
          $select->where("groupement.ID_GROUPEMENT = '$id'");

          return ( $this->fetchRow( $select ) != null ) ? $this->fetchRow( $select ) : null;
        } else {
          return ( $this->fetchAll( $select ) != null ) ? $this->fetchAll( $select ) : null;
        }

    }

    public function deleteGroupement($id)
    {
        $this->getAdapter()->query("DELETE FROM `groupementcommune` WHERE `groupementcommune`.`ID_GROUPEMENT` = $id;");
        $this->getAdapter()->query("DELETE FROM `groupementpreventionniste` WHERE `groupementpreventionniste`.`ID_GROUPEMENT` = $id;");
        $this->getAdapter()->query("DELETE FROM `groupement` WHERE `groupement`.`ID_GROUPEMENT` = $id;");
    }

    public function getPreventionnistes($id)
    {
        $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from("groupementpreventionniste")
                        ->join("utilisateur", "utilisateur.ID_UTILISATEUR = groupementpreventionniste.ID_UTILISATEUR")
                        ->join("utilisateurinformations", "utilisateurinformations.ID_UTILISATEURINFORMATIONS = utilisateur.ID_UTILISATEURINFORMATIONS")
                        ->where("groupementpreventionniste.ID_GROUPEMENT = '$id'")
                        ->order("utilisateurinformations.NOM_UTILISATEURINFORMATIONS ASC");

        return $this->fetchAll($select)->toArray();

    }

    public function getPreventionnistesByGpt($gpts)
    {
        $array_result = array();

        foreach ($gpts as $gpt) {
            $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from("groupementpreventionniste")
                            ->join("utilisateur", "utilisateur.ID_UTILISATEUR = groupementpreventionniste.ID_UTILISATEUR")
                            ->join("utilisateurinformations", "utilisateurinformations.ID_UTILISATEURINFORMATIONS = utilisateur.ID_UTILISATEURINFORMATIONS")
                            ->where("groupementpreventionniste.ID_GROUPEMENT = '".$gpt['ID_GROUPEMENT']."'")
                            ->order("utilisateurinformations.NOM_UTILISATEURINFORMATIONS ASC");

            $result = $this->fetchAll($select)->toArray();

            if(count($result)>0)
                $array_result[] = $result;
        }

        return array_unique($array_result);
    }

    public function getGroupementParVille($code_insee)
    {
        $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from("groupement")
                        ->joinInner("groupementcommune", "groupementcommune.ID_GROUPEMENT = groupement.ID_GROUPEMENT", null)
                        ->joinInner("groupementtype", "groupementtype.ID_GROUPEMENTTYPE = groupement.ID_GROUPEMENTTYPE", "LIBELLE_GROUPEMENTTYPE")
                        ->where("groupementcommune.NUMINSEE_COMMUNE = '$code_insee'");

        return $this->fetchAll($select)->toArray();
    }
}
