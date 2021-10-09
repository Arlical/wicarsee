<?php
/**
 * Contrôleur ADVERT
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

// Inclusion du fichier des utilitaires de l'application
require('inc/require.inc.php');

// Lancement de la session
session_name('WICARSEE');
session_cache_limiter('private_no_expire, must-revalidate');
session_start();

// Instancie la variable de contrôle
$EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

// Contrôleur
switch ($EX)
{
    case 'adverts':
        adverts();
        break;

    case 'paginationAdverts':
        paginationAdverts();
        break;

    case 'advert':
        advert();
        break;

    case 'formAdvert':
        formAdvert();
        break;

    case 'autocomplete':
        autocomplete();
        break;

    case 'insertAdvert':
        insertAdvert();
        break;

    case 'updateAdvert':
        updateAdvert();
        break;

    case 'actionAdvert':
        actionAdvert();
        break;
}

// Inclusion du fichier de mise en page
require('view/layout.view.php');

// Affiche les annonces en fonction du filtre
function adverts()
{
    if (isset($_POST['BRAND']) AND $_POST['BRAND'] != 'Marque')
    {
        $brand = ' brand.name LIKE \'' . $_POST['BRAND'] . '\'';
    }
    else
    {
        $brand = '';
    }

    if (isset($_POST['MODEL']) AND $_POST['MODEL'] != 'Modèle')
    {
        $model = (empty($brand)) ? ' model.name LIKE \'' . $_POST['MODEL'] . '\'' : ' AND model.name LIKE \'' . $_POST['MODEL'] . '\'';
    }
    else
    {
        $model = '';
    }

    if (!empty($_POST['PRICE_MAX']))
    {
        $price_max = (empty($brand) AND empty($model)) ? ' vehicle.price < ' . $_POST['PRICE_MAX'] : ' AND vehicle.price < ' . $_POST['PRICE_MAX'];
    }
    else
    {
        $price_max = '';
    }

    if (isset($_POST['FUEL']) AND $_POST['FUEL'] != 'Carburant')
    {
        $fuel = (empty($brand) AND empty($model) AND empty($price_max)) ? ' fuel.name LIKE \'' . $_POST['FUEL'] . '\'' : ' AND fuel.name LIKE \'' . $_POST['FUEL'] . '\'';
    }
    else
    {
        $fuel = '';
    }

    $data['CONDITION'] = $brand . $model . $price_max . $fuel;
    $data['LIMIT'] = '0,10';

    if (!empty($data['CONDITION']))
    {
        $madvert = new MAdvert();
        $madvert->setValue($data);
        $data['ADVERT'] = $madvert->selectFilter();
        $data['COUNT'] = $madvert->countAdvertFilter();

        $data['NB_PAGE'] = ceil($data['COUNT']['number_advert'] / 10);
        $data['ACTIVE'] = 0;

        $_SESSION['CONDITION'] = $data['CONDITION'];
    }
    else
    {
        unset($_SESSION['CONDITION']);
        $limit = '0,10';
        $madvert = new MAdvert();
        $madvert->setValue($limit);
        $data['ADVERT'] = $madvert->selectAllLimit();
        $data['COUNT'] = $madvert->countAdvertAll();

        $data['NB_PAGE'] = ceil($data['COUNT']['number_advert'] / 10);
        $data['ACTIVE'] = 0;
    }

    global $content;

    $content['title'] = 'Annonces';
    $content['class'] = 'VAdvert';
    $content['method'] = 'showAdverts';
    $content['arg'] = $data;

    return;

} // adverts()

// Pour le système de pagination
function paginationAdverts()
{
    if (!isset($_SESSION['CONDITION']))
    {
        $limit = $_GET['PAGE'] * 10 . ',10';

        $madvert = new MAdvert();
        $madvert->setValue($limit);
        $data['ADVERT'] = $madvert->selectAllLimit();
        $data['COUNT'] = $madvert->countAdvertAll();

        $data['NB_PAGE'] = ceil($data['COUNT']['number_advert'] / 10);
        $data['ACTIVE'] = $_GET['PAGE'];
    }
    else
    {
        $data['CONDITION'] = $_SESSION['CONDITION'];
        $data['LIMIT'] = $_GET['PAGE'] * 10 . ',10';

        $madvert = new MAdvert();
        $madvert->setValue($data);
        $data['ADVERT'] = $madvert->selectFilter();
        $data['COUNT'] = $madvert->countAdvertFilter();

        $data['NB_PAGE'] = ceil($data['COUNT']['number_advert'] / 10);
        $data['ACTIVE'] = $_GET['PAGE'];

        echo $data['COUNT']['number_advert'];
    }

    global $content;

    $content['title'] = 'Annonces';
    $content['class'] = 'VAdvert';
    $content['method'] = 'showAdverts';
    $content['arg'] = $data;

    return;

} // paginationAdverts

// Pour l'affichage d'une annonce
function advert()
{
    $madvert = new MAdvert($_GET['ADVERT_ID']);
    $mpicture = new MPicture();
    $mpicture->setValue($_GET);
    $data['PICTURE'] = $mpicture->selectAll();
    $data['ADVERT'] = $madvert->select();

    $mindividual = new MIndividual();
    $mindividual->setValue($_GET);

    $mcompagny = new MCompagny();
    $mcompagny->setValue($_GET);

    if (!$data['ADVERTISER'] = $mcompagny->select())
    {
        $data['ADVERTISER'] = $mindividual->select();
    }

    array_walk($data, 'strip_xss');

    global $content;

    $content['title'] = 'Annonce';
    $content['class'] = 'VAdvert';
    $content['method'] = 'showAdvert';
    $content['arg'] = $data;

    return;

} // advert()

// Formulaire pour ajouter/modifier une annonce
function formAdvert()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {

        if (isset($_POST['ADVERT_ID'])) {
            $mvehicle = new MVehicle();
            $mvehicle->setValue($_POST);
            $data['ADVERT_ID'] = $_POST['ADVERT_ID'];
            $data['VEHICLE'] = $mvehicle->select();
            $data['ERROR'] = false;

            $_SESSION['ADVERT_ID'] = $_POST['ADVERT_ID'];
            $_SESSION['VEHICLE_ID'] = $data['VEHICLE']['id'];

            global $content;

            $content['title'] = 'Modifier votre annonce';
            $content['class'] = 'VAdvert';
            $content['method'] = 'formAdvert';
            $content['arg'] = $data;

            return;
        } else {
            $data['VEHICLE'] = null;
            $data['ERROR'] = false;

            global $content;

            $content['title'] = 'Inserer votre annonce';
            $content['class'] = 'VAdvert';
            $content['method'] = 'formAdvert';
            $content['arg'] = $data;

            return;
        }
    } else {
        header('Location: formLogin');
    }

} // formAdvert()

//Pour le système d'autocomplétion pour le formulaire d'ajout d'une annonce
function autocomplete()
{
    if ($_GET['TYPE'] == 'brand')
    {
        $mbrand = new MBrand();
        $mbrand->setValue($_GET);

        $data = $mbrand->selectBrandAuto();
        $array = array();

        foreach ($data as $val)
        {
            array_push($array, ucfirst($val['name']));
        }

        echo json_encode($array);
        exit();
    }
    elseif ($_GET['TYPE'] == 'model')
    {
        $mmodel = new MModel();
        $mmodel->setValue($_GET);

        $data = $mmodel->selectModelAuto();
        $array = array();

        foreach ($data as $val)
        {
            array_push($array, ucfirst($val['name']));
        }

        echo json_encode($array);
        exit();
    }
    elseif ($_GET['TYPE'] == 'color')
    {
        $mcolor = new MColor();
        $mcolor->setValue($_GET);

        $data = $mcolor->selectColorAuto();
        $array = array();

        foreach ($data as $val)
        {
            array_push($array, ucfirst($val['name']));
        }

        echo json_encode($array);
        exit();
    }
} // autocomplete()

function insertAdvert()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {

        if (empty($_POST['BRAND']) || empty($_POST['MODEL']) || empty($_POST['GEARBOX_ID']) || empty($_POST['FUEL_ID']) || empty($_POST['COLOR']) || empty($_POST['YEAR']) || empty($_POST['NUMBER_KILOMETERS']) || empty($_POST['PRICE']) || empty($_FILES['PICTURE1']) || empty($_POST['DESCRIPTION'])) {
            $data['ERROR'] = true;
            $data['VEHICLE'] = null;

            global $content;

            $content['title'] = 'Inserer votre annonce';
            $content['class'] = 'VAdvert';
            $content['method'] = 'formAdvert';
            $content['arg'] = $data;

            return;
        } else {
            $mcolor = new MColor();
            $mcolor->setValue($_POST);

            if (!$mcolor->exist()) {
                $color_id = $mcolor->modify('insert');
                $_POST['COLOR_ID'] = $color_id['ID'];
            } else {
                $color_id = $mcolor->select();
                $_POST['COLOR_ID'] = $color_id['id'];
            }

            $mbrand = new MBrand();
            $mbrand->setValue($_POST);

            if (!$mbrand->exist()) {
                $brand_id = $mbrand->modify('insert');
                $_POST['BRAND_ID'] = $brand_id['ID'];
            } else {
                $brand_id = $mbrand->select();
                $_POST['BRAND_ID'] = $brand_id['id'];
            }

            $mmodel = new MModel();
            $mmodel->setValue($_POST);

            if (!$mmodel->exist()) {
                $model_id = $mmodel->modify('insert');
                $_POST['MODEL_ID'] = $model_id['ID'];
            } else {
                $model_id = $mmodel->select();
                $_POST['MODEL_ID'] = $model_id['id'];
            }

            $mvehicle = new MVehicle();
            $mvehicle->setValue($_POST);
            $vehicle_id = $mvehicle->modify('insert');

            $file_miniature_new = upload($_FILES['PICTURE1']);

            $miniature_new = redimensionne($_FILES['PICTURE1']['tmp_name'], 230, 205);

            switch ($_FILES['PICTURE1']['type']) {
                case 'image/png'  :
                    imagepng($miniature_new, UPLOAD . $file_miniature_new, 0);
                    break;
                case 'image/jpeg' :
                    imagejpeg($miniature_new, UPLOAD . $file_miniature_new, 100);
                    break;
                case 'image/gif'  :
                    imagegif($miniature_new, UPLOAD . $file_miniature_new);
                    break;
            }

            $_POST['MINIATURE'] = $file_miniature_new;
            $_POST['ADVERTISER_ID'] = $_SESSION['ADVERTISER_ID'];
            $_POST['VEHICLE_ID'] = $vehicle_id['ID'];

            $madvert = new MAdvert();
            $madvert->setValue($_POST);
            $advert_id = $madvert->modify('insert');

            $mpicture = new MPicture();

            //////////////////////////////////////////////////////////////////

            for ($i = 1; $i <= sizeof($_FILES); $i++) {
                $picture_new = redimensionne($_FILES['PICTURE' . $i]['tmp_name'], 739, 554);

                $file_new = 'picture_n' . $i . '_' . $file_miniature_new;

                switch ($_FILES['PICTURE' . $i]['type']) {
                    case 'image/png'  :
                        imagepng($picture_new, UPLOAD . $file_new, 0);
                        break;
                    case 'image/jpeg' :
                        imagejpeg($picture_new, UPLOAD . $file_new, 100);
                        break;
                    case 'image/gif'  :
                        imagegif($picture_new, UPLOAD . $file_new);
                        break;
                }

                $_POST['NEW_PICTURE'] = $file_new;
                $_POST['ADVERT_ID'] = $advert_id['ID'];

                $mpicture->setValue($_POST);
                $mpicture->modify('insert');
            }

            /////////////////////////////////////////////////////////////////

            header('Location: home');

            return;
        }
    } else {
        header('Location: formLogin');
    }

} // insertAdvert()

function actionAdvert()
{
    if ($_POST['ACTION'] == 'Ajouter une annonce')
    {
        formAdvert();
    }
    elseif ($_POST['ACTION'] == 'Editer mon annonce')
    {
        formAdvert();
    }
    elseif ($_POST['ACTION'] == 'Supprimer mon annonce')
    {
        deleteAdvert();
    }

} // actionAdvert()

function updateAdvert()
{
    if ($_SESSION['ADVERT_ID'] != $_GET['VEHICLE_ID'])
    {
        header('Location: formAdvert');
    } else {

        $madvert = new MAdvert($_SESSION['ADVERT_ID']);
        $mvehicle = new MVehicle($_SESSION['VEHICLE_ID']);
        $mpicture = new MPicture();

        $mpicture->setValue($_GET);

        $data = $mpicture->selectAll();

        foreach ($data as $img) {
            unlink(UPLOAD . $img['name']);
        }

        $data = $madvert->selectMiniature();
        unlink(UPLOAD . $data['miniature']);

        $mcolor = new MColor();
        $mcolor->setValue($_POST);

        if (!$mcolor->exist()) {
            $color_id = $mcolor->modify('insert');
            $_POST['COLOR_ID'] = $color_id['ID'];
        } else {
            $color_id = $mcolor->select();
            $_POST['COLOR_ID'] = $color_id['id'];
        }

        $mbrand = new MBrand();
        $mbrand->setValue($_POST);

        if (!$mbrand->exist()) {
            $brand_id = $mbrand->modify('insert');
            $_POST['BRAND_ID'] = $brand_id['ID'];
        } else {
            $brand_id = $mbrand->select();
            $_POST['BRAND_ID'] = $brand_id['id'];
        }

        $mmodel = new MModel();
        $mmodel->setValue($_POST);

        if (!$mmodel->exist()) {
            $model_id = $mmodel->modify('insert');
            $_POST['MODEL_ID'] = $model_id['ID'];
        } else {
            $id_model = $mmodel->select();
            $_POST['MODEL_ID'] = $id_model['id'];
        }

        $mvehicle->setValue($_POST);
        $mvehicle->modify('update');

        $file_miniature_new = upload($_FILES['PICTURE1']);

        $miniature_new = redimensionne($_FILES['PICTURE1']['tmp_name'], 230, 205);

        switch ($_FILES['PICTURE1']['type']) {
            case 'image/png'  :
                imagepng($miniature_new, UPLOAD . $file_miniature_new, 0);
                break;
            case 'image/jpeg' :
                imagejpeg($miniature_new, UPLOAD . $file_miniature_new, 100);
                break;
            case 'image/gif'  :
                imagegif($miniature_new, UPLOAD . $file_miniature_new);
                break;
        }

        $_POST['MINIATURE'] = $file_miniature_new;

        $madvert->setValue($_POST);
        $madvert->modify('update');

        $mpicture->setValue($_GET);
        $mpicture->modify('delete');

        for ($i = 1; $i <= sizeof($_FILES); $i++) {
            $picture_new = redimensionne($_FILES['PICTURE' . $i]['tmp_name'], 739, 554);

            $file_new = 'picture_n' . $i . '_' . $file_miniature_new;

            switch ($_FILES['PICTURE' . $i]['type']) {
                case 'image/png'  :
                    imagepng($picture_new, UPLOAD . $file_new, 0);
                    break;
                case 'image/jpeg' :
                    imagejpeg($picture_new, UPLOAD . $file_new, 100);
                    break;
                case 'image/gif'  :
                    imagegif($picture_new, UPLOAD . $file_new);
                    break;
            }

            $_POST['NEW_PICTURE'] = $file_new;
            $_POST['ADVERT_ID'] = $_SESSION['ADVERT_ID'];

            $mpicture->setValue($_POST);
            $mpicture->modify('insert');
        }

        header('Location: profile');

        return;
    }

} // updateAdvert()

function deleteAdvert()
{
    $madvert = new MAdvert($_POST['ADVERT_ID']);
    $vehicle_id = $madvert->selectIdVehicle();
    $mvehicle = new MVehicle($vehicle_id['vehicle_id']);
    $mpicture = new MPicture();

    $mvehicle->setValue($_POST);
    $mpicture->setValue($_POST);

    $data = $mpicture->selectAll();

    foreach ($data as $img)
    {
        unlink(UPLOAD . $img['name']);
    }

    $data = $madvert->selectMiniature();
    unlink(UPLOAD . $data['miniature']);

    $mpicture->modify('delete');
    $madvert->modify('delete');
    $mvehicle->modify('delete');

    header('Location: profile');

    return;

} // deleteAdvert()
