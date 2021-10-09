<?php
/**
 * Class VCompagny de type Vue pour l'affichage du profil
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VCompagny
{
    /**
     * VCompagny constructor.
     */
    public function __construct() {}

    /**
     * VCompagny destructor.
     */
    public function __destruct() {}

    /**
     * @param array
     * @return void
     * Affiche le profil d'un annonceur de type professionnel
     */
    public function showProfile($_value)
    {
        ?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Votre profil</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mt-5">
        <section>
            <header>
                <h2 class="mb-4">Mes informations</h2>
            </header>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Nom société : <?= ucfirst($_value['PROFILE']['name']) ?></li>
                <li class="list-group-item">SIRET : <?= ucfirst($_value['PROFILE']['siret']) ?></li>
                <li class="list-group-item">Adresse : <?= ucfirst($_value['PROFILE']['address']) ?></li>
                <li class="list-group-item">Ville : <?= ucfirst($_value['PROFILE']['city']) ?></li>
                <li class="list-group-item">Code postal : <?= $_value['PROFILE']['postal_code'] ?></li>
                <li class="list-group-item">Mail : <?= $_value['PROFILE']['mail'] ?></li>
                <li class="list-group-item">Numéro de téléphone : <?= wordwrap($_value['PROFILE']['phone_number'], 2, ' ', true) ?></li>
            </ul>
            <a href="formAdvertiser" class="btn btn-warning mt-4">Editer mon profil</a>
            <a href="deleteAdvertiser" class="btn btn-danger mt-4">Supprimer mon profil</a>
        </section>
        <?php
            if ($_value['ERROR_ADVERT'])
            {
                ?>
                <div class="alert alert-dismissible alert-danger mt-3">
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                    <strong>Attention !</strong> Vous avez une/des annonce(s) de publiée ! Supprimer d'abord votre/vos annonce(s) avant votre profil.
                </div>
                <?php
            }
        ?>
    </div>

    <div class="col-md-6 d-flex justify-content-center mt-5">
        <section>
            <header>
                <h2 class="mb-4">Mes annonces</h2>
            </header>
            <?php if ($_value['NUMBER']['number_advert'] > 0){ ?>
                <form action="actionAdvert" method="post">

                    <div class="col-lg-12">
                        <div class="form-group form-inline">
                            <p class="selection col-form-label">Sélectionner votre annonce :</p>
                            <?php foreach ($_value['ADVERTS'] as $val) { ?>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="<?=$val['id']?>" name="ADVERT_ID" value="<?=$val['id']?>" class="custom-control-input radio-vehicle">
                                    <label class="custom-control-label" for="<?=$val['id']?>"><?=ucfirst($val['brand'])?> <?=ucfirst($val['model'])?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="ACTION" id="submit-vehicle" value="Ajouter une annonce">
                        </div>
                    </div>

                </form>
                <p class="mt-3">Nombre total d'annonce(s) : <?=$_value['NUMBER']['number_advert']?></p>
            <?php } else {?>
                <p>Vous n'avez pas encore ajouté d'annonce <a href="formAdvert">cliquer ici</a> pour en ajouter une.</p>
            <?php } ?>
        </section>
    </div>
</div>
        <?php
        return;

    } // showProfile($_value)

    /**
     * @param $_value
     * Affiche le formulaire de modification du profil d'un annonceur de type professionnel
     */
    public function editCompagny($_value)
    {
        echo <<<HERE
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Modifier votre profil</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
        <form action="updateAdvertiser-{$_SESSION['ADVERTISER_ID']}-compagny" method="post" class="form-advertiser mb-3" id="form">

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="mail">Mail :</label>
                    <input type="email" name="MAIL" class="form-control" id="mail" value="{$_value['PROFILE']['mail']}" placeholder="Entrez une adresse mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Veuillez rentrer une adresse mail valide">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Entrez un mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins un chiffre, une lettre majuscule et minuscule et au moins 8 caractères.">
                    <span id="helpPassword"></span>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="phone">Téléphone :</label>
                    <input type="tel" name="PHONE_NUMBER" class="form-control" placeholder="Entrez un numéro de téléphone" id="phone" value="{$_value['PROFILE']['phone_number']}" required pattern="[0-9 ]+" title="Veuillez entrer un numéro de téléphone valide">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="name">Nom société :</label>
                    <input type="text" name="NAME" class="form-control" id="name" placeholder="Entrez un nom de société" value="{$_value['PROFILE']['name']}" required pattern="[a-zA-Zàâçéèêëîïôûùüÿñæœ0-9 ]+">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="siret">Siret :</label>
                    <input type="text" name="SIRET" class="form-control" id="siret" placeholder="Entrez un SIRET" value="{$_value['PROFILE']['siret']}" required pattern="[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="address">Adresse :</label>
                    <input type="text" name="ADDRESS" class="form-control" id="address" placeholder="Entrez une adresse" value="{$_value['PROFILE']['address']}" required pattern="[A-Za-z0-9àâçéèêëîïôûùüÿñæœ, \-]+">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="city">Ville :</label>
                    <input type="text" name="CITY" class="form-control" id="city" placeholder="Entrez une ville" value="{$_value['PROFILE']['city']}" required pattern="[a-zA-Zàâçéèêëîïôûùüÿñæœ0-9 \-]+">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="col-form-label" for="postal_code">Code postal :</label>
                    <input type="text" name="POSTAL_CODE" class="form-control" id="postal_code" placeholder="Entrez un code postal" value="{$_value['PROFILE']['postal_code']}" required pattern="[0-9]{5}">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <input type="submit" name="ACTION" class="btn btn-warning" value="Valider les modifications">
                </div>
            </div>

        </form>
</div>
HERE;
                if ($_value['ERROR'])
                {
                    ?>
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Erreur !</strong>Veuillez remplir tous les champs !
                    </div>
                    <?php
                }

                if ($_value['ERROR_MAIL'])
                {
                    ?>
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Erreur !</strong> Erreur ce mail existe déjà !
                    </div>
                    <?php
                }
                ?>
<?php
        return;

    } // editCompagny($_value)

} // class VCompagny

?>
