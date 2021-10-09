<?php
/**
 * Class MAdvertiser de type Modèle gérant la table ADVERTISER
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MAdvertiser
 */
class MAdvertiser extends Model
{
    /**
     * @return array
     * Sélectionne un annonceur
     */
    public function select()
    {
        $query = 'SELECT id, mail, password, phone_number FROM advertiser WHERE id = :ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return array
     * Vérifie l'existence d'un annonceur pour la connexion
     */
    public function exist()
    {
        $query = 'SELECT advertiser.id AS advertiser_id, advertiser.mail FROM advertiser 
WHERE advertiser.mail LIKE :MAIL';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', $this->value['MAIL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // exist()

    /**
     * @return mixed
     * Récupère le mot de passe d'un annonceurs pour le système de connexion
     */
    public function password()
    {
        $query = 'SELECT advertiser.password FROM advertiser 
WHERE advertiser.mail LIKE :MAIL';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', $this->value['MAIL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // password()

    /**
     * @return mixed
     * Vérifie si l'adresse mail rentrer dans le formulaire est la même que stocker en base
     */
    public function email()
    {
        $query = 'SELECT advertiser.id, advertiser.mail FROM advertiser 
WHERE advertiser.mail LIKE :MAIL AND advertiser.id = :ADVERTISER_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', $this->value['MAIL'], PDO::PARAM_STR);
        $result->bindValue(':ADVERTISER_ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // email()

    /**
     * @return mixed
     * Vérifie si l'adresse mail existe déjà en base de donnée
     */
    public function emailExist()
    {
        $query = 'SELECT advertiser.id, advertiser.mail FROM advertiser 
WHERE advertiser.mail LIKE :MAIL';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', $this->value['MAIL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // emailExist()

    /**
     * @return mixed
     * Vérifie l'existence d'une annonce pour savoir si on peut supprimer un profil
     */
    public function advertExist()
    {
        $query = 'SELECT advert.id FROM advert WHERE advert.advertiser_id = :ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // advertExist()

    /**
     * @return array
     * Sélectionne la liste des annonces pour un annonceur
     */
    public function adverts()
    {
        $query = 'SELECT advert.id AS id, brand.name AS brand, model.name AS model FROM brand
INNER JOIN model ON brand.id = model.brand_id
INNER JOIN vehicle ON model.id = vehicle.model_id
INNER JOIN advert ON vehicle.id = advert.vehicle_id
INNER JOIN advertiser ON advert.advertiser_id = advertiser.id
WHERE advertiser.id = :ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // adverts()

    /**
     * @return array
     * Compte le nombre d'annonces pour un annonceur
     */
    public function numberAdvert()
    {
        $query = 'SELECT COUNT(brand.id) AS number_advert FROM brand
INNER JOIN model ON brand.id = model.brand_id
INNER JOIN vehicle ON model.id = vehicle.model_id
INNER JOIN advert ON vehicle.id = advert.vehicle_id
INNER JOIN advertiser ON advert.advertiser_id = advertiser.id
WHERE advertiser.id = :ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // numberadvert()

    /**
     * @return array
     * Met à jour le mot de passe en cas de changement pour oublie du mot de passe
     */
    public function updatePassword() {

        $query = "UPDATE advertiser SET password = :PASSWORD WHERE mail = :MAIL";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', strtolower($this->value['MAIL']), PDO::PARAM_STR);
        $result->bindValue(':PASSWORD', $this->value['PASSWORD'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // updatePassword()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table ADVERTISER
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
     * Insère un tuple dans la table ADVERTISER
     */
    private function insert()
    {
        $query = "INSERT INTO advertiser(mail, password, phone_number) 
VALUES (:MAIL, :PASSWORD, :PHONE_NUMBER)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', strtolower($this->value['MAIL']), PDO::PARAM_STR);
        $result->bindValue(':PASSWORD', $this->value['PASSWORD'], PDO::PARAM_STR);
        $result->bindValue(':PHONE_NUMBER', str_replace(' ', '',$this->value['PHONE_NUMBER']), PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table ADVERTISER
     */
    private function update()
    {
        $query = "UPDATE advertiser SET mail = :MAIL, password = :PASSWORD, phone_number = :PHONE_NUMBER WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MAIL', strtolower($this->value['MAIL']), PDO::PARAM_STR);
        $result->bindValue(':PASSWORD', $this->value['PASSWORD'], PDO::PARAM_STR);
        $result->bindValue(':PHONE_NUMBER', str_replace(' ', '',$this->value['PHONE_NUMBER']), PDO::PARAM_STR);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table ADVERTISER
     */
    private function delete()
    {
        $query = "DELETE FROM advertiser WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

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

} // class MAdvertiser

?>