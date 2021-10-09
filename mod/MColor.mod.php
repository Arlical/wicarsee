<?php
/**
 * Class MColor de type Modèle gérant la table COLOR
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

class MColor extends Model
{
    /**
     * @return array
     * Sélectionne une couleur
     */
    public function select()
    {
        $query = 'SELECT id, name FROM color WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['COLOR'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // select()

    public function selectColorAuto()
    {
        $query = 'SELECT name FROM color WHERE name LIKE :TERM';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':TERM', $this->value['term'].'%', PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectColorAuto()

    /**
     * @return array
     * Vérifie l'existence d'une couleur
     */
    public function exist()
    {
        $query = 'SELECT name FROM color WHERE name = :NAME';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['COLOR'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetch();

    } // exist()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table COLOR
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
     * Insère un tuple dans la table COLOR
     */
    private function insert()
    {
        $query = "INSERT INTO color(name) VALUES (:NAME)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['COLOR']), PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table COLOR
     */
    private function update()
    {
        $query = "UPDATE color SET name = :NAME WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', strtolower($this->value['COLOR']), PDO::PARAM_STR);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table COLOR
     */
    private function delete()
    {
        $query = "DELETE FROM color WHERE id = :ID";

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

} // class MColor

?>