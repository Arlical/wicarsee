<?php
/**
 * Class MBrand de type Modèle gérant la table BRAND
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MBrand
 */
class MBrand extends Model
{
    /**
     * @return array
     * Sélectionne une marque
     */
    public function select()
    {
        $query = 'SELECT id, name FROM brand WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['BRAND'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    /**
     * @return array
     * Sélectionne des marques selon l'autocomplétion
     */
    public function selectBrandAuto()
    {
        $query = 'SELECT name FROM brand WHERE name LIKE :TERM';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':TERM', $this->value['term'].'%', PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectBrandAuto()

    /**
     * @return array
     * Sélectionne toutes les marques
     */
    public function selectAll()
    {
        $query = 'SELECT brand.name AS brand FROM vehicle
INNER JOIN model ON vehicle.model_id = model.id
INNER JOIN brand ON model.brand_id = brand.id
GROUP BY brand';

        $result = $this->bdd->prepare($query);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @return array
     * Sélectionne une marque selon son modèle
     */
    public function selectBrand()
    {
        $query = 'SELECT brand.name AS brand FROM brand
INNER JOIN model ON brand.id = model.brand_id
WHERE model.name LIKE :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['MODEL'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectBrand()

    /**
     * @return array
     * Vérifie l'existence d'une marque
     */
    public function exist()
    {
        $query = 'SELECT name FROM brand WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['BRAND'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // exist()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table BRAND
     */
    public function modify($_type)
    {
        switch ($_type)
        {
            case 'insert' : return $this->Insert();
            case 'update' : return $this->Update();
            case 'delete' : return $this->Delete();
        }

    } // modify($_type)

    /**
     * @return array
     * Insère un tuple dans la table BRAND
     */
    private function insert()
    {
        $query = "INSERT INTO brand(name) VALUES (:NAME)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['BRAND']), PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table BRAND
     */
    private function update()
    {
        $query = "UPDATE brand SET name = :NAME WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['NAME']), PDO::PARAM_STR);
        $result->bindValue(':ID', $this->value['ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table BRAND
     */
    private function delete()
    {
        $query = "DELETE FROM brand WHERE id = :ID";

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

} // class MBrand


?>