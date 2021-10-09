<?php
/**
 * Class MFuel de type Modèle gérant la table FUEL
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MFuel
 */
class MFuel extends Model
{
    /**
     * @return array
     * Sélectionne tous les carburants
     */
    public function selectAll()
    {
        $query = 'SELECT fuel.name AS fuel FROM vehicle
INNER JOIN fuel ON vehicle.fuel_id = fuel.id
GROUP BY fuel';

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table FUEL
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
     * Insère un tuple dans la table FUEL
     */
    private function insert()
    {
        $query = "INSERT INTO fuel(name) VALUES (:NAME)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['FUEL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table FUEL
     */
    private function update()
    {
        $query = "UPDATE fuel SET name = :NAME WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['FUEL'], PDO::PARAM_STR);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table FUEL
     */
    private function delete()
    {
        $query = "DELETE FROM fuel WHERE id = :ID";

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

} // class MFuel

?>