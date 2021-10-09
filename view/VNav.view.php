<?php
/**
 * Class VNav de type Vue pour l'affichage du menu de navigation
 *
 * @author Arnaud Maghraoui
 * @version 1.0
 */
class VNav
{
    /**
     * Constructeur de la class VNav
     */
    public function __construct() {}

    /**
     * Destructeur de la class VNav
     */
    public function __destruct() {}

    /**
     * @return void
     * Affiche le menu de navigation
     */
    public function showNav()
    {
        if (isset($_SESSION['ADVERTISER'])) {

            if (isset($_SESSION['ADVERTISER']['name']))
            {
                $name = ucfirst($_SESSION['ADVERTISER']['name']) . ' ' . ucfirst($_SESSION['ADVERTISER']['surname']);
            }
            else
            {
                $name = $_SESSION['ADVERTISER']['name_compagny'];
            }

            echo <<<HERE
<nav class="navbar navbar-dark navbar-expand-md bg-faded bg-primary justify-content-center">
    <a class="navbar-brand" href="home">
        <img src="public/img/logomenu_wicarsee.png" alt="Logo Wicarsee">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
        <span class="navbar-toggler-icon"></span>
    </button>
      
      <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
          <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
              <li class="nav-item">
                  <a class="nav-link" href="home">Accueil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="formAdvert">Ajouter une annonce</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="profile">$name</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="logout">Déconnexion</a>
              </li>
          </ul>
      </div>
</nav>
HERE;
        }
        else
        {
            echo <<<'NOW'
<nav class="navbar navbar-dark navbar-expand-md bg-faded bg-primary justify-content-center">
    <a class="navbar-brand" href="home">
        <img src="public/img/logomenu_wicarsee.png" alt="Logo Wicarsee">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
        <span class="navbar-toggler-icon"></span>
    </button>
      
      <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
          <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="home">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="formLogin">Connexion/Inscription</a>
            </li>
          </ul>
      </div>
</nav>
NOW;
        }
        return;

    } // showNav()

    /**
     * @return void
     * Affiche le menu de navigation pour l'Admin
     */
    public function showNavAdmin()
    {
        if (isset($_SESSION['ADMIN']))
        {
            $name = $_SESSION['ADMIN'];

            echo <<<HERE
<nav class="navbar navbar-dark navbar-expand-md bg-faded bg-primary justify-content-center">
    <a class="navbar-brand" href="home">
        <img src="../public/img/logomenu_wicarsee.png" alt="Logo Wicarsee">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
        <span class="navbar-toggler-icon"></span>
    </button>
      
      <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
          <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
              <li class="nav-item">
                  <a class="nav-link" href="home">Accueil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="formAdmin">Ajouter un administrateur</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="profile">$name</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="logout">Déconnexion</a>
              </li>
          </ul>
      </div>
</nav>
HERE;
        }
        else
        {
            echo <<<'NOW'
<nav class="navbar navbar-dark navbar-expand-md bg-faded bg-primary justify-content-center">
    <a class="navbar-brand" href="formLogin">
        <img src="../public/img/logomenu_wicarsee.png" alt="Logo Wicarsee">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
        <span class="navbar-toggler-icon"></span>
    </button>
      
      <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
          <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="formLogin">Connexion</a>
            </li>
          </ul>
      </div>
</nav>
NOW;
        }
        return;

    } // showNavAdmin()

} // class VNav

?>
