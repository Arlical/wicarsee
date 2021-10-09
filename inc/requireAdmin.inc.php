<?php

// Récupère le chemin absolu du répertoire Inc et le transforme pour le répertoire Upload
$path = str_replace('inc', 'upload', realpath('../inc')) . '\\';

// Répertoire pour le téléchargement
define ('UPLOAD', $path);

define('DEBUG', true);

// Constante connexion à la BDD
define('DATABASE', 'mysql:host=localhost;dbname=wicarsee;charset=utf8');
define('LOGIN', 'root');
define('PASSWORD', '');

function my_autoloader($class) {

    switch ($class[0])
    {
        // Inclusion des class de type View
        case 'V' : require_once('../view/'.$class.'.view.php');
            break;
        // Inclusion des class de type Mod
        case 'M' : require_once('../mod/'.$class.'.mod.php');
            break;
    }

    return;
} // my_autoloader($class)

spl_autoload_register('my_autoloader');

function upload($file)
{
    // Découpe $file['name'] en tableau avec comme séparateur le point
    $tab = explode('.', $file['name']);

    // Transforme les caractères accentués en entités HTML
    $fichier = htmlentities($tab[0], ENT_NOQUOTES);

    // Remplace les entités HTML pour avoir juste le premier caractères non accentués
    $fichier = preg_replace('#&([A-za-z])(?:acute|grave|circ|uml|tilde|ring|cedil|lig|orn|slash|th|eg);#', '$1', $fichier);

    // Elimination des caractères non alphanumériques
    $fichier = preg_replace('#\W#', '', $fichier);

    // Troncation du nom de fichier à 21 caractères
    $fichier = substr($fichier, 0, 21);

    // Choix du format d'image
    switch(exif_imagetype($file['tmp_name']))
    {
        case IMAGETYPE_GIF  : $format = '.gif'; break;
        case IMAGETYPE_JPEG : $format = '.jpg'; break;
        case IMAGETYPE_PNG  : $format = '.png'; break;
    }

    // Ajout du time devant le fichier pour obtenir un fichier unique
    $fichier = time() . '_' . $fichier . $format;

    return $fichier;

} // upload($file)

function redimensionne($file, $width_new, $height_new)
{
    // Retourne les dimensions et le mime à partir du fichier image
    $tab = getimagesize($file);
    $width_old = $tab[0];
    $height_old = $tab[1];
    $mime_old = $tab['mime'];

    // Ratio pour la mise à l'échelle
    $ratio = $width_old/$height_old;

    // Redimensionnement suivant le ratio
    if ($width_new/$height_new > $ratio)
    {
        $width_new = $height_new*$ratio;
    }
    else
    {
        $height_new = $width_new/$ratio;
    }

    // Nouvelle image redimensionnée
    $image_new = imagecreatetruecolor($width_new, $height_new);

    // Création d'une image à partir du fichier image et suivant le mime
    switch ($mime_old)
    {
        case 'image/png' :  $image_old = imagecreatefrompng($file); break;
        case 'image/jpeg' : $image_old = imagecreatefromjpeg($file); break;
        case 'image/gif' :  $image_old = imagecreatefromgif($file); break;
    }

    // Copie et redimensionne l'ancienne image dans la nouvelle
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $width_new, $height_new, $width_old, $height_old);

    // Retourne la nouvelle image redimensionnée (Attention ce n'est pas un fichier mais une image)
    return $image_new;

} // redimensionne($file_image)

function strip_xss(&$val)
{
    // Teste si $val est un tableau
    if (is_array($val))
    {
        // Si $val est un tableau, on réapplique la fonction strip_xss()
        array_walk($val, 'strip_xss');
    }
    else if (is_string($val))
    {
        // Si $val est une string, on filtre avec strip_tags()
        $val = strip_tags($val);
    }

} // strip_xss(&$val)

if (DEBUG)
{
    // Détecte toutes les erreurs
    error_reporting(E_ALL);
    // Affiche les erreurs
    ini_set('display_errors', 1);

    function debug($Tab)
    {
        echo '<pre>Tab';
        print_r($Tab);
        echo '</pre>';

    } // debug($Tab)
}

?>
