<?php
/**
 * Class MAdvert de type Modèle gérant la table ADVERT
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MAdvert
 */
class MAdvert extends Model
{
    /**
     * @return array
     * Sélectionne toute les annonces
     */
    public function selectAll() {
        $query = "SELECT brand.name AS brand, model.name AS model, vehicle.year AS year, vehicle.number_kilometers AS number_kilo, vehicle.price AS price, advert.id AS advert_id, advert.miniature AS miniature FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id";

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();
    }

    /**
     * @return array
     * Sélectionne toute les annonces avec une limite de 10 annonces
     */
    public function selectAllLimit()
    {
        $query = "SELECT brand.name AS brand, model.name AS model, vehicle.year AS year, vehicle.number_kilometers AS number_kilo, vehicle.price AS price, advert.id AS advert_id, advert.miniature AS miniature FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id 
LIMIT " . $this->value;

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();

    } // selectAllLimit()

    /**
     * @return array
     * Sélectionne les éléments pour le filtre de sélection d'annonces
     */
    public function selectFilter()
    {
        $query = "SELECT brand.name AS brand, model.name AS model, vehicle.year AS year, vehicle.number_kilometers AS number_kilo, vehicle.price AS price, advert.id AS advert_id, advert.miniature AS miniature FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id
INNER JOIN fuel ON vehicle.fuel_id = fuel.id
WHERE " . $this->value['CONDITION'] . "
 LIMIT " . $this->value['LIMIT'];

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();

    } // selectFilter()

    /**
     * @return mixed
     * Compte le nombre d'annonces pour la pagination avec filtre
     */
    public function countAdvertFilter()
    {
        $query = "SELECT COUNT(advert.id) AS number_advert FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id
INNER JOIN fuel ON vehicle.fuel_id = fuel.id
WHERE " . $this->value['CONDITION'];

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // countAdvertFilter()

    /**
     * @return mixed
     * Compte le nombre d'annonces pour la pagination sans filtre
     */
    public function countAdvertAll()
    {
        $query = "SELECT COUNT(advert.id) AS number_advert FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id
INNER JOIN fuel ON vehicle.fuel_id = fuel.id";

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // countAdvertAll()

    /**
     * @return mixed
     * Sélectionne une seul annonce
     */
    public function select()
    {
        $query = "SELECT brand.name AS brand, model.name AS model, vehicle.year AS year, vehicle.number_kilometers AS number_kilo, vehicle.price AS price, vehicle.description AS description, color.name AS color, fuel.name AS fuel, gearbox.name AS gearbox, advert.id AS advert_id, picture.name AS picture FROM advert
INNER JOIN vehicle ON advert.vehicle_id = vehicle.id
INNER JOIN color ON vehicle.color_id = color.id
INNER JOIN fuel ON vehicle.fuel_id = fuel.id
INNER JOIN gearbox ON vehicle.gearbox_id = gearbox.id
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id
INNER JOIN picture ON advert.id = picture.advert_id
WHERE advert.id = :ADVERT_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return mixed
     * Sélectionne le nom de la propriété miniature
     */
    public function selectMiniature()
    {
        $query = "SELECT miniature FROM advert WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // selectMiniature()

    /**
     * @return mixed
     * Sélectionne l'id d'un véhicule
     */
    public function selectIdVehicle()
    {
        $query = "SELECT vehicle_id FROM advert WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // selectIdvehicle()

    /**
     * @param string
     * @return null
     * Gère un tuple de la table ADVERT
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
     * Insère un tuple dans la table ADVERT
     */
    private function insert()
    {
        $query = "INSERT INTO advert(advertiser_id, vehicle_id, publication_date, miniature) VALUES (:ADVERTISER_ID, :VEHICLE_ID, :PUBLICATION_DATE, :MINIATURE)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERTISER_ID', $this->value['ADVERTISER_ID'], PDO::PARAM_STR);
        $result->bindValue(':VEHICLE_ID', $this->value['VEHICLE_ID'], PDO::PARAM_STR);
        $result->bindValue(':PUBLICATION_DATE', date('Y-m-d'), PDO::PARAM_STR);
        $result->bindValue(':MINIATURE', $this->value['MINIATURE'], PDO::PARAM_STR);


        $result->execute() or die ($this->ErrorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table ADVERT
     */
    private function update()
    {
        $query = "UPDATE advert SET miniature = :MINIATURE WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':MINIATURE', $this->value['MINIATURE'], PDO::PARAM_STR);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->ErrorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table ADVERT
     */
    private function delete()
    {
        $query = "DELETE FROM advert WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->ErrorSQL($result));

        return;

    } // delete()

    /**
     * @param $result
     * Gestion des erreurs SQL
     */
    private function errorSQL($result)
    {
        if (!DEBUG) return;

        $error = $result->errorInfo();

        debug($error);

        return;

    } // errorSQL($result)

} // class Madvert

?>