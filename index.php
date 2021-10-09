<?php
/**
 * Contrôleur INDEX
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

// Inclusion du fichier des utilitaires de l'application
require('Inc/require.inc.php');

// Lancement de la session
session_name('WICARSEE');
session_cache_limiter('private_no_expire, must-revalidate');
session_start();

// Instancie la variable de contrôle
$EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

// Contrôleur
switch ($EX)
{
    case 'home':
        home();
        break;

    case 'filter':
        filter();
        break;

    case 'terms':
        terms();
        break;

    case 'notice':
        notice();
        break;

    case 'cookie':
        cookie();
        break;

    case 'policy':
        policy();
        break;

    default:
        home();
}

// Inclusion du fichier de mise en page
require('View/layout.view.php');

// Pour l'affichage de la page d'accueil
function home()
{
    // Sélectionne toute les marques de voiture
    $mbrand = new MBrand();
    $data['BRAND'] = $mbrand->selectAll();

    // Sélectionne tous les modèles de voiture
    $mmodel = new MModel();
    $data['MODEL'] = $mmodel->selectAll();

    // Sélectionne tous les type de carburants de voiture
    $mfuel = new MFuel();
    $data['FUEL'] = $mfuel->selectAll();

    global $content;

    $content['title'] = 'Accueil';
    $content['class'] = 'VVehicle';
    $content['method'] = 'showFilter';
    $content['arg'] = $data;

    return;

} // home()

// Pour le filtre en AJAX avec selection en marque -> modèle et modèle -> marque
function filter()
{
    if (isset($_POST['BRAND']) && $_POST['BRAND'] != 'Marque')
    {
        $mmodel = new MModel();
        $mmodel->setValue($_POST);

        $data = $mmodel->selectModel();

        $vvehicle = new VVehicle();
        $vvehicle->showFilterModel($data);

        exit();
    }
    elseif (isset($_POST['MODEL']) && $_POST['MODEL'] != 'Modèle')
    {
        $mbrand = new MBrand();
        $mbrand->setValue($_POST);

        $data = $mbrand->selectBrand();

        $vvehicle = new VVehicle();
        $vvehicle->showFilterBrand($data);

        exit();
    }

    if (isset($_POST['BRAND']) && $_POST['BRAND'] == 'Marque')
    {
        $mmodel = new MModel();

        $data = $mmodel->selectAll();

        $vvehicle = new VVehicle();
        $vvehicle->showFilterModel($data);

        exit();
    }
    elseif (isset($_POST['MODEL']) && $_POST['MODEL'] == 'Modèle')
    {
        $mbrand = new MBrand();

        $data = $mbrand->selectAll();

        $vvehicle = new VVehicle();
        $vvehicle->showFilterBrand($data);

        exit();
    }

} // filter()

// Pour l'affichage des conditions générales'
function terms()
{
    global $content;

    $content['title'] = 'Conditions générales';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = 'html/terms.html';

    return;

} // terms()

// Pour l'affichage des mentions légales
function notice()
{
    global $content;

    $content['title'] = 'Mentions légales';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = 'html/notice.html';

    return;

} // notice()

// Pour l'affichage de la page de cookie
function cookie()
{
    global $content;

    $content['title'] = 'Cookies';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = 'html/cookie.html';

    return;

} // cookie()

// Pour l'affichage de la page de politique de confidentialité
function policy()
{
    global $content;

    $content['title'] = 'Politique de confidentialité';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = 'html/policy.html';

    return;

} // policy()
