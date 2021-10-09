<?php
/**
 * Class VIndividual de type Vue pour l'affichage du profil
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VIndividual
{
    /**
     * VIndividual constructor.
     */
    public function __construct() {}

    /**
     * VIndividual destructor.
     */
    public function __destruct() {}

    /**
     * @param array
     * @return void
     * Affiche le profil d'un annonceur de type particulier
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
                <li class="list-group-item">Nom : <?= ucfirst($_value['PROFILE']['surname']) ?></li>
                <li class="list-group-item">Prénom : <?= ucfirst($_value['PROFILE']['name']) ?></li>
                <li class="list-group-item">Civilité : <?= ucfirst($_value['PROFILE']['civility']) ?></li>
                <li class="list-group-item">Mail : <?= $_value['PROFILE']['mail'] ?></li>
                <li class="list-group-item">Téléphone : <?= wordwrap($_value['PROFILE']['phone_number'], 2, ' ', true) ?></li>
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
                    <strong>Attention !</strong> Vous avez une/des annonce(s) de publiée ! Supprimer d'abord votre/vos annonce(s) avant votre <profil class=""></profil>
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
     * @return void
     * Affiche le formulaire de modification du profil d'un annonceur de type particulier
     */
    public function editIndividual($_value)
    {
        ?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Modifier votre profil</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="updateAdvertiser-<?=$_SESSION['ADVERTISER_ID']?>-individual" method="post" class="form-advertiser mb-3" id="form">

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="mail">Mail :</label>
                <input type="email" name="MAIL" class="form-control" id="mail" value="<?=$_value['PROFILE']['mail']?>" placeholder="Entrez une adresse mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Veuillez rentrer une adresse mail valide">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
               <label class="col-form-label" for="password">Mot de passe :</label>
               <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Entrez un mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins un chiffre, une lettre majuscule et minuscule et au moins 8 caractères.">
               <span id="helpPassword"></span>
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="phone">Téléphone :</label>
                <input type="tel" name="PHONE_NUMBER" class="form-control" placeholder="Entrez un numéro de téléphone" id="phone" value="<?=$_value['PROFILE']['phone_number']?>" required pattern="[0-9 ]+" title="Veuillez entrer un numéro de téléphone valide">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="surname">Nom :</label>
                <input type="text" name="SURNAME" class="form-control" id="surname" value="<?=$_value['PROFILE']['surname']?>" placeholder="Entrez un nom" required pattern="[A-Za-zàâçéèêëîïôûùüÿñæœ]+">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label class="col-form-label" for="name">Prénom :</label>
                <input type="text" name="NAME" class="form-control" id="name" value="<?=$_value['PROFILE']['name']?>" placeholder="Entrez un prenom" required pattern="[A-Za-zàâçéèêëîïôûùüÿñæœ]+">
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group form-inline">
                <p>Civilité :</p>
                <div class="form-group form-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="homme" name="CIVILITIES_ID" value="9" class="custom-control-input" <?php if($_value['PROFILE']['civility'] == "homme"){echo "checked";} ?> required>
                        <label class="custom-control-label mr-3" for="homme">Homme</label>
                    </div>
    
                    <div class="custom-control custom-radio">
                        <input type="radio" id="femme" name="CIVILITIES_ID" value="10" class="custom-control-input" <?php if($_value['PROFILE']['civility'] == "femme"){echo "checked";} ?>>
                        <label class="custom-control-label" for="femme">Femme</label>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="form-group">
                <input type="submit" name="ACTION" class="btn btn-warning" value="Valider les modifications">
            </div>
        </div>

    </form>
</div>
<?php
                if ($_value['ERROR'])
                {
                    ?>
                    <div class="alert alert-dismissible alert-danger mt-3">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Erreur !</strong> Veuillez remplir tous les champs !
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

    } // editIndividual($_value)

} // class VIndividual

?>
