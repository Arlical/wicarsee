<?php
/**
 * Class VAdmin de type Vue pour l'affichage des pages administration
 *
 * @author Arnaud Maghraoui
 * @version 1.0
 */
class VAdmin
{
    /**
     * VAdmin constructor.
     */
    public function __construct() {}

    /**
     * VAdmin destructor.
     */
    public function __destruct() {}

    /**
     * @return void
     * Affiche le formulaire de connexion admin
     */
    public function formConnection()
    {
        echo <<<HERE
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Connexion - Administration</h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="login" method="post" class="form-login mb-3">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" name="LOGIN" class="form-control" id="login" placeholder="Votre login" required>
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
                <input type="submit" class="btn btn-primary" value="Valider">
            </div>
        </div>

    </form>
</div>
HERE;
        return;
    } // formConnection()

    /**
     * @param $_value
     * Affiche le formulaire d'ajout d'un admin
     */
    public function formAdmin($_value)
    {
        if ($_value['PROFILE'])
        {
            $ex = 'actionAdmin';
            $title = 'Modifier ou supprimer votre compte administrateur';
            $update = '<input type="submit" name="ACTION" class="btn btn-warning m-2" value="Modifier">';
            $delete = '<input type="submit" name="ACTION" class="btn btn-danger" value="Supprimer">';
        }
        else
        {
            $ex = 'insertAdmin';
            $title = 'Insérer un compte administrateur';
            $insert = '<input type="submit" class="btn btn-primary" value="Valider">';
        }
?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1><?=$title?></h1>
    </div>
</div>

<div class="row align-items-center justify-content-around">
    <form action="<?=$ex?>" method="post" class="form-admin">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" name="LOGIN" class="form-control" id="login" value="<?php if(isset($_value['PROFILE']['login'])){ echo $_value['PROFILE']['login']; }?>" placeholder="Entrez un login" required>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="PASSWORD" class="form-control" id="password" placeholder="Entrez un mot de passe" required>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group form-inline">
                <p>Souhaitez-vous que cet administrateur est tous les droits ?</p>
                <div class="custom-control custom-radio">
                    <input type="radio" id="yes" name="ROOT" value="1" class="custom-control-input" <?php if(isset($_value['PROFILE']['root']) && $_value['PROFILE']['root'] == 1){echo "checked";} ?>>
                    <label class="custom-control-label mr-3" for="yes">Oui</label>
                </div>

                <div class="custom-control custom-radio">
                    <input type="radio" id="no" name="ROOT" value="0" class="custom-control-input" <?php if(isset($_value['PROFILE']['root']) && $_value['PROFILE']['root'] == 0){echo "checked";} ?>>
                    <label class="custom-control-label" for="no">Non</label>
                </div>
            </div>
        </div>
            
        <div class="col-lg-12">
            <div class="form-group">
            </div>
            <?php if($_value['PROFILE']) {echo $update . $delete;} else {echo $insert;} ?>
        </div>

    </form>
        <?php
        if ($_value['ERROR_LOGIN'])
        {
            ?>
            <div class="alert alert-dismissible alert-danger mt-3 error-admin">
                <button type="button" class="btn-close" data-dismiss="alert"></button>
                <strong>Erreur !</strong> Ce login existe déjà !
            </div>
            <?php
        }
        elseif ($_value['ERROR_EMPTY'])
        {
            ?>
            <div class="alert alert-dismissible alert-danger mt-3 error-admin">
                <button type="button" class="btn-close" data-dismiss="alert"></button>
                <strong>Erreur !</strong> Veuillez remplir tous les champs !
            </div>
            <?php
        }
        ?>
</div>
<?php
        return;

    } // formAdmin($_value)

    /**
     * @param $_value
     * Affiche le profil d'un admin
     */
    public function showProfile($_value)
    {
       ?>
<div class="row mb-5">
    <div class="col-12">
        <h1>Votre profil</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 d-flex justify-content-center mt-5">
        <section class="information">
            <header>
                <h2 class="mb-4">Mes informations</h2>
            </header>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Login : <?= ucfirst($_value['PROFILE']['login']) ?></li>
                <li class="list-group-item">Administrateur : <?php if($_value['PROFILE']['root']){echo 'Oui';}else{echo 'Non';} ?></li>
            </ul>
            <a href="editAdmin" class="btn btn-warning mt-4">Editer mon profil</a>
        </section>
    </div>

    <div class="col-md-6 d-flex justify-content-center align-items-center mt-5">
        <section class="list-admin">
            <div class="table-responsive">
            <header>
                <h2>Liste des administrateurs</h2>
            </header>
                <table class="table table-striped table-bordered">
                    <caption>Administrateur</caption>

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Login</th>
                            <th scope="col">Administrateur</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($_value['ADMIN'] as $val){
                        ?>
                        <tr>
                            <th scope="row"><?=$val['id']?></th>
                            <td><?=$val['login']?></td>
                            <td><?php if($val['root']){echo 'Oui';}else{echo 'Non';} ?></td>
                            <td><a href="deleteAdmin-<?=$val['id']?>" class="btn btn-danger">Supprimer</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>

                </table>
            </div>
            <div>
                <?php
                if ($_value['ERROR_ROOT'])
                {
                    ?>
                    <div class="alert alert-dismissible alert-danger mt-3 error-admin">
                        <button type="button" class="btn-close" data-dismiss="alert"></button>
                        <strong>Erreur !</strong> Vous n'avez pas les droits nécessaires pour supprimer un administrateur !
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </div>
</div>
<?php
        return;

    } // showProfile($_value)

} // class VAdmin
?>
