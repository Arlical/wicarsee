<?php
/**
 * Class MAdmin de type Modèle gérant la table ADMIN
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

require_once('Model.mod.php');

/**
 * Class MAdmin
 */
class MAdmin extends Model
{
    /**
     * @return array
     * Sélectionne tous les administrateurs
     */
    public function selectAll()
    {
        $query = 'SELECT admin.id, admin.login, admin.password, admin.root FROM admin 
WHERE admin.login != :LOGIN';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['ADMIN'], PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();

    } // selectAll()

    /**
     * @return mixed
     * Sélectionne un administrateur en fonction de son login pour voir s'il existe
     */
    public function exist()
    {
        $query = 'SELECT admin.id AS admin_id, admin.login, admin.password, admin.root FROM admin 
WHERE admin.login LIKE :LOGIN';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // exist()

    /**
     * @return mixed
     * Sélectionne le mot de passe d'un administrateur en fonction de son login
     */
    public function password()
    {
        $query = 'SELECT admin.password FROM admin 
WHERE admin.login LIKE :LOGIN';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // password()

    /**
     * @return mixed
     * Sélectionne un administrateur en fonction de son id
     */
    public function profile()
    {
        $query = 'SELECT admin.id, admin.login, admin.password, admin.root FROM admin WHERE admin.id = :ADMIN_ID';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ADMIN_ID', $this->id, PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // profile()

    /**
     * @return mixed
     * Sélectionne un administrateur en fonction de son login pour vérifier que le login n'existe pas déjà
     */
    public function loginExist()
    {
        $query = 'SELECT admin.login FROM admin WHERE admin.login LIKE :LOGIN';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // loginExist()

    /**
     * @return mixed
     * Surement à supprimer (elle sert à nada)
     * Si elle sert frangin pour update le login ;)
     */
    public function loginExistUpdate()
    {
        $query = 'SELECT admin.login FROM admin WHERE admin.login != :LOGIN';

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // loginExistUpdate()

    /**
     * @param string
     * @return void
     * Gère un tuple de la table ADMIN
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
     * Insère un tuple dans la table ADMIN
     */
    private function insert()
    {
        $query = "INSERT INTO admin(login, password, root) 
VALUES (:LOGIN, :PASSWORD, :ROOT)";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);
        $result->bindValue(':PASSWORD', $this->value['PASSWORD'], PDO::PARAM_STR);
        $result->bindValue(':ROOT', $this->value['ROOT'], PDO::PARAM_BOOL);

        $result->execute() or die ($this->errorSQL($result));

        $this->id = $this->bdd->lastInsertId();

        $this->value['ID'] = $this->id;

        return $this->value;

    } // insert()

    /**
     * @return array
     * Modifie un tuple dans la table ADMIN
     */
    private function update()
    {
        $query = "UPDATE admin SET login = :LOGIN, password = :PASSWORD, root = :ROOT WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':LOGIN', $this->value['LOGIN'], PDO::PARAM_STR);
        $result->bindValue(':PASSWORD', $this->value['PASSWORD'], PDO::PARAM_STR);
        $result->bindValue(':ROOT', $this->value['ROOT'], PDO::PARAM_BOOL);
        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        $this->value['ID'] = $this->id;

        return $this->value;

    } // update()

    /**
     * @return void
     * Supprime un tuple dans la table ADMIN
     */
    private function delete()
    {
        $query = "DELETE FROM admin WHERE id = :ID";

        $result = $this->bdd->prepare($query);

        $result->bindValue(':ID', $this->id, PDO::PARAM_INT);

        $result->execute() or die ($this->errorSQL($result));

        return;

    } // delete()

    private function errorSQL($result)
    {
        if (!DEBUG) return;

        $error = $result->errorInfo();

        debug($error);

        return;

    } // errorSQL($result)

} // class MAdmin