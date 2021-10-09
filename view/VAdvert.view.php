<?php
/**
 * Class VAdvert de type Vue pour l'affichage des annonces, d'une annonce et du formulaire
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VAdvert
{
    /**
     * VAdvert constructor.
     */
    public function __construct() {}

    /**
     * VAdvert destructor.
     */
    public function __destruct() {}

    /**
     * @param array
     * @return void
     * Affiche les annonces
     */
    public function showAdverts($_value)
    {
        if ($_value['COUNT']['number_advert'] > 0) {
            ?>
            <div class="row align-items-end">
                <div class="col-12">
                    <h1 class="advert_counter">Liste des anonces (<?=$_value['COUNT']['number_advert']?>)</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

            <?php
            foreach ($_value['ADVERT'] as $val) {
                ?>
                <div class="container advert" style="max-width: 40em">
                    <a href="advert-<?=$val['advert_id']?>" class="link">
                        <div class="row mb-5 mt-5 justify-content-center d-flex align-items-center">
                            <div class="col-6 m-3 justify-content-center d-flex align-items-center" style="max-width: max-content;">
                                <img src="http://localhost/wicarsee/php/upload/<?=$val['miniature']?>" alt="<?=$val['miniature']?>" width="320" height="220">
                            </div>
                            <div class="col-6 justify-content-center d-flex align-items-center" style="max-width: max-content;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Marque : <?= ucfirst($val['brand']) ?></li>
                                    <li class="list-group-item">Modèle : <?= ucfirst($val['model']) ?></li>
                                    <li class="list-group-item">Année : <?= $val['year'] ?></li>
                                    <li class="list-group-item">Kilomètre : <?= number_format($val['number_kilo'], 0, ',', ' ') ?> km</li>
                                    <li class="list-group-item">Prix : <?= number_format($val['price'], 0, ',', ' ') ?> €</li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-center">
                    <ul class="pagination">
                        <li class="page-item <?php if ($_value['ACTIVE'] == 0){echo 'disabled';} ?>">
                            <a class="page-link" href="paginationAdverts-0">&laquo;</a>
                        </li>
                        <?php
                        for ($i = 0; $i < $_value['NB_PAGE']; $i++)
                        {
                            ?>
                            <li class="page-item <?php if ($_value['ACTIVE'] == $i){echo 'active';} ?>">
                                <a class="page-link" href="paginationAdverts-<?=$i?>"><?=$i+1?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="page-item <?php if ($_value['ACTIVE'] == ($_value['NB_PAGE']-1)){echo 'disabled';} ?>">
                            <a class="page-link" href="paginationAdverts-<?=$_value['NB_PAGE']-1?>">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
        }
        else
        {
            ?>
                <div class="row align-items-end">
                    <div class="col-12">
                        <h1>Ooops aucune annonce trouvé !</h1>
                    </div>
                </div>
            <?php
        }
        ?>
            </div>
        </div>
        <?php
        return;

    } // showAdverts($_value)

    /**
     * @param array
     * @return void
     * Affiche une annonce avec les information de cette dernière
     */
    public function showAdvert($_value)
    {
        if(isset($_value['ADVERTISER']['surname'])) {
            $_value['ADVERTISER']['name'] = ucfirst($_value['ADVERTISER']['name']) . " " . ucfirst($_value['ADVERTISER']['surname']);
        }
        ?>
<div class="row">
    <div class="col-sm-2 col-md-2 col-lg-1 col-12">
        <button onclick="goBack()" class="btn btn-danger">Retour</button>
    </div>

    <div class="col-sm-10 col-md-12 col-lg-7 col-12 mt-1">
            <div class="w3-content">
                <?php foreach ($_value['PICTURE'] as $val) { ?>
                    <img class="mySlides responsive" src="http://localhost/wicarsee/php/upload/<?=$val['name']?>" alt="<?=$val['name']?>">
                <?php } ?>
            </div>

            <div class="d-flex flex-row justify-content-center mt-2">
                <button class="btn btn-info me-3" onclick="plusDivs(-1)">❮ Prev</button>
                <button class="btn btn-info" onclick="plusDivs(1)">Next ❯</button>
            </div>

            <div class="d-flex flex-row justify-content-center mt-2">
                <?php foreach ($_value['PICTURE']  as $key => $val) { ?>
                    <button class="btn btn-info me-1" onclick="currentDiv(<?=$key+1?>)"><?=$key+1?></button>
                <?php } ?>
            </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-4 col-12">
        <section class="info-vendeur">
            <h2>Information vendeur</h2>
            <ul class="list-group">
                <li class="list-group-item">Nom : <?=$_value['ADVERTISER']['name']?></li>
                <li class="list-group-item">Mail : <?=$_value['ADVERTISER']['mail']?></li>
                <li class="list-group-item">Téléphone : <?=wordwrap($_value['ADVERTISER']['phone_number'], 2, ' ', true)?></li>
            </ul>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2>Caractéristiques</h2>
        <ul class="list-inline list-characteristic">
            <li class="list-group-item">Marque : <?=ucfirst($_value['ADVERT']['brand'])?></li>
            <li class="list-group-item">Modèle : <?=ucfirst($_value['ADVERT']['model'])?></li>
            <li class="list-group-item">Nombre de kilometre : <?=number_format($_value['ADVERT']['number_kilo'], 0, ',', ' ')?> Km</li>
            <li class="list-group-item">Prix : <?=number_format($_value['ADVERT']['price'], 0, ',', ' ')?> €</li>
            <li class="list-group-item">Boite de vitesse : <?=ucfirst($_value['ADVERT']['gearbox'])?></li>
            <li class="list-group-item">Carburant : <?=ucfirst($_value['ADVERT']['fuel'])?></li>
            <li class="list-group-item">Couleur : <?=ucfirst($_value['ADVERT']['color'])?></li>
            <li class="list-group-item">Date véhicule : <?=$_value['ADVERT']['year']?></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2>Description</h2>
        <p><?=nl2br($_value['ADVERT']['description'])?></p>
    </div>
</div>
<?php
        return;

    } // showAdvert($_value)

    /**
     * @param array
     * @return void
     * Affiche le formulaire pour insérer et modifier une annonce
     */
    public function formAdvert($_value)
    {
        if ($_value['VEHICLE'])
        {
            $ex = 'updateAdvert-'.$_value['ADVERT_ID'].'-'.$_value['VEHICLE']['id'];
            $title = 'Modifier votre annonce';
            $update = '<input type="submit" name="ACTION" class="btn btn-warning" value="Valider les modifications">';
        }
        else
        {
            $ex = 'insertAdvert';
            $title = 'Insérer votre annonce';
            $insert = '<input type="submit" class="btn btn-primary" value="Valider">';
        }

        ?>
        <div class="row align-items-end title">
            <div class="col-12">
                <h1><?=$title?></h1>
            </div>
        </div>

        <div class="row align-items-center justify-content-around">
            <form action="<?=$ex?>" method="post" enctype="multipart/form-data" class="form-advert mb-3">

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-form-label" for="brand">Marque :</label>
                        <input type="text" name="BRAND" class="form-control" id="brand" value="<?=$_value['VEHICLE']['brand']?>" placeholder="Entrez la marque de votre véhicule" required>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-form-label" for="model">Modèle :</label>
                        <input type="text" name="MODEL" class="form-control" id="model" value="<?=$_value['VEHICLE']['model']?>" placeholder="Entrez le modèle de votre véhicule" required>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group form-inline">
                        <p class="col-form-label">Boîte de vitesse :</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="manual" name="GEARBOX_ID" value="1" class="custom-control-input" checked required>
                            <label class="custom-control-label" for="manual">Manuelle</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input type="radio" id="automatic" name="GEARBOX_ID" value="2" class="custom-control-input">
                            <label class="custom-control-label" for="automatic">Automatique</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-form-label" for="fuel">Carburant :</label>
                        <select class="form-select" id="fuel" name="FUEL_ID" required style="font-size: 1rem">
                            <option value="1">Essence</option>
                            <option value="2">Diesel</option>
                            <option value="3">Hybride</option>
                            <option value="4">Electrique</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                   <div class="form-group">
                        <label class="col-form-label" for="color">Couleur :</label>
                        <input type="text" name="COLOR" class="form-control" id="color" value="<?=$_value['VEHICLE']['color']?>" placeholder="Entrez la couleur de votre véhicule" required>
                   </div>
                </div>

                <div class="col-lg-12">
                   <div class="form-group">
                        <label class="col-form-label" for="year">Année :</label>
                        <input type="number" name="YEAR" class="form-control" id="year" value="<?=$_value['VEHICLE']['year']?>" min="1900" max="2030" placeholder="Entrez l'année de votre véhicule" required>
                   </div>
                </div>

                <div class="col-lg-12">
                   <div class="form-group">
                        <label class="col-form-label" for="kilometer">Kilomètre :</label>
                        <input type="number" name="NUMBER_KILOMETERS" class="form-control" id="kilometer" value="<?=$_value['VEHICLE']['number_kilometers']?>" placeholder="Entrez le nombre de kilomètres de votre véhicule" required>
                   </div>
                </div>

                <div class="col-lg-12">
                   <div class="form-group">
                        <label class="col-form-label" for="price">Prix :</label>
                        <input type="number" name="PRICE" class="form-control" id="price" value="<?=$_value['VEHICLE']['price']?>" placeholder="Entrez le prix de votre véhicule" required>
                   </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                       <div class="custom-file">
                            <label class="col-form-label" for="picture1">Upload des images pour votre annonce (1/10)</label>
                            <input type="file" name="PICTURE1" class="form-control" id="picture1" lang="fr" accept=".jpg, .jpeg, .png .gif" required>
                       </div>
                       <div class="mt-3 mb-3" id="buttonPicture">
                            <button type="button" class="btn btn-success" id="addPicture">Ajouter une image</button>
                            <button type="button" class="btn btn-danger" id="deletePicture">Suprimer une image</button>
                       </div>
                    </div>
                </div>

                <div class="col-lg-12">
                   <div class="form-group">
                        <label class="col-form-label" for="description">Description :</label>
                        <textarea name="DESCRIPTION" class="form-control" id="description" rows="6"><?=$_value['VEHICLE']['description']?></textarea>
                   </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <?php if(!$_value['VEHICLE']) {echo $insert;}else{echo $update;} ?>
                    </div>
                </div>

            </form>
        <?php
            if ($_value['ERROR'])
            {
                ?>
                <div class="alert alert-dismissible alert-danger mt-3">
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                    <strong>Erreur !</strong>Veuillez remplir tous les champs !
                </div>
                <?php
            }
        ?>
    </div>
<?php
        return;

    } // formAdvert()

    /**
     * @param $_value
     * @return void
     * Affiche la page d'administration des annonces
     */
    public function adminAdvert($_value)
    {
?>
<div class="row align-items-end title">
    <div class="col-12">
        <h1>Liste des annonces</h1>
    </div>
</div>

<?php
        if ($_value['ERROR_ROOT'])
        {
            ?>
            <div class="alert alert-dismissible alert-danger mt-3">
                <button type="button" class="btn-close" data-dismiss="alert"></button>
                <strong>Attention !</strong> Vous ne disposer pas de tous les droits pour supprimer une annonce.
            </div>
            <?php
        }
?>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">

        <table class="table table-striped table-bordered">
                <caption>Annonces</caption>

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Nombre de kilomètre</th>
                    <th>Prix</th>
                    <th>Option</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($_value['ADVERTS'] as $val){
                    ?>
                    <tr>
                        <td><?=$val['advert_id']?></td>
                        <td><?=$val['brand']?></td>
                        <td><?=$val['model']?></td>
                        <td><?=$val['year']?></td>
                        <td><?=$val['number_kilo']?> Km</td>
                        <td><?=$val['price']?> €</td>
                        <td><a href="deleteAdvert-<?=$val['advert_id']?>" class="btn btn-danger">Supprimer</a></td>
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

    } // adminAdvert($_value)

} // class VAdvert

?>
