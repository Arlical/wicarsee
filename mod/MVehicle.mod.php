<?php
/**
 * Class MVehicle de type Modèle gérant la table VEHICLE
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

class MVehicle extends Model
{
    /**
     * @return array
     * Sélectionne un véhicule
     */
    public function select()
    {
        $query = "SELECT brand.name brand, model.name model, vehicle.id, vehicle.year, vehicle.number_kilometers, vehicle.price, vehicle.description, color.name color, fuel.name fuel, gearbox.name gearbox FROM brand
INNER JOIN model ON brand.id = model.brand_id
INNER JOIN vehicle ON model.id = vehicle.model_id
INNER JOIN color ON vehicle.color_id = color.id
INNER JOIN fuel ON vehicle.fuel_id = fuel.id
INNER JOIN gearbox ON vehicle.gearbox_id = gearbox.id
INNER JOIN advert ON vehicle.id = advert.vehicle_id
WHERE advert.id = :ADVERT_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table VEHICLE
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
     * Insère un tuple dans la table VEHICLE
     */
    private function insert()
    {
        $query = "INSERT INTO vehicle(color_id, fuel_id, gearbox_id, model_id, year, number_kilometers, price, description)
VALUES (:COLOR_ID, :FUEL_ID, :GEARBOX_ID, :MODEL_ID, :YEAR, :NUMBER_KILOMETERS, :PRICE, :DESCRIPTION)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':COLOR_ID', $this->value['COLOR_ID'], PDO::PARAM_INT);
        $result->bindValue(':FUEL_ID', $this->value['FUEL_ID'], PDO::PARAM_INT);
        $result->bindValue(':GEARBOX_ID', $this->value['GEARBOX_ID'], PDO::PARAM_INT);
        $result->bindValue(':MODEL_ID', $this->value['MODEL_ID'], PDO::PARAM_INT);
        $result->bindValue(':YEAR', $this->value['YEAR'], PDO::PARAM_STR);
        $result->bindValue(':NUMBER_KILOMETERS', $this->value['NUMBER_KILOMETERS'], PDO::PARAM_INT);
        $result->bindValue(':PRICE', $this->value['PRICE'], PDO::PARAM_INT);
        $result->bindValue(':DESCRIPTION', $this->value['DESCRIPTION'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table VEHICLE
     */
    private function update()
    {
        $query = "UPDATE vehicle SET color_id = :COLOR_ID,
                    fuel_id = :FUEL_ID,
                    gearbox_id = :GEARBOX_ID,
                    model_id = :MODEL_ID,
                    year = :YEAR,
                    number_kilometers = :NUMBER_KILOMETERS,
                    price = :PRICE,
                    description = :DESCRIPTION
                    WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':COLOR_ID', $this->value['COLOR_ID'], PDO::PARAM_INT);
        $result->bindValue(':FUEL_ID', $this->value['FUEL_ID'], PDO::PARAM_INT);
        $result->bindValue(':GEARBOX_ID', $this->value['GEARBOX_ID'], PDO::PARAM_INT);
        $result->bindValue(':MODEL_ID', $this->value['MODEL_ID'], PDO::PARAM_INT);
        $result->bindValue(':YEAR', $this->value['YEAR'], PDO::PARAM_STR);
        $result->bindValue(':NUMBER_KILOMETERS', $this->value['NUMBER_KILOMETERS'], PDO::PARAM_STR);
        $result->bindValue(':PRICE', $this->value['PRICE'], PDO::PARAM_INT);
        $result->bindValue(':DESCRIPTION', $this->value['DESCRIPTION'], PDO::PARAM_STR);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table VEHICLE
     */
    private function delete()
    {
        $query = "DELETE FROM vehicle WHERE id = :ID";

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

} // class MVehicle

?>