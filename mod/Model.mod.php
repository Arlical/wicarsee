<?php
/**
 * Class Model servant de classe mère pour les différentes classes de type modèle
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

class Model
{
    /**
     * @var
     */
    protected $db;

    /**
     * @var null
     */
    protected $id;

    /**
     * @var
     */
    protected $value;

    /**
     * Model constructor.
     * @param null $_id
     */
    public function __construct($_id = null)
    {
        $this->bdd = new PDO(DATABASE, LOGIN, PASSWORD);

        $this->id = $_id;

        return;
    }

    /**
     * Model destructor.
     */
    public function __destruct() {}

    /**
     * @param $_value
     */
    public function setValue($_value)
    {
        $this->value = $_value;

        return;

    } // SetValue($_value)

} // class Model

?>