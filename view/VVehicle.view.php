<?php
/**
 * Class VVehicle de type Vue pour l'affichage de l'accueil
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VVehicle
{
    /**
     * VVehicle constructor.
     */
    public function __construct() {}

    /**
     * VVehicle destructor.
     */
    public function __destruct() {}

    /**
     * @param $_value
     * @return void
     * Affiche le formulaire de la page d'accueil
     */
    public function showFilter($_value)
    {
        ?>
    <div class="row align-items-end" style="height:20vh">
        <div class="col-12">
            <h1>Filtrer vos annonces</h1>
        </div>
    </div>

    <form action="adverts" method="post" class="row align-items-center form-filter" >

            <div class="col-lg-2 col-sm-12">
                <div class="form-group">
                    <select class="form-select" id="brand_filter" name="BRAND" style="font-size: 1rem">
                        <option selected>Marque</option>
                        <?php foreach ($_value['BRAND'] as $val)
                        {
                            echo '<option value="'.$val['brand'].'">'.ucfirst($val['brand']).'</option>';
                        } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-sm-12">
                <div class="form-group">
                    <select class="form-select" id="model_filter" name="MODEL" style="font-size: 1rem">
                        <option selected>Modèle</option>
                        <?php foreach ($_value['MODEL'] as $val)
                        {
                            echo '<option value="'.$val['model'].'">'.ucfirst($val['model']).'</option>';
                        } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text devise">€</span>
                        </div>
                        <input type="text" name="PRICE_MAX" placeholder="Prix max" class="form-control" aria-label="Amount (to the nearest dollar)">
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-12">
                <div class="form-group">
                    <select class="form-select" id="fuel_filter" name="FUEL" style="font-size: 1rem">
                        <option selected>Carburant</option>
                        <?php foreach ($_value['FUEL'] as $val)
                        {
                            echo '<option value="'.$val['fuel'].'">'.ucfirst($val['fuel']).'</option>';
                        } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-search" value="Lancer la recherche">
                </div>
            </div>

    </form>
<?php
        return;

    } // showFilter($_value)

    /**
     * @param $_value
     * Affiche la partie modèle du formulaire de sélection pour l'AJAX
     */
    public function showFilterModel($_value)
    {
        ?>
            <option>Modèle</option>
            <?php foreach ($_value as $val)
            {
                echo '<option value="'.$val['model'].'" selected>'.ucfirst($val['model']).'</option>';
            } ?>
        <?php

        return;

    } // showFilterModel($_value)

    /**
     * @param $_value
     * Affiche la partie marque du formulaire de sélection pour l'AJAX
     */
    public function showFilterBrand($_value)
    {
        ?>
            <option>Marque</option>
            <?php foreach ($_value as $val)
            {
                echo '<option value="'.$val['brand'].'" selected>'.ucfirst($val['brand']).'</option>';
            } ?>
        <?php

        return;

    } // showFilterBrand($_value)

} // class VVehicle

?>
