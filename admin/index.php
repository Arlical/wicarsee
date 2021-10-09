<?php
/**
 * Contrôleur ADMIN
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */

// Inclusion du fichier des utilitaires de l'application
require('../inc/requireAdmin.inc.php');

// Lancement de la session
session_name('WICARSEE');
session_cache_limiter('private_no_expire, must-revalidate');
session_start();

// Instancie la variable de contrôle
$EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'formLogin';

// Contrôleur
switch ($EX)
{
    case 'formLogin':
        formLogin();
        break;

    case 'login':
        login();
        break;

    case 'logout':
        logout();
        break;

    case 'formAdmin':
        formAdmin();
        break;

    case 'editAdmin':
        editAdmin();
        break;

    case 'profile':
        profile();
        break;

    case 'insertAdmin':
        insertAdmin();
        break;

    case 'actionAdmin':
        actionAdmin();
        break;

    case 'deleteAdmin':
        deleteAdmin();
        break;

    case 'home':
        home();
        break;

    case 'adminAdvertiser':
        adminAdvertiser();
        break;

    case 'deleteAdvertiser':
        deleteAdvertiser();
        break;

    case 'adminAdvert':
        adminAdvert();
        break;

    case 'deleteAdvert':
        deleteAdvert();
        break;

    default:
        login();
}

// Inclusion du fichier de mise en page
require('../view/layoutAdmin.view.php');

function formLogin()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        header('Location: home');

        return;

    } else {
        global $content;

        $content['title'] = 'Administration - Wicarsee';
        $content['class'] = 'VAdmin';
        $content['method'] = 'formConnection';
        $content['arg'] = '';

        return;
    }

} // formLogin()

function login()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        header('Location: home');

        return;
    } else {

        $madmin = new MAdmin();
        $madmin->setValue($_POST);

        $password = $madmin->password();

        $isPasswordCorrect = password_verify($_POST['PASSWORD'], $password['password']);

        if (($data = $madmin->exist()) && $isPasswordCorrect) {
            $_SESSION['ADMIN_ID'] = $data['admin_id'];
            $_SESSION['ADMIN'] = $data['login'];
            $_SESSION['ADMIN_ROOT'] = $data['root'];

            header('Location: home');

            return;
        } else {
            header('Location: formLogin');

            return;
        }
    }
} // login()

function logout()
{
    session_destroy();

    unset($_SESSION['ADMIN_ID']);
    unset($_SESSION['ADMIN']);
    unset($_SESSION['ADMIN_ROOT']);

    header('Location: formLogin');

    return;

} // logout()

function editAdmin()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madmin = new MAdmin($_SESSION['ADMIN_ID']);

        $data['PROFILE'] = $madmin->profile();
        $data['ERROR_LOGIN'] = false;
        $data['ERROR_EMPTY'] = false;

        global $content;

        $content['title'] = 'Modification du compte - Wicarsee';
        $content['class'] = 'VAdmin';
        $content['method'] = 'formAdmin';
        $content['arg'] = $data;

        return;
    } else {
        header('Location: formLogin');

        return;
    }
} // editAdmin()

function formAdmin()
{
    if (isset($_SESSION['ADMIN_ID'])) {
        $data['PROFILE'] = false;
        $data['ERROR_LOGIN'] = false;
        $data['ERROR_EMPTY'] = false;

        global $content;

        $content['title'] = 'Ajout Admin - Wicarsee';
        $content['class'] = 'VAdmin';
        $content['method'] = 'formAdmin';
        $content['arg'] = $data;

        return;
    } else {
        header('Location: formLogin');

        return;
    }
} // formAdmin()

function insertAdmin()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madmin = new MAdmin($_SESSION['ADMIN_ID']);
        $madmin->setValue($_POST);

        if (empty($_POST['LOGIN']) && empty($_POST['PASSWORD']) && empty($_POST['ADMIN'])) {
            $data['ERROR_EMPTY'] = true;
            $data['ERROR_LOGIN'] = false;

            global $content;

            $content['title'] = 'Ajout Admin - Wicarsee';
            $content['class'] = 'VAdmin';
            $content['method'] = 'formAdmin';
            $content['arg'] = $data;

            return;

        } elseif ($madmin->loginExist()) {
            $data['ERROR_LOGIN'] = true;
            $data['ERROR_EMPTY'] = false;

            global $content;

            $content['title'] = 'Ajout Admin - Wicarsee';
            $content['class'] = 'VAdmin';
            $content['method'] = 'formAdmin';
            $content['arg'] = $data;

            return;
        } else {
            $_POST['PASSWORD'] = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

            $madmin->setValue($_POST);

            $madmin->modify('insert');

            header('Location: home');

            return;
        }
    } else {
        header('Location: formLogin');

        return;
    }
} // insertAdmin()

