<?php
/**
 * Class VAdvertiser de type Vue pour l'affichage du formulaire de connexion et d'insciption
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VAdvertiser
{
    /**
     * VAdvertiser constructor.
     */
    public function __construct() {}

    /**
     * VAdvertiser destructor.
     */
    public function __destruct() {}

    /**
     * @param array
     * @return void
     * Affiche le formulaire de connexion
     */
    public function formLogin($_value)
    {
?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Connexion</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="login" method="post" class="form-login mb-3">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="mail">Mail :</label>
                <input type="email" name="MAIL" class="form-control" id="mail" placeholder="Votre adresse mail" required>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Votre mot de passe" required>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-search" value="Valider">
            </div>
        </div>

    </form>
</div>
    <?php
        if ($_value['ERROR_VALID'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Mauvais mot de passe ou mail ! <a href='forgotPassword' class="alert-link">Mot de passe oublié ?</a>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($_value['ERROR_EMPTY']) {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Veuillez remplir les champs !
                    </div>
                </div>
            </div>
            <?php
        }
    ?>

<div class="row align-items-center justify-content-around">
    <div class="col-md-6 col-lg-6">
        <p><a href="formAdvertiser">Créer un compte</a></p>
        <p><a href="forgotPassword">Mot de passe oublié</a></p>
    </div>
</div>
<?php
        return;

    } // formLogin($_value)

    /**
     * @param $_value
     * Affiche le formulaire pour l'envoie d'un mail en cas d'oublie du mot de passe
     */
    public function formMail($_value)
    {
        echo <<<HERE
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Mot de passe oublié</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="sendMail" method="post" class="form-login mb-3">

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="mail">Entrez votre adresse mail :</label>
                <input type="email" name="MAIL" class="form-control" id="mail" placeholder="Votre adresse mail" required>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Envoyer">
            </div>
        </div>

    </form>
</div>
HERE;
        if ($_value['ERROR_VALID'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                        <div class="alert alert-dismissible alert-danger mt-3">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Erreur !</strong> Ce mail n'existe pas !
                        </div>
                </div>
            </div>
            <?php
        }

        if ($_value['ERROR_EMPTY'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                        <div class="alert alert-dismissible alert-danger mt-3">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Erreur !</strong> Veuillez remplir le champ !
                        </div>
                </div>
            </div>
            <?php
        }

        if ($_value['MAIL'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                        <div class="alert alert-dismissible alert-success">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Super !</strong> Un mail a bien été envoyé !
                        </div>
                </div>
            </div>
            <?php
        }

        if ($_value['ERROR_MAIL'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Le mail n'a pas été envoyé !
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
<?php
        return;

    } // formMail($_value)

    /**
     * @param $_value
     * Affiche le formulaire pour le nouveau mot de passe
     */
    public function formResetPassword($_value) {
        echo <<<HERE
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Réinitialiser votre mot de passe</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="resetPassword" method="post" class="form-advertiser mb-3">

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="mail">Entrez votre adresse mail :</label>
                <input type="email" name="MAIL" class="form-control" id="mail" placeholder="Votre adresse mail" required>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="password">Entrez votre nouveau mot de passe :</label>
                <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Votre nouveau mot de passe" required>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="password-confirm">Confirmez votre nouveau mot de passe :</label>
                <input type="password" name="PASSWORD_CONFIRM" class="form-control" id="password-confirm" placeholder="Confirmez votre nouveau mot de passe" required>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Envoyer">
            </div>
        </div>

    </form>
</div>
HERE;
        if ($_value['ERROR_VALID'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Ce mail n'existe pas !
                    </div>
                </div>
            </div>
            <?php
        }

        if ($_value['ERROR_EMPTY'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Veuillez remplir tous les champs !
                    </div>
                </div>
            </div>
            <?php
        }

        if ($_value['ERROR_PASSWORD'])
        {
            ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Les mots de passe rentrés ne sont pas les mêmes
                    </div>
                </div>
            </div>
            <?php
        }

        return;
    } // formResetPassword($_value)

    /**
     * @param array
     * @return void
     * Affiche le formulaire d'inscription
     */
    public function formAdvertiser($_value)
    {
        echo <<<HERE
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Créer un compte</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="insertAdvertiser" method="post" class="form-advertiser mb-3" id="form">

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="mail">Mail :</label>
                <input type="email" name="MAIL" class="form-control" id="mail" placeholder="Entrez une adresse mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Veuillez entrer une adresse mail valide">
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="form-group">
                 <label class="col-form-label" for="password">Mot de passe :</label>
                 <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Entrez un mot de passe" required  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" title="Doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spéciale et minimum 8 caractères.">
                 <span id="helpPassword"></span>
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="phone">Téléphone :</label>
                <input type="tel" name="PHONE_NUMBER" class="form-control" placeholder="Entrez un numéro de téléphone" id="phone" required pattern="[0-9 ]+" title="Veuillez entrer un numéro de téléphone valide">
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group form-inline">
                <p class="col-form-label">Vous êtes :</p>
                <div class="custom-control custom-radio">
                    <input type="radio" id="individual" name="TYPE" value="particulier" class="custom-control-input">
                    <label class="custom-control-label" for="individual">Particulier</label>
                </div>
    
                <div class="custom-control custom-radio">
                    <input type="radio" id="compagny" name="TYPE" value="professionnel" class="custom-control-input">
                    <label class="custom-control-label" for="compagny">Professionnel</label>
                </div>
            </div>
        </div>
    
        <div id="suite">
    
        </div>

    </form>
</div>
HERE;
        if ($_value['EMPTY_FIELD'])
            {
                ?>
            <div class="row align-items-center justify-content-around">
                <div class="col-md-12 col-lg-6">
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur !</strong> Veuillez remplir tous les champs !
                    </div>
                </div>
            </div>
                <?php
            }

        if ($_value['ERROR_MAIL'])
        {
            ?>
        <div class="row align-items-center justify-content-around">
            <div class="col-md-12 col-lg-6">
                <div class="alert alert-dismissible alert-danger mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Erreur !</strong> Ce mail existe déjà !
                </div>
            </div>
        </div>
            <?php
        }

        if ($_value['SIRET_EXIST'])
        {
            ?>
        <div class="row align-items-center justify-content-around">
            <div class="col-md-12 col-lg-6">
                <div class="alert alert-dismissible alert-danger mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Erreur !</strong> Ce siret existe déjà !
                </div>
            </div>
        </div>
            <?php
        }
        ?>
<?php
        return;

    } // formAdvertiser($_value)

    /**
     * @param $_value
     * @return void
     * Affiche la page d'administration des annonceurs
     */
    public function adminAdvertiser($_value)
    {
        ?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Liste des particuliers</h1>
    </div>
</div>

<?php
        if ($_value['ERROR_ADVERT'])
        {
            ?>
            <div class="alert alert-dismissible alert-danger mt-3">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Attention !</strong> Cet annonceur a encore une/des annonce(s) de publié ! Supprimer d'abord <a href="adminAdvert" class="alert-link">son/ses annonce(s)</a> avant son profil.
            </div>
            <?php
        }

        if ($_value['ERROR_ROOT'])
        {
            ?>
            <div class="alert alert-dismissible alert-danger mt-3">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Attention !</strong> Vous ne disposer pas de tous les droits pour supprimer un annonceur.
            </div>
            <?php
        }
?>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <caption>Particulier</caption>

                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($_value['INDIVIDUAL'] as $val){
                    ?>
                    <tr>
                        <td scope="row"><?=$val['id']?></td>
                        <td><?=$val['name']?></td>
                        <td><?=$val['surname']?></td>
                        <td><a href="deleteAdvertiser-<?=$val['advertiser_id']?>" class="btn btn-danger">Supprimer</a></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="row align-items-end title">
    <div class="col-12">
        <h1>Liste des professionnels</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <caption>Professionnel</caption>

                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Société</th>
                    <th scope="col">Siret</th>
                    <th scope="col">Option</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($_value['COMPAGNY'] as $val){
                    ?>
                    <tr>
                        <td scope="row"><?=$val['id']?></td>
                        <td><?=$val['name']?></td>
                        <td><?=$val['siret']?></td>
                        <td><a href="../admin/index.php?EX=deleteAdvertiser&amp;ADVERTISER_ID=<?=$val['id']?>" class="btn btn-danger">Supprimer</a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
    <?php

        return;

    } // adminAdvertiser($_value)

} // class VAdvertiser

?>
