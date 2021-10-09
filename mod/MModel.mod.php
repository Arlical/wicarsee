<?php
/**
 * Class MModele de type Modèle gérant la table MODEL
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MModel
 */
class MModel extends Model
{
    /**
     * @return array
     * Sélectionne un modèle
     */
    public function select()
    {
        $query = 'SELECT id, name, brand_id FROM model WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['MODEL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return array
     * Sélectionne des models selon l'autocomplétion
     */
    public function selectModelAuto()
    {
        $query = 'SELECT name FROM model WHERE name LIKE :TERM';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':TERM', $this->value['term'].'%', PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectModelAuto()

    /**
     * @return array
     * Sélectionne tous les modèles
     */
    public function selectAll()
    {
        $query = 'SELECT model.name AS model FROM vehicle
INNER JOIN model ON vehicle.model_id = model.id
GROUP BY model';

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @return array
     * Sélectionne les modèle selon une marque
     */
    public function selectModel()
    {
        $query = 'SELECT model.name AS model FROM model
INNER JOIN brand ON model.brand_id = brand.id
WHERE brand.name LIKE :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['BRAND'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectModel()

    /**
     * @return array
     * Vérifie l'existence d'un modèle
     */
    public function exist()
    {
        $query = 'SELECT name FROM model WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['MODEL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // exist()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table MODELE
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
     * Insère un tuple dans la table MODELE
     */
    private function insert()
    {
        $query = "INSERT INTO model(name, brand_id) VALUES (:NAME, :BRAND_ID)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['MODEL']), PDO::PARAM_STR);
        $result->bindValue(':BRAND_ID', $this->value['BRAND_ID'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table MODELE
     */
    private function update()
    {
        $query = "UPDATE model SET name = :NAME, brand_id = :BRAND_ID WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['NAME']), PDO::PARAM_STR);
        $result->bindValue(':BRAND_ID', $this->value['BRAND_ID'], PDO::PARAM_INT);
        $result->bindValue(':ID', $this->value['ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table MODELE
     */
    private function delete()
    {
        $query = "DELETE FROM model WHERE id = :ID";

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

} // class MModel

?>