<?php
/**
 * Contrôleur ADVERTISER
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
    case 'formLogin':
        formLogin();
        break;

    case 'forgotPassword':
        forgotPassword();
        break;

    case 'sendMail':
        sendMail();
        break;

    case 'formResetPassword':
        formResetPassword();
        break;

    case 'resetPassword':
        resetPassword();
        break;

    case 'login':
        login();
        break;

    case 'logout':
        logout();
        break;

    case 'profile':
        profile();
        break;

    case 'formAdvertiser':
        formAdvertiser();
        break;

    case 'insertAdvertiser':
        insertAdvertiser();
        break;

    case 'updateAdvertiser':
        updateAdvertiser();
        break;

    case 'deleteAdvertiser':
        deleteAdvertiser();
        break;
}

// Inclusion du fichier de mise en page
require('view/layout.view.php');

// Pour l'affichage du formulaire de connexion (login)
function formLogin()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;

    } else {
        global $content;

        $data['ERROR_VALID'] = false;
        $data['ERROR_EMPTY'] = false;

        $content['title'] = 'Connexion';
        $content['class'] = 'VAdvertiser';
        $content['method'] = 'formLogin';
        $content['arg'] = $data;

        return;
    }

} // formLogin()

// Affiche le formulaire pour l'oublie du mot de passe
function forgotPassword()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;

    } else {
        $data['ERROR_VALID'] = false;
        $data['ERROR_EMPTY'] = false;
        $data['MAIL'] = false;
        $data['ERROR_MAIL'] = false;

        global $content;

        $content['title'] = 'Mot de passe oublié';
        $content['class'] = 'VAdvertiser';
        $content['method'] = 'formMail';
        $content['arg'] = $data;

        return;
    }

} // forgotPassword()

// Pour l'envoie du mail de réatinilsation du mot de passe
function sendMail()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;
    } else {
        $madvertiser = new MAdvertiser();
        $madvertiser->setValue($_POST);

        if (empty($_POST['MAIL'])) {
            $data['ERROR_VALID'] = false;
            $data['ERROR_EMPTY'] = true;
            $data['MAIL'] = false;
            $data['ERROR_MAIL'] = false;

            global $content;

            $content['title'] = 'Mot de passe oublié';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formMail';
            $content['arg'] = $data;

            return;
        } elseif (!$data = $madvertiser->emailExist()) {
            $data['ERROR_VALID'] = true;
            $data['ERROR_EMPTY'] = false;
            $data['MAIL'] = false;
            $data['ERROR_MAIL'] = false;

            global $content;

            $content['title'] = 'Mot de passe oublié';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formMail';
            $content['arg'] = $data;

            return;
        } else {
            $headers = "From: clientpro@wicarsee.fr\n";
            $headers .= "Reply-To: clientpro@wicarsee.fr\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $to = $_POST['MAIL'];
            $subject = "Réinitialiser son mot de passe Wicarsee LtD : " . $_POST['MAIL'];
            $body = file_get_contents("html/mail.html");

            if (mail($to, $subject, $body, $headers)) {
                $data['MAIL'] = true;
                $data['ERROR_MAIL'] = false;
                $data['ERROR_VALID'] = false;
                $data['ERROR_EMPTY'] = false;
            } else {
                $data['ERROR_MAIL'] = true;
                $data['MAIL'] = false;
                $data['ERROR_VALID'] = false;
                $data['ERROR_EMPTY'] = false;
            }

            global $content;

            $content['title'] = 'Mot de passe oublié';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formMail';
            $content['arg'] = $data;

            return;
        }
    }
} // sendMail()

function formResetPassword() {

    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;
    } else {
        $data['ERROR_EMPTY'] = false;
        $data['ERROR_VALID'] = false;
        $data['ERROR_PASSWORD'] = false;

        global $content;

        $content['title'] = 'Réinitialiser votre mot de passe';
        $content['class'] = 'VAdvertiser';
        $content['method'] = 'formResetPassword';
        $content['arg'] = $data;

        return;
    }
} // formResetPassword()

// Réatiniliser le mot de passe
function resetPassword() {

    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;
    } else {
        $madvertiser = new MAdvertiser();
        $madvertiser->setValue($_POST);

        if ($_POST['PASSWORD'] != $_POST['PASSWORD_CONFIRM']) {
            $data['ERROR_EMPTY'] = false;
            $data['ERROR_VALID'] = false;
            $data['ERROR_PASSWORD'] = true;

            global $content;

            $content['title'] = 'Réinitialiser votre mot de passe';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formResetPassword';
            $content['arg'] = $data;

            return;

        } elseif (!$madvertiser->emailExist()) {
            $data['ERROR_EMPTY'] = false;
            $data['ERROR_VALID'] = true;
            $data['ERROR_PASSWORD'] = false;

            global $content;

            $content['title'] = 'Réinitialiser votre mot de passe';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formResetPassword';
            $content['arg'] = $data;

            return;

        } elseif (empty($_POST['MAIL']) || empty($_POST['PASSWORD']) || empty($_POST['PASSWORD_CONFIRM'])) {
            $data['ERROR_EMPTY'] = true;
            $data['ERROR_VALID'] = false;
            $data['ERROR_PASSWORD'] = false;

            global $content;

            $content['title'] = 'Réinitialiser votre mot de passe';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formResetPassword';
            $content['arg'] = $data;

            return;

        } else {
            //Pour se loger direct après être inscrit
            $_SESSION['PASSWORD'] = $_POST['PASSWORD'];
            $_SESSION['MAIL'] = $_POST['MAIL'];

            $_POST['PASSWORD'] = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

            $madvertiser->setValue($_POST);

            $id = $madvertiser->updatePassword();

            $_POST['ADVERTISER_ID'] = $id['ID'];

            header('Location: login');

            return;
        }
    }
} // resetPassword()

// Pour la connexion
function login()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {
        header('Location: home');

        return;
    } else {
        // Pour se loger direct après c'être inscrit
        if (isset($_SESSION['PASSWORD'])) {
            $_POST['PASSWORD'] = $_SESSION['PASSWORD'];
            $_POST['MAIL'] = $_SESSION['MAIL'];
        }

        if (isset($_POST['MAIL']) && isset($_POST['PASSWORD'])) {

            $madvertiser = new MAdvertiser();
            $madvertiser->setValue($_POST);

            $password = $madvertiser->password();

            $isPasswordCorrect = password_verify($_POST['PASSWORD'], $password['password']);

            $mindividual = new MIndividual();
            $mcompagny = new MCompagny();

            if (($data = $madvertiser->exist()) && $isPasswordCorrect) {
                $mindividual->setValue($data);
                $mcompagny->setValue($data);

                $_SESSION['ADVERTISER_ID'] = $data['advertiser_id'];
                $_SESSION['ADVERTISER'] = ($mindividual->name()) ? $mindividual->name() : $mcompagny->name();

                header('Location: home');

                return;
            } else {
                $data['ERROR_VALID'] = true;
                $data['ERROR_EMPTY'] = false;

                global $content;

                $content['title'] = 'Connexion';
                $content['class'] = 'VAdvertiser';
                $content['method'] = 'formLogin';
                $content['arg'] = $data;

                return;
            }
        } else {
            $data['ERROR_VALID'] = false;
            $data['ERROR_EMPTY'] = true;

            global $content;

            $content['title'] = 'Connexion';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formLogin';
            $content['arg'] = $data;

            return;
        }
    }
} // login()

// Pour la deconnexion
function logout()
{
    session_destroy();

    unset($_SESSION['ADVERTISER_ID']);
    unset($_SESSION['ADVERTISER']);

    header('Location: home');

    return;

} // logout()

// Pour l'affichage du profil
function profile()
{
    if (isset($_SESSION['ADVERTISER_ID'])) {

        $madvertiser = new MAdvertiser($_SESSION['ADVERTISER_ID']);
        $mindividual = new MIndividual();
        $mcompagny = new MCompagny();

        $mindividual->setValue($_SESSION);
        $mcompagny->setValue($_SESSION);

        $data['ADVERTS'] = $madvertiser->adverts();
        $data['NUMBER'] = $madvertiser->numberAdvert();

        if ($data['PROFILE'] = $mindividual->profile()) {
            global $content;

            $data['ERROR_ADVERT'] = false;

            $content['title'] = 'Profil';
            $content['class'] = 'VIndividual';
            $content['method'] = 'showProfile';
            $content['arg'] = $data;

            return;
        } else {
            $data['PROFILE'] = $mcompagny->profile();

            global $content;

            $data['ERROR_ADVERT'] = false;

            $content['title'] = 'Profil';
            $content['class'] = 'VCompagny';
            $content['method'] = 'showProfile';
            $content['arg'] = $data;

            return;
        }
    } else {
        header('Location: formLogin');
    }

} // profile()

// Affiche le formulaire pour ajouter ou modifier un annonceur
function formAdvertiser()
{
    $data['ERROR'] = false;
    $data['ERROR_MAIL'] = false;
    $data['EMPTY_FIELD'] = false;
    $data['SIRET_EXIST'] = false;

    if (isset($_SESSION['ADVERTISER_ID']))
    {
        $mindividual = new MIndividual();
        $mcompagny = new MCompagny();

        $mindividual->setValue($_SESSION);
        $mcompagny->setValue($_SESSION);

        if ($data['PROFILE'] = $mindividual->profile())
        {
            global $content;

            $content['title'] = 'Edit';
            $content['class'] = 'VIndividual';
            $content['method'] = 'editIndividual';
            $content['arg'] = $data;

            return;
        }
        else
        {
            $data['PROFILE'] = $mcompagny->profile();

            global $content;

            $content['title'] = 'Edit';
            $content['class'] = 'VCompagny';
            $content['method'] = 'editCompagny';
            $content['arg'] = $data;

            return;
        }
    }

    global $content;

    $content['title'] = 'Inscription';
    $content['class'] = 'VAdvertiser';
    $content['method'] = 'formAdvertiser';
    $content['arg'] = $data;

    return;

} // formAdvertiser()

// Insérer un annonceur en base de données
function insertAdvertiser()
{
    if(empty($_POST['MAIL']) || empty($_POST['PASSWORD']) || empty($_POST['PHONE_NUMBER']) || empty($_POST['TYPE']))
    {
        $data['EMPTY_FIELD'] = true;
        $data['ERROR_MAIL'] = false;
        $data['SIRET_EXIST'] = false;

        global $content;

        $content['title'] = 'Inscription';
        $content['class'] = 'VAdvertiser';
        $content['method'] = 'formAdvertiser';
        $content['arg'] = $data;

        return;

    } else
    {
        $madvertiser = new MAdvertiser();
        $mcompagny = new MCompagny();
        $mindividual = new MIndividual();
        $madvertiser->setValue($_POST);
        $mcompagny->setValue($_POST);

        if ($madvertiser->emailExist())
        {
            $data['EMPTY_FIELD'] = false;
            $data['ERROR_MAIL'] = true;
            $data['SIRET_EXIST'] = false;

            global $content;

            $content['title'] = 'Inscription';
            $content['class'] = 'VAdvertiser';
            $content['method'] = 'formAdvertiser';
            $content['arg'] = $data;

            return;
        }

        if ($_POST['TYPE'] == 'particulier')
        {
            if (empty($_POST['SURNAME']) || empty($_POST['NAME']) || empty($_POST['CIVILITIES_ID']))
            {
                $data['EMPTY_FIELD'] = true;
                $data['ERROR_MAIL'] = false;
                $data['SIRET_EXIST'] = false;

                global $content;

                $content['title'] = 'Inscription';
                $content['class'] = 'VAdvertiser';
                $content['method'] = 'formAdvertiser';
                $content['arg'] = $data;

                return;
            }
            else
            {
                //Pour se loger direct après être inscrit
                $_SESSION['PASSWORD'] = $_POST['PASSWORD'];
                $_SESSION['MAIL'] = $_POST['MAIL'];

                $_POST['PASSWORD'] = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

                $madvertiser->setValue($_POST);

                $id = $madvertiser->modify('insert');

                $_POST['ADVERTISER_ID'] = $id['ID'];

                $mindividual->setValue($_POST);
                $mindividual->modify('insert');

                header('Location: login');

                return;
            }
        }
        elseif ($_POST['TYPE'] == 'professionnel')
        {
            if (empty($_POST['NAME']) || empty($_POST['SIRET']) || empty($_POST['ADDRESS']) || empty($_POST['CITY']) || empty($_POST['POSTAL_CODE']))
            {
                $data['EMPTY_FIELD'] = true;
                $data['ERROR_MAIL'] = false;
                $data['SIRET_EXIST'] = false;

                global $content;

                $content['title'] = 'Inscription';
                $content['class'] = 'VAdvertiser';
                $content['method'] = 'formAdvertiser';
                $content['arg'] = $data;

                return;
            }
            elseif ($mcompagny->siretExist())
            {
                $data['EMPTY_FIELD'] = false;
                $data['ERROR_MAIL'] = false;
                $data['SIRET_EXIST'] = true;

                global $content;

                $content['title'] = 'Inscription';
                $content['class'] = 'VAdvertiser';
                $content['method'] = 'formAdvertiser';
                $content['arg'] = $data;

                return;
            }
            else
            {
                //Pour se loger direct après être inscrit
                $_SESSION['PASSWORD'] = $_POST['PASSWORD'];
                $_SESSION['MAIL'] = $_POST['MAIL'];

                $_POST['PASSWORD'] = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

                $madvertiser->setValue($_POST);

                $id = $madvertiser->modify('insert');

                $_POST['ADVERTISER_ID'] = $id['ID'];

                $mcompagny->setValue($_POST);
                $mcompagny->modify('insert');

                header('Location: login');

                return;
            }
        }
    }
} // insertAdvertiser()

// Mise  à jour d'un annonceur
function updateAdvertiser()
{
    if($_SESSION['ADVERTISER_ID'] != $_GET['ADVERTISER_ID'])
    {
        header('Location: formAdvertiser');
    }
    else {
        $madvertiser = new MAdvertiser($_SESSION['ADVERTISER_ID']);
        $madvertiser->setValue($_POST);

        if ($_GET['TYPE'] == 'individual') {
            if (empty($_POST['MAIL']) || empty($_POST['PASSWORD']) || empty($_POST['PHONE_NUMBER']) || empty($_POST['SURNAME']) || empty($_POST['NAME']) || empty($_POST['CIVILITIES_ID'])) {
                $mindividual = new MIndividual();
                $mindividual->setValue($_SESSION);

                $data['PROFILE'] = $mindividual->Profile();
                $data['ERROR'] = true;
                $data['ERROR_MAIL'] = false;

                global $content;

                $content['title'] = 'Edit';
                $content['class'] = 'VIndividual';
                $content['method'] = 'editIndividual';
                $content['arg'] = $data;

                return;
            } elseif (!$madvertiser->email() && $madvertiser->emailExist()) {
                $mindividual = new MIndividual();
                $mindividual->setValue($_SESSION);

                $data['PROFILE'] = $mindividual->profile();
                $data['ERROR'] = false;
                $data['ERROR_MAIL'] = true;

                global $content;

                $content['title'] = 'Edit';
                $content['class'] = 'VIndividual';
                $content['method'] = 'editIndividual';
                $content['arg'] = $data;

                return;
            } else {
                $madvertiser = new MAdvertiser($_SESSION['ADVERTISER_ID']);
                $mindividual = new MIndividual();
                $madvertiser->setValue($_POST);

                $id = $madvertiser->modify('update');

                $_POST['ADVERTISER_ID'] = $id['ID'];
                $_POST['advertiser_id'] = $id['ID'];

                $mindividual->setValue($_POST);
                $mindividual->modify('update');

                $_SESSION['ADVERTISER'] = $mindividual->Name();

                header('Location: profile');

                return;
            }
        } elseif ($_GET['TYPE'] == 'compagny') {
            if (empty($_POST['MAIL']) || empty($_POST['PASSWORD']) || empty($_POST['PHONE_NUMBER']) || empty($_POST['NAME']) || empty($_POST['SIRET']) || empty($_POST['ADDRESS']) || empty($_POST['CITY']) || empty($_POST['POSTAL_CODE'])) {
                $mcompagny = new MCompagny();
                $mcompagny->setValue($_SESSION);

                $data['PROFILE'] = $mcompagny->profile();
                $data['ERROR'] = true;
                $data['ERROR_MAIL'] = false;

                global $content;

                $content['title'] = 'Edit';
                $content['class'] = 'VCompagny';
                $content['method'] = 'editCompagny';
                $content['arg'] = $data;

                return;
            } elseif (!$madvertiser->email() && $madvertiser->emailExist()) {
                $mcompagny = new MCompagny();
                $mcompagny->setValue($_SESSION);

                $data['PROFILE'] = $mcompagny->profile();
                $data['ERROR'] = false;
                $data['ERROR_MAIL'] = true;

                global $content;

                $content['title'] = 'Edit';
                $content['class'] = 'VCompagny';
                $content['method'] = 'editCompagny';
                $content['arg'] = $data;

                return;
            } else {
                $madvertiser = new MAdvertiser($_SESSION['ADVERTISER_ID']);
                $mcompagny = new MCompagny();
                $madvertiser->setValue($_POST);

                $id = $madvertiser->modify('update');

                $_POST['ADVERTISER_ID'] = $id['ID'];
                $_POST['advertiser_id'] = $id['ID'];

                $mcompagny->setValue($_POST);
                $mcompagny->modify('update');

                $_SESSION['ADVERTISER'] = $mcompagny->name();

                header('Location: profile');

                return;
            }
        }
    }
} // updateAdvertiser()

// Suppression d'un annonceur
function deleteAdvertiser()
{
    if(isset($_SESSION['ADVERTISER_ID'])) {
        $madvertiser = new MAdvertiser($_SESSION['ADVERTISER_ID']);

        $mindividual = new MIndividual();
        $mcompagny = new MCompagny();

        $mindividual->setValue($_SESSION);
        $mcompagny->setValue($_SESSION);

        $data['ADVERTS'] = $madvertiser->adverts();
        $data['NUMBER'] = $madvertiser->numberAdvert();

        if ($madvertiser->advertExist() && $data['PROFILE'] = $mindividual->profile()) {
            $data['ERROR'] = false;
            $data['ERROR_ADVERT'] = true;

            global $content;

            $content['title'] = 'Edit';
            $content['class'] = 'VIndividual';
            $content['method'] = 'showProfile';
            $content['arg'] = $data;

            return;
        } elseif ($madvertiser->advertExist() && $data['PROFILE'] = $mcompagny->profile()) {
            $data['ERROR'] = false;
            $data['ERROR_ADVERT'] = true;

            global $content;

            $content['title'] = 'Edit';
            $content['class'] = 'VCompagny';
            $content['method'] = 'showProfile';
            $content['arg'] = $data;

            return;
        }

        if ($mindividual->profile()) {
            $mindividual->modify('delete');
        } else {
            $mcompagny->modify('delete');
        }

        $madvertiser->modify('delete');

        session_destroy();

        unset($_SESSION['ADVERTISER_ID']);
        unset($_SESSION['ADVERTISER']);

        header('Location: home');

        return;
    } else
    {
        header('Location: home');
    }

} // deleteAdvertiser()
