<?php
/**
 * Class MCompagny de type Modèle gérant la table COMPAGNY
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

class MCompagny extends Model
{
    /**
     * @return array
     * Sélectionne tous les annonceurs de type professionnel
     */
    public function selectAll()
    {
        $query = 'SELECT advertiser.id, compagny.name, compagny.siret FROM advertiser
INNER JOIN compagny ON advertiser.id = compagny.advertiser_id';

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @return array
     * Sélectionne un annonceur de type professionnel
     */
    public function select()
    {
        $query = 'SELECT advertiser.mail, advertiser.phone_number, compagny.name FROM advertiser
INNER JOIN compagny ON advertiser.id = compagny.advertiser_id
INNER JOIN advert ON advertiser.id = advert.advertiser_id
WHERE advert.id = :ADVERT_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return array
     * Sélectionne le nom de société d'un annonceur de type professionnel
     */
    public function name()
    {
        $query = 'SELECT compagny.name AS name_compagny FROM advertiser
INNER JOIN compagny ON advertiser.id = compagny.advertiser_id
WHERE advertiser.id = :ADVERTISER_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['advertiser_id'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // name()

    /**
     * @return mixed
     * Vérifie si le siret existe déjà en base de donnée
     */
    public function siretExist()
    {
        $query = 'SELECT compagny.siret FROM compagny WHERE compagny.siret LIKE :SIRET';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':SIRET', $this->value['SIRET'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // siretExist()

    /**
     * @return array
     * Sélectionne le profil d'un annonceur de type professionnel
     */
    public function profile()
    {
        $query = 'SELECT compagny.advertiser_id, compagny.name, compagny.siret, compagny.address, compagny.city, compagny.postal_code, advertiser.id, advertiser.mail, advertiser.password, advertiser.phone_number FROM advertiser
INNER JOIN compagny ON advertiser.id = compagny.advertiser_id
WHERE advertiser.id = :ADVERTISER_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // profile()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table COMPAGNY
     */
    public function modify($_type)
    {
        switch ($_type)
        {
            case 'insert' : return $this->insert();
            case 'update' : return $this->update();
            case 'delete' : return $this->delete();
        }

    } // modify($_type)

    /**
     * @return array
     * Insère un tuple dans la table COMPAGNY
     */
    private function insert()
    {
        $query = "INSERT INTO compagny(advertiser_id, name, siret, address, city, postal_code) 
VALUES (:ADVERTISER_ID, :NAME, :SIRET, :ADDRESS, :CITY, :POSTAL_CODE)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);
        $result->bindValue(':NAME', $this->value['NAME'], PDO::PARAM_STR);
        $result->bindValue(':SIRET', $this->value['SIRET'], PDO::PARAM_STR);
        $result->bindValue(':ADDRESS', mb_strtolower($this->value['ADDRESS']), PDO::PARAM_STR);
        $result->bindValue(':CITY', mb_strtolower($this->value['CITY']), PDO::PARAM_STR);
        $result->bindValue(':POSTAL_CODE', $this->value['POSTAL_CODE'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table COMPAGNY
     */
    private function update()
    {
        $query = "UPDATE compagny SET name = :NAME, 
                    siret = :SIRET, 
                    address = :ADDRESS, 
                    city = :CITY, 
                    postal_code = :POSTAL_CODE WHERE advertiser_id = :ADVERTISER_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['NAME'], PDO::PARAM_STR);
        $result->bindValue(':SIRET', $this->value['SIRET'], PDO::PARAM_STR);
        $result->bindValue(':ADDRESS', mb_strtolower($this->value['ADDRESS']), PDO::PARAM_STR);
        $result->bindValue(':CITY', mb_strtolower($this->value['CITY']), PDO::PARAM_STR);
        $result->bindValue(':POSTAL_CODE', $this->value['POSTAL_CODE'], PDO::PARAM_STR);
        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table COMPAGNY
     */
    private function delete()
    {
        $query = "DELETE FROM compagny WHERE advertiser_id = :ADVERTISER_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return;

    } // delete()

    /**
     * @param $result
     */
    private function errorSQL($result)
    {
        if (!DEBUG) return;

        $error = $result->errorInfo();

        debug($error);

        return;

    } // errorSQL($result)

} // class MCompagny

?>