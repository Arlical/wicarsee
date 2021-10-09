<?php

/**
 * Class VHtml de type Vue pour l'affichage des pages html
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VHtml
{

    /**
     * VHtml constructor.
     */
    public function __construct() {}

    /**
     * VHtml destructor.
     */
    public function __destruct() {}

    /**
     * @param $_html
     * Gère l'inclusion de fichier html
     */
    public function showHtml($_html)
    {
        (file_exists($_html)) ? include($_html) : include('../Html/unknown.html');

    } // showHtml($_html)

} // class VHtml

?>