function actionAdmin()
{
    if ($_POST['ACTION'] == 'Modifier')
    {
        updateAdmin();
    }
    elseif ($_POST['ACTION'] == 'Supprimer')
    {
        deleteAdmin();
    }
} // actionAdmin()

function updateAdmin()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madmin = new MAdmin($_SESSION['ADMIN_ID']);
        $madmin->setValue($_POST);

        if ($madmin->loginExist()) {
            $data['PROFILE'] = $madmin->profile();
            $data['ERROR_LOGIN'] = true;

            global $content;

            $content['title'] = 'Ajout Admin - Wicarsee';
            $content['class'] = 'VAdmin';
            $content['method'] = 'editAdmin';
            $content['arg'] = $data;

            return;

        } elseif (empty($_POST['LOGIN']) && empty($_POST['PASSWORD']) && empty($_POST['ADMIN'])) {

            $data['ERROR_EMPTY'] = true;

            global $content;

            $content['title'] = 'Ajout Admin - Wicarsee';
            $content['class'] = 'VAdmin';
            $content['method'] = 'editAdmin';
            $content['arg'] = $data;

            return;
        } else {
            $_POST['PASSWORD'] = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

            $madmin->setValue($_POST);

            $madmin->modify('update');

            $_SESSION['ADMIN'] = $_POST['LOGIN'];
            $_SESSION['ADMIN_ROOT'] = $_POST['ROOT'];

            header('Location: profile');

            return;
        }
    } else {
        header('Location: formLogin');

        return;
    }

} // updateAdmin()

function deleteAdmin()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        if (isset($_GET['ADMIN_ID'])) {
            if ($_SESSION['ADMIN_ROOT'] == 0) {

                $madmin = new MAdmin($_SESSION['ADMIN_ID']);
                $madmin->setValue($_SESSION);

                $data['PROFILE'] = $madmin->profile();
                $data['ADMIN'] = $madmin->selectAll();
                $data['ERROR_ROOT'] = true;

                global $content;

                $content['title'] = 'Profil Admin - Wicarsee';
                $content['class'] = 'VAdmin';
                $content['method'] = 'showProfile';
                $content['arg'] = $data;

                return;
            } else {

                $madmin = new MAdmin($_GET['ADMIN_ID']);

                $madmin->modify('delete');

                header('Location: profile');

                return;
            }
        } elseif (isset($_SESSION['ADMIN_ID'])) {
            $madmin = new MAdmin($_SESSION['ADMIN_ID']);

            $madmin->modify('delete');

            session_destroy();

            unset($_SESSION['ADMIN_ID']);
            unset($_SESSION['ADMIN']);
            unset($_SESSION['ADMIN_ROOT']);

            header('Location: formLogin');

            return;
        }
    } else {
        header('Location: formLogin');

        return;
    }

} // deleteAdmin()

function profile()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madmin = new MAdmin($_SESSION['ADMIN_ID']);
        $madmin->setValue($_SESSION);

        $data['PROFILE'] = $madmin->profile();
        $data['ADMIN'] = $madmin->selectAll();
        $data['ERROR_ROOT'] = false;

        global $content;

        $content['title'] = 'Profil Admin - Wicarsee';
        $content['class'] = 'VAdmin';
        $content['method'] = 'showProfile';
        $content['arg'] = $data;

        return;
    } else {
        header('Location: formLogin');

        return;
    }
} // profile()


function home()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        global $content;

        $content['title'] = 'Administration - Wicarsee';
        $content['class'] = 'VHtml';
        $content['method'] = 'showHtml';
        $content['arg'] = '../html/admin.html';

        return;
    } else {
        header('Location: formLogin');

        return;
    }
} // home()

