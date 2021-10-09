<?php
/**
 * Class MPicture de type Modèle gérant la table PICTURE
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

class MPicture extends Model
{
    /**
     * @return array
     * Sélectionne toutes les images d'une annonce
     */
    public function selectAll()
    {
        $query = 'SELECT name FROM picture WHERE advert_id = :ADVERT_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table PICTURE
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
     * Insère un tuple dans la table PICTURE
     */
    private function insert()
    {
        $query = "INSERT INTO picture(name, advert_id) VALUES (:NAME, :ADVERT_ID)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['NEW_PICTURE'], PDO::PARAM_STR);
        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_STR);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return mixed
     * Modifie un tuple dans la table PICTURE
     */
    private function update()
    {
        $query = "UPDATE picture SET name = :NAME WHERE advert_id = :ADVERT_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':NAME', $this->value['NEW_IMAGE'], PDO::PARAM_STR);
        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table PICTURE
     */
    private function delete()
    {
        $query = "DELETE FROM picture WHERE advert_id = :ADVERT_ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADVERT_ID', $this->value['ADVERT_ID'], PDO::PARAM_INT);

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

} // class MPicture

?>