<?php
/**
 * Class MIndividual de type Modèle gérant la table INDIVIDUAL
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

class MIndividual extends Model
{
    /**
     * @return array
     * Sélectionne tous les annonceurs de type particulier
     */
    public function selectAll()
    {
        $query = 'SELECT individual.advertiser_id, individual.id, individual.name, individual.surname FROM individual';

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @return array
     * Sélectionne un annonceur de type particulier
     */
    public function select()
    {
        $query = 'SELECT advertiser.mail, advertiser.phone_number, individual.name, individual.surname FROM advertiser
INNER JOIN individual ON advertiser.id = individual.advertiser_id
INNER JOIN advert ON advertiser.id = advert.advertiser_id
WHERE advert.id = :ADVERT_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return array
     * Sélectionne le nom et prénom d'un annonceur de type particulier
     */
    public function name()
    {
        $query = 'SELECT individual.name AS name, individual.surname AS surname FROM advertiser
INNER JOIN individual ON advertiser.id = individual.advertiser_id
WHERE advertiser.id = :ADVERTISER_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['advertiser_id'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // name()

    /**
     * @return array
     * Sélectionne le profil d'un annonceur de type particulier
     */
    public function profile()
    {
        $query = 'SELECT individual.advertiser_id, individual.name, individual.surname, civility.name AS civility, advertiser.id, advertiser.mail, advertiser.password, advertiser.phone_number FROM advertiser
INNER JOIN individual ON advertiser.id = individual.advertiser_id
INNER JOIN civility ON individual.civilities_id = civility.id
WHERE advertiser.id = :ADVERTISER_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // profile()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table INDIVIDUAL
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
     * Insère un tuple dans la table INDIVIDUAL
     */
    private function insert()
    {
        $query = "INSERT INTO individual(civilities_id, advertiser_id, surname, name) 
VALUES (:CIVILITIES_ID, :ADVERTISER_ID, :SURNAME, :NAME)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':CIVILITIES_ID', $this->value['CIVILITIES_ID'], PDO::PARAM_INT);
        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);
        $result->bindValue(':SURNAME', mb_strtolower($this->value['SURNAME']), PDO::PARAM_STR);
        $result->bindValue(':NAME', mb_strtolower($this->value['NAME']), PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table INDIVIDUAL
     */
    private function update()
    {
        $query = "UPDATE individual SET civilities_id = :CIVILITIES_ID, 
                    surname = :SURNAME, 
                    name = :NAME 
                    WHERE advertiser_id = :ADVERTISER_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':CIVILITIES_ID', $this->value['CIVILITIES_ID'], PDO::PARAM_INT);
        $result->bindValue(':SURNAME', mb_strtolower($this->value['SURNAME']), PDO::PARAM_STR);
        $result->bindValue(':NAME', mb_strtolower($this->value['NAME']), PDO::PARAM_STR);
        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table INDIVIDUAL
     */
    private function delete()
    {
        $query = "DELETE FROM individual WHERE advertiser_id = :ADVERTISER_ID";

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

} // class MIndividual

?>