function adminAdvertiser()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $mindividual = new MIndividual();
        $mcompagny = new MCompagny();

        $data['INDIVIDUAL'] = $mindividual->selectAll();
        $data['COMPAGNY'] = $mcompagny->selectAll();
        $data['ERROR_ADVERT'] = false;
        $data['ERROR_ROOT'] = false;

        global $content;

        $content['title'] = 'Administration - Wicarsee';
        $content['class'] = 'VAdvertiser';
        $content['method'] = 'adminAdvertiser';
        $content['arg'] = $data;

        return;
    } else {
        header('Location: formLogin');

        return;
    }

} // adminAdvertiser()

function deleteAdvertiser()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madvertiser = new MAdvertiser($_GET['ADVERTISER_ID']);

        $mindividual = new MIndividual();
        $mcompagny = new MCompagny();

        if ($_SESSION['ADMIN_ROOT'] == 0) {
            $data['INDIVIDUAL'] = $mindividual->SelectAll();
            $data['COMPAGNY'] = $mcompagny->SelectAll();
            $data['ERROR_ADVERT'] = false;
            $data['ERROR_ROOT'] = true;

            global $content;

            $content['title'] = 'Administration - Wicarsee';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'adminAdvertiser';
            $content['arg'] = $data;

            return;
        }

        $mindividual->SetValue($_GET);
        $mcompagny->SetValue($_GET);

        $data['ADVERTS'] = $madvertiser->Adverts();
        $data['NUMBER'] = $madvertiser->NumberAdvert();

        if ($madvertiser->AdvertExist() && $data['PROFILE'] = $mindividual->Profile()) {
            $data['INDIVIDUAL'] = $mindividual->SelectAll();
            $data['COMPAGNY'] = $mcompagny->SelectAll();
            $data['ERROR_ADVERT'] = true;
            $data['ERROR_ROOT'] = false;

            global $content;

            $content['title'] = 'Administration - Wicarsee';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'adminAdvertiser';
            $content['arg'] = $data;

            return;

        } elseif ($madvertiser->AdvertExist() && $data['PROFILE'] = $mcompagny->Profile()) {
            $data['INDIVIDUAL'] = $mindividual->SelectAll();
            $data['COMPAGNY'] = $mcompagny->SelectAll();
            $data['ERROR_ADVERT'] = true;
            $data['ERROR_ROOT'] = false;

            global $content;

            $content['title'] = 'Administration - Wicarsee';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'adminAdvertiser';
            $content['arg'] = $data;

            return;
        }

        if ($mindividual->Profile()) {
            $mindividual->Modify('delete');
        } else {
            $mcompagny->Modify('delete');
        }

        $madvertiser->Modify('delete');

        header('Location: adminAdvertiser');

        return;
    } else {

        header('Location: formLogin');

        return;
    }

} // deleteAdvertiser()

function adminAdvert()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        $madvert = new MAdvert();

        $data['ADVERTS'] = $madvert->selectAll();
        $data['ERROR_ROOT'] = false;

        global $content;

        $content['title'] = 'Administration - Wicarsee';
        $content['class'] = 'VAdvert';
        $content['method'] = 'adminAdvert';
        $content['arg'] = $data;

        return;
    } else {
        header('Location: formLogin');

        return;
    }

} // adminAdvert()

function deleteAdvert()
{
    if (isset($_SESSION['ADMIN_ID'])) {

        if ($_SESSION['ADMIN_ROOT'] == 0) {
            $madvert = new MAdvert();

            $data['ADVERTS'] = $madvert->selectAll();
            $data['ERROR_ROOT'] = true;

            global $content;

            $content['title'] = 'Administration - Wicarsee';
            $content['class'] = 'VAdvert';
            $content['method'] = 'adminAdvert';
            $content['arg'] = $data;

            return;

        } else {

            $madvert = new MAdvert($_GET['ADVERT_ID']);
            $vehicle_id = $madvert->selectIdVehicle();
            $mvehicle = new MVehicle($vehicle_id['vehicle_id']);
            $mpicture = new MPicture();

            $mvehicle->setValue($_GET);
            $mpicture->setValue($_GET);

            $data = $mpicture->selectAll();

            foreach ($data as $img) {
                unlink(UPLOAD . $img['name']);
            }

            $data = $madvert->SelectMiniature();
            unlink(UPLOAD . $data['miniature']);

            $mpicture->Modify('delete');
            $madvert->Modify('delete');
            $mvehicle->Modify('delete');

            header('Location: adminAdvert');

            return;
        }
    } else {
        header('Location: formLogin');

        return;
    }
} // deleteAdvert